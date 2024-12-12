<?php
session_start();
include '../includes/session_check.php';
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['movie_id']) || !isset($_POST['rating'])) {
        die("Movie ID or rating not provided.");
    }

    $movie_id = intval($_POST['movie_id']);
    $user_id = $_SESSION['user_id'];
    $rating = intval($_POST['rating']);
    $review = isset($_POST['review']) ? trim($_POST['review']) : null;

    if ($rating < 1 || $rating > 5) {
        $message = "Invalid rating value. Please provide a rating between 1 and 5.";
    } else {
        // Check if the movie is already marked as watched
        $check_sql = "SELECT * FROM ratings WHERE user_id = ? AND movie_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $user_id, $movie_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = "This movie is already marked as watched.";
        } else {
            // Mark as watched by adding a rating and review
            $insert_sql = "INSERT INTO ratings (user_id, movie_id, rating, review) VALUES (?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iiis", $user_id, $movie_id, $rating, $review);

            if ($insert_stmt->execute()) {
                $message = "Movie marked as watched successfully!";
            } else {
                $message = "Failed to mark the movie as watched: " . $insert_stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark as Watched</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="confirmation-message">
        <h1><?php echo htmlspecialchars($message); ?></h1>
        <p>
            <a href="../index.php" class="button">Go Back to Homepage</a>
            <a href="watchlist.php" class="button">View Your Watchlist</a>
        </p>
    </div>
</body>
</html>
