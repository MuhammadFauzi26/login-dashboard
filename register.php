<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate passwords
if ($password !== $confirm_password) {
    echo "<p>Passwords sudah terpakai.</p>";
    echo '<a href="register.html">Go back</a>';
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

// Execute the statement
if ($stmt->execute()) {
    // Registration successful, redirect to home.html
    header("Location: login.html");
    exit();
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
    echo '<a href="register.html">Go back</a>';
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
