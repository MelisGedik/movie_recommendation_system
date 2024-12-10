<?php
session_start();
include '../includes/db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch the reviews written by the logged-in user
$sql = "SELECT r.rating, r.review, r.timestamp, m.title AS movie_title, m.poster_url 
        FROM ratings r
        JOIN movies m ON r.movie_id = m.id
        WHERE r.user_id = ? ORDER BY r.timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Check if the query returns results
if ($result === false) {
    echo "Error executing the query: " . $stmt->error;
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Reviews</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?> <!-- Include the navbar -->

    <div class="my-reviews">
        <h1>My Reviews</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="reviews-list">
                <?php while ($review = $result->fetch_assoc()): ?>
                    <div class="review-card">
                        <img src="../<?php echo htmlspecialchars($review['poster_url']); ?>" alt="Movie Poster" class="movie-poster">
                        <h3><?php echo htmlspecialchars($review['movie_title']); ?></h3>
                        <p><strong>Rating:</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                        <p><strong>Review:</strong> <?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
                        <p><small>Reviewed on: <?php echo date('F j, Y, g:i a', strtotime($review['timestamp'])); ?></small></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>You haven't written any reviews yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>
