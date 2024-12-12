<?php
// index.php
session_start();
include 'includes/db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: pages/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's selected movies and their genres
$sql = "SELECT m.genre FROM user_movie_selections ums
        JOIN movies m ON ums.movie_id = m.id
        WHERE ums.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user_genres = [];
while ($row = $result->fetch_assoc()) {
    $genres = explode(",", $row['genre']); // Assuming genres are comma-separated
    foreach ($genres as $genre) {
        $genre = trim($genre);
        if (!isset($user_genres[$genre])) {
            $user_genres[$genre] = 0;
        }
        $user_genres[$genre]++;
    }
}

// Sort genres by popularity
arsort($user_genres);
$top_genres = array_keys($user_genres);

// Fetch recommended movies based on top genres, excluding watched movies
$placeholders = implode(",", array_fill(0, count($top_genres), "?"));
$sql = "SELECT * FROM movies WHERE genre IN ($placeholders) AND id NOT IN (
            SELECT movie_id FROM user_movie_selections WHERE user_id = ?
        ) AND id NOT IN (
            SELECT movie_id FROM ratings WHERE user_id = ?
        ) LIMIT 10";
$stmt = $conn->prepare($sql);

$params = array_merge($top_genres, [$user_id, $user_id]);
$stmt->bind_param(str_repeat("s", count($top_genres)) . "ii", ...$params);
$stmt->execute();
$result = $stmt->get_result();

$recommended_movies = $result->fetch_all(MYSQLI_ASSOC);

// If less than 10 recommendations, fetch additional movies to fill the list
if (count($recommended_movies) < 10) {
    $remaining_slots = 10 - count($recommended_movies);
    $sql = "SELECT * FROM movies WHERE id NOT IN (
                SELECT movie_id FROM user_movie_selections WHERE user_id = ?
            ) AND id NOT IN (
                SELECT movie_id FROM ratings WHERE user_id = ?
            ) AND genre NOT IN ($placeholders) LIMIT $remaining_slots";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $additional_movies = $result->fetch_all(MYSQLI_ASSOC);
    $recommended_movies = array_merge($recommended_movies, $additional_movies);
}

// Fetch top-rated movies
$sql = "SELECT * FROM movies ORDER BY rating_avg DESC LIMIT 5";
$result = $conn->query($sql);
$top_rated_movies = $result->fetch_all(MYSQLI_ASSOC);
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

<h2>Recommended Movies</h2>
<div class="movie-list">
    <?php if (!empty($recommended_movies)) { ?>
        <?php foreach ($recommended_movies as $movie) { ?>
            <div class="movie-card">
                <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                <p>Average Rating: <?php echo htmlspecialchars($movie['rating_avg']); ?></p>
                <a href="pages/movie_details.php?id=<?php echo $movie['id']; ?>">View Details</a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No recommendations found.</p>
    <?php } ?>
</div>

<h2>Top-Rated Movies</h2>
<div class="movie-list">
    <?php foreach ($top_rated_movies as $movie) { ?>
        <div class="movie-card">
            <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
            <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
            <p>Average Rating: <?php echo htmlspecialchars($movie['rating_avg']); ?></p>
            <a href="pages/movie_details.php?id=<?php echo $movie['id']; ?>">View Details</a>
        </div>
    <?php } ?>
</div>

</body>
</html>
