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
