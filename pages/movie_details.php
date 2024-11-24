<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid movie ID.";
    exit();
}

$movie_id = intval($_GET['id']);
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $movie = $result->fetch_assoc();
} else {
    echo "Movie not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($movie['title']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?> <!-- Include the navbar -->

    <div class="movie-details">
        <h1><?php echo htmlspecialchars($movie['title']); ?></h1>

        <!-- Display Movie Poster -->
        <div class="movie-poster">
            <img src="../<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
        </div>

        <!-- Movie Information -->
        <div class="movie-info">
            <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
            <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($movie['description']); ?></p>
            <p><strong>Average Rating:</strong> <?php echo htmlspecialchars($movie['rating_avg']); ?></p>
        </div>

        <!-- Add to Watchlist Button -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="add_to_watchlist.php">
                <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                <button type="submit">Add to Watchlist</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Login</a> to add this movie to your watchlist.</p>
        <?php endif; ?>
    </div>
</body>
</html>
