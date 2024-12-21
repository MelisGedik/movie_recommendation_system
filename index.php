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
$sql_pending_requests = "SELECT COUNT(*) AS pending_count FROM friends WHERE friend_id = ? AND status = 'pending'";
$stmt_pending_requests = $conn->prepare($sql_pending_requests);
$stmt_pending_requests->bind_param("i", $user_id);
$stmt_pending_requests->execute();
$result_pending_requests = $stmt_pending_requests->get_result();

if ($row = $result_pending_requests->fetch_assoc()) {
    $pending_requests = $row['pending_count'];
} else {
    $pending_requests = 0;
}
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
    <style>
        /* Popup Styling */
        #friendRequestPopup {
            display: none;
            position: fixed;
            top: 80px; /* Adjusted position to be below the navbar */
            right: 20px;
            background-color: #444;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            text-align: center;
        }
        #friendRequestPopup button {
            background-color: #ff5555;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 10px;
            display: inline-block;
        }
        #friendRequestPopup button:hover {
            background-color: #ff3333;
        }
        #friendRequestPopup a {
            background-color: #23a2f6;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        #friendRequestPopup a:hover {
            background-color: #1845ad;
        }
    </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<h1>Welcome to the Movie Recommendation System</h1>

<!-- Friend Request Popup -->
<?php if ($pending_requests > 0): ?>
<div id="friendRequestPopup">
    <p>You have <?php echo $pending_requests; ?> pending friend request(s)!</p>
    <a href="pages/manage_requests.php">Manage Requests</a>
    <button onclick="closePopup()">Close</button>
</div>
<?php endif; ?>


<script>
    // Show popup on page load
    window.onload = function() {
        var popup = document.getElementById('friendRequestPopup');
        if (popup) {
            popup.style.display = 'block';
        }
    };

    // Close popup
    function closePopup() {
        var popup = document.getElementById('friendRequestPopup');
        if (popup) {
            popup.style.display = 'none';
        }
    }
</script>

<!-- Recommended Movies -->
<h2>Recommended Movies</h2>
<div class="movie-list">
    <?php if (!empty($recommended_movies)) { ?>
        <?php foreach ($recommended_movies as $movie) { ?>
            <div class="movie-card">
                <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Movie Poster">
                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                <p>Average Rating: <?php echo htmlspecialchars($movie['rating_avg']); ?></p>
                <a href="pages/movie_details.php?id=<?php echo $movie['id']; ?>" class="button">View Details</a>
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
            <a href="pages/movie_details.php?id=<?php echo $movie['id']; ?>" class="button">View Details</a>
        </div>
    <?php } ?>
</div>


</body>
</html>
