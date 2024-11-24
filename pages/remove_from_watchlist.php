<?php
session_start();
include '../includes/session_check.php';
include '../includes/db_connect.php';

$message = ""; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $movie_id = intval($_POST['movie_id']);

    $sql = "DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);

    if ($stmt->execute()) {
        $message = "Movie removed from your watchlist.";
    } else {
        $message = "Failed to remove the movie.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Watchlist Update</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="confirmation-message">
        <h1><?php echo htmlspecialchars($message); ?></h1>
        <p><a href="watchlist.php">Go back to Watchlist</a></p>
    </div>
</body>
</html>
