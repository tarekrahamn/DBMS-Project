<?php
session_start(); // Start the session
session_destroy(); // Destroy the session
header("Location: index.php"); // Redirect to index.php
exit(); // Ensure no further code is executed
?>
