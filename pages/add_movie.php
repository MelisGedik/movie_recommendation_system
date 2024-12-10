<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
include '../includes/db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $release_date = $_POST['release_date'];
    $description = trim($_POST['description']);
    $poster_url = ''; // Default value for image URL

    // Handle file upload (movie poster)
    if ($_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['poster']['tmp_name'];
        $file_name = basename($_FILES['poster']['name']);
        $upload_dir = '../uploads/';
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($tmp_name, $file_path)) {
            $poster_url = 'uploads/' . $file_name;
        } else {
            echo "Error uploading file.";
        }
    }

    // Insert the new movie into the database
    $sql = "INSERT INTO movies (title, genre, release_date, description, poster_url) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $genre, $release_date, $description, $poster_url);
    
    if ($stmt->execute()) {
        echo "Movie added successfully!";
    } else {
        echo "Error adding movie: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Movie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="admin-action">
        <h1>Add New Movie</h1>
        <form action="add_movie.php" method="POST" enctype="multipart/form-data">
            <label for="title">Movie Title:</label>
            <input type="text" id="title" name="title" required><br>

            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required><br>

            <label for="release_date">Release Date:</label>
            <input type="date" id="release_date" name="release_date" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="poster">Movie Poster:</label>
            <input type="file" id="poster" name="poster" accept="image/*"><br>

            <button type="submit">Add Movie</button>
        </form>
    </div>
</body>
</html>
