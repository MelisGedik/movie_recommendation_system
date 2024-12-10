<?php
session_start();
include '../includes/db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch movie details using the movie ID from GET
if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];

    // Fetch the movie from the database
    $sql = "SELECT * FROM movies WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If movie found, fetch movie details
    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "Movie not found!";
        exit();
    }
} else {
    echo "No movie ID provided!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle movie update logic
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $release_date = $_POST['release_date'];
    $description = trim($_POST['description']);
    $poster_url = $movie['poster_url']; // Keep existing poster URL by default

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

    // Update the movie details in the database
    $sql = "UPDATE movies SET title = ?, genre = ?, release_date = ?, description = ?, poster_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $title, $genre, $release_date, $description, $poster_url, $movie_id);
    
    if ($stmt->execute()) {
        echo "Movie updated successfully!";
    } else {
        echo "Error updating movie: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify Movie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="admin-action">
        <h1>Modify Movie</h1>
        <form action="modify_movie.php?movie_id=<?php echo $movie['id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Movie Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required><br>

            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($movie['genre']); ?>" required><br>

            <label for="release_date">Release Date:</label>
            <input type="date" id="release_date" name="release_date" value="<?php echo $movie['release_date']; ?>" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($movie['description']); ?></textarea><br>

            <label for="poster">Movie Poster:</label>
            <input type="file" id="poster" name="poster" accept="image/*"><br>

            <button type="submit">Update Movie</button>
        </form>
    </div>
</body>
</html>
