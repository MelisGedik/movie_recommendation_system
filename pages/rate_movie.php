<?php
session_start();
include '../includes/session_check.php';
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $movie_id = intval($_POST['movie_id']);
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);

    if ($rating < 1 || $rating > 5) {
        echo "Invalid rating value.";
        exit();
    }

    $sql = "SELECT * FROM ratings WHERE user_id = ? AND movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE ratings SET rating = ?, review = ? WHERE user_id = ? AND movie_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isii", $rating, $review, $user_id, $movie_id);
    } else {
        $sql = "INSERT INTO ratings (user_id, movie_id, rating, review) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $user_id, $movie_id, $rating, $review);
    }

    if ($stmt->execute()) {
        $sql = "UPDATE movies SET rating_avg = (
                    SELECT AVG(rating) FROM ratings WHERE movie_id = ?
                ) WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $movie_id, $movie_id);
        $stmt->execute();

        echo "Rating submitted successfully.";
    } else {
        echo "Failed to submit rating: " . $stmt->error;
    }
}
?>
<a href="movie_details.php?id=<?php echo $movie_id; ?>">Back to Movie</a>
