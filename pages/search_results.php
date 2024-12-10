<?php
session_start();
include '../includes/db_connect.php';

// Check if search query is provided
if (isset($_GET['query'])) {
    $search_query = "%" . $_GET['query'] . "%";  // Add wildcards for LIKE query

    // SQL query to search by movie name or genre
    $sql = "SELECT * FROM movies 
            WHERE title LIKE ? OR genre LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search_query, $search_query);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "No search query provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?> <!-- Include the navbar -->

    <div class="search-results">
        <h1>Search Results</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="movie-list">
                <?php while ($movie = $result->fetch_assoc()): ?>
                    <div class="movie-card">
                        <img src="../<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <p>Release Date: <?php echo htmlspecialchars($movie['release_date']); ?></p>
                        <p><a href="movie_details.php?id=<?php echo $movie['id']; ?>">View Details</a></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No movies found matching your search.</p>
        <?php endif; ?>
    </div>

</body>
</html>
