<?php
include 'includes/db_connect.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <h1>Welcome to the Movie Recommendation System</h1>

    <h2>Top-Rated Movies</h2>
    <div class="movie-list">
        <?php
        $sql = "SELECT * FROM movies ORDER BY rating_avg DESC LIMIT 5";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while ($movie = $result->fetch_assoc()): ?>
                <div class="movie-card">
                    <img src="<?php echo $movie['poster_url']; ?>" alt="Movie Poster">
                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    <p>Average Rating: <?php echo htmlspecialchars($movie['rating_avg']); ?></p>
                    <a href="pages/movie_details.php?id=<?php echo $movie['id']; ?>">View Details</a>
                </div>
            <?php endwhile;
        else: ?>
            <p>No movies found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
