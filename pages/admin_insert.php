<?php
include '../includes/db_connect.php';

// The plaintext password for the admin
$password = 'admin_password'; 

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert admin user into the database with hashed password
$sql = "INSERT INTO users (username, email, password, role) 
        VALUES ('admin', 'admin@example.com', ?, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashed_password); // Bind the hashed password
$stmt->execute();

echo "Admin user inserted successfully!";
?>
