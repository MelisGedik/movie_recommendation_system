<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Use the password set during MySQL setup
$dbname = "movie_rec";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//U SHOULD CHANGE THE PASSWORD ON HERE TO YOUR OWN AND CHANGE THIS FILES NAME BACK TO "db_connect.php" so that the other files can read this one

?>
