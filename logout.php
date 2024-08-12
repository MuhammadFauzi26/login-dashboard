<?php
session_start();
session_unset();
session_destroy();
header("Location: login.html");  // Redirect ke halaman login setelah logout
exit();
?>
