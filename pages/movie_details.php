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

// Fetch the most recent 5 reviews for this movie
$review_sql = "SELECT rating, review, timestamp, user_id 
               FROM ratings 
               WHERE movie_id = ? 
               ORDER BY timestamp DESC 
               LIMIT 5";
$review_stmt = $conn->prepare($review_sql);
$review_stmt->bind_param("i", $movie_id);
$review_stmt->execute();
$review_result = $review_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movie['title']); ?> - Movie Details</title>
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

        <!-- Review Form -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <h3>Submit a Review</h3>
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
        <?php else: ?>
            <p><a href="login.php">Login</a> to submit a review.</p>
        <?php endif; ?>

        <!-- Display Reviews -->
        <h2>Recent Reviews</h2>
        <?php
        if ($review_result->num_rows > 0) {
            // Fetch and display each review
            while ($review = $review_result->fetch_assoc()) {
                // Get the username for the review
                $user_sql = "SELECT username FROM users WHERE id = ?";
                $user_stmt = $conn->prepare($user_sql);
                $user_stmt->bind_param("i", $review['user_id']);
                $user_stmt->execute();
                $user_result = $user_stmt->get_result();
                $user = $user_result->fetch_assoc();
                
                // Display the review
                echo "<div class='review'>";
                echo "<strong>" . htmlspecialchars($user['username']) . ":</strong>";
                echo "<p>Rating: " . htmlspecialchars($review['rating']) . "/5</p>";
                echo "<p>" . nl2br(htmlspecialchars($review['review'])) . "</p>";
                echo "<small>Reviewed on: " . date('F j, Y, g:i a', strtotime($review['timestamp'])) . "</small>";
                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "<p>No reviews yet. Be the first to review!</p>";
        }
        ?>
    </div>

</body>
</html>
