<?php
session_start();
include '../includes/db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$movies = []; // Initialize the $movies array
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the movie name from the form
    $movie_name = trim($_POST['movie_name']);

    // Fetch movies with the provided name
    $sql = "SELECT * FROM movies WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = '%' . $movie_name . '%'; // Use LIKE to match similar movie names
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the movies if any match
    if ($result->num_rows > 0) {
        while ($movie = $result->fetch_assoc()) {
            $movies[] = $movie;
        }
    } else {
        echo "No movies found with that name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search for Movie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <h1>Search for Movie to Modify</h1>
    <form action="modify_movie_search.php" method="POST">
        <label for="movie_name">Enter Movie Name:</label>
        <input type="text" id="movie_name" name="movie_name" required>
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($movies)): ?>
        <h2>Movies Found</h2>
        <form action="modify_movie.php" method="GET">
            <ul>
                <?php foreach ($movies as $movie): ?>
                    <li>
                        <input type="radio" id="movie_<?php echo $movie['id']; ?>" name="movie_id" value="<?php echo $movie['id']; ?>" required>
                        <label for="movie_<?php echo $movie['id']; ?>"><?php echo htmlspecialchars($movie['title']); ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit">Modify Selected Movie</button>
        </form>
    <?php endif; ?>
</body>
</html>
