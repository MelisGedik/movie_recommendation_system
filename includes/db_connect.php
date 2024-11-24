<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "NuwzL5WpzWEN6v."; // Use the password set during MySQL setup
$dbname = "movie_rec";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
