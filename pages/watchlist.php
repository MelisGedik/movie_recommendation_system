<?php
session_start();
include '../includes/db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user ID from session

// Fetch the watchlist for the logged-in user
$sql = "SELECT movies.* FROM watchlist 
        JOIN movies ON watchlist.movie_id = movies.id 
        WHERE watchlist.user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error); // Debugging: Show error if the statement fails to prepare
}

$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Execution Error: " . $stmt->error); // Debugging: Show error if the execution fails
}

$result = $stmt->get_result();
if (!$result) {
    die("Result Error: " . $conn->error); // Debugging: Show error if fetching the result fails
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Watchlist</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <h1>Your Watchlist</h1>
    <div class="movie-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($movie = $result->fetch_assoc()): ?>
            <div class="movie-card">
                <img src="../<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                <p>Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>

                <!-- Display average rating -->
                <?php
                $rating_sql = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE movie_id = ?";
                $rating_stmt = $conn->prepare($rating_sql);
                $rating_stmt->bind_param("i", $movie['id']);
                $rating_stmt->execute();
                $rating_result = $rating_stmt->get_result();
                $rating_data = $rating_result->fetch_assoc();
                $average_rating = $rating_data['avg_rating'] ? round($rating_data['avg_rating'], 1) : 'Not rated yet';
                ?>
                <p>Average Rating: <?php echo $average_rating; ?> / 5</p>

                <!-- Rating Form -->
                <form action="rate_movie.php" method="POST">
                    <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>" />
                    <label for="rating">Rate this movie:</label>
                    <select name="rating" id="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select><br>
                    <label for="review">Leave a review:</label><br>
                    <textarea name="review" id="review" rows="4" cols="50"></textarea><br>
                    <button type="submit">Submit Rating</button>
                </form>

                <!-- Remove from Watchlist -->
                <form method="POST" action="remove_from_watchlist.php">
                    <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                    <button type="submit">Remove from Watchlist</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Your watchlist is empty.</p>
    <?php endif; ?>
    </div>

</body>
</html>
