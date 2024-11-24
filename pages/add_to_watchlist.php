<?php
session_start();
include '../includes/session_check.php';
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $movie_id = intval($_POST['movie_id']);

    $sql = "SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "This movie is already in your watchlist.";
    } else {
        $sql = "INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $movie_id);
        if ($stmt->execute()) {
            $message = "Movie added to your watchlist.";
        } else {
            $message = "Failed to add the movie: " . $stmt->error;
        }
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
        <p><a href="../index.php">Go back to Homepage</a> or <a href="watchlist.php">View Your Watchlist</a>.</p>
    </div>
</body>
</html>
