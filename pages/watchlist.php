<?php
session_start();
include '../includes/session_check.php';
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch watched movies
$watched_sql = "SELECT movies.*, ratings.rating, ratings.review FROM ratings 
                JOIN movies ON ratings.movie_id = movies.id 
                WHERE ratings.user_id = ?";
$watched_stmt = $conn->prepare($watched_sql);
$watched_stmt->bind_param("i", $user_id);
$watched_stmt->execute();
$watched_result = $watched_stmt->get_result();

// Fetch not watched movies
$not_watched_sql = "SELECT movies.* FROM watchlist 
                    JOIN movies ON watchlist.movie_id = movies.id 
                    WHERE watchlist.user_id = ? AND watchlist.movie_id NOT IN 
                    (SELECT movie_id FROM ratings WHERE user_id = ?)";
$not_watched_stmt = $conn->prepare($not_watched_sql);
$not_watched_stmt->bind_param("ii", $user_id, $user_id);
$not_watched_stmt->execute();
$not_watched_result = $not_watched_stmt->get_result();
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
    <div class="progress-bar">
        <p>Progress: 
            <?php
            $total_movies = $watched_result->num_rows + $not_watched_result->num_rows;
            $progress = ($total_movies > 0) ? round(($watched_result->num_rows / $total_movies) * 100) : 0;
            echo $progress . '%';
            ?>
        </p>
        <div class="progress" style="background-color: #ddd; height: 20px; border-radius: 10px; overflow: hidden;">
            <div style="width: <?php echo $progress; ?>%; height: 100%; background-color: #4caf50;"></div>
        </div>
    </div>

    <div class="watchlist-section">
        <h2>Watched Movies</h2>
        <div class="movie-list">
            <?php if ($watched_result->num_rows > 0): ?>
                <?php while ($movie = $watched_result->fetch_assoc()): ?>
                    <div class="movie-card">
                        <img src="../<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <p>Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>
                        <p>Your Rating: <?php echo htmlspecialchars($movie['rating']); ?></p>
                        <p>Your Review: <?php echo htmlspecialchars($movie['review']); ?></p>
                        <a class="button" href="edit_review.php?movie_id=<?php echo $movie['id']; ?>">Edit Review</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You haven't rated any movies yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="watchlist-section">
        <h2>Not Watched Movies</h2>
        <div class="movie-list">
            <?php if ($not_watched_result->num_rows > 0): ?>
                <?php while ($movie = $not_watched_result->fetch_assoc()): ?>
                    <div class="movie-card">
                        <img src="../<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <p>Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>
                        <form method="POST" action="mark_as_watched.php">
                            <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                            <div class="rating-review-container">
                                <label for="rating-<?php echo $movie['id']; ?>">Rating:</label>
                                <select name="rating" id="rating-<?php echo $movie['id']; ?>" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <label for="review-<?php echo $movie['id']; ?>">Review:</label>
                                <textarea name="review" id="review-<?php echo $movie['id']; ?>"></textarea>
                            </div>
                            <button type="submit" class="button">Mark as Watched</button>
                        </form>

                        <form method="POST" action="remove_from_watchlist.php">
                            <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                            <button type="submit" class="button remove-button">Remove</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Your watchlist is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
