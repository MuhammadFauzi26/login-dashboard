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
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();

// Store result
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows == 1) {
    // Bind result variables
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    
    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Password is correct
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;
        header("Location: home.html");
        exit;
    } else {
        // Password is incorrect
        echo "<p>email or password salah.</p>";
        echo '<a href="login.html">Try again</a>';
    }
} else {
    // Email does not exist
    echo "<p>email or password salah.</p>";
    echo '<a href="login.html">Try again</a>';
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
