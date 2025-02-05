<?php
// Database connection
$host = 'localhost';
$db = 'jobportal';
$user = 'admin';
$pass = 'Ister1!';

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
