<?php
session_start();
include '../includes/session_check.php';
include '../includes/db_connect.php';

if (!isset($_GET['movie_id'])) {
    die("Movie ID not provided.");
}

$movie_id = intval($_GET['movie_id']);
$user_id = $_SESSION['user_id'];

// Fetch existing review and rating
$sql = "SELECT ratings.rating, ratings.review, movies.title FROM ratings 
        JOIN movies ON ratings.movie_id = movies.id 
        WHERE ratings.user_id = ? AND ratings.movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No review found for the specified movie.");
}

$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_rating = intval($_POST['rating']);
    $new_review = trim($_POST['review']);

    $update_sql = "UPDATE ratings SET rating = ?, review = ? WHERE user_id = ? AND movie_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("isii", $new_rating, $new_review, $user_id, $movie_id);

    if ($update_stmt->execute()) {
        $success = "Your review has been updated successfully!";
    } else {
        $error = "Failed to update the review: " . $update_stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Review</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="center-content">
        <h1>Edit Review for <?php echo htmlspecialchars($data['title']); ?></h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (isset($success)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="rating">Rating (1-5):</label><br>
            <select id="rating" name="rating" required>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i == $data['rating']) ? 'selected' : ''; ?>>
                        <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select><br><br>

            <label for="review">Review:</label><br>
            <textarea id="review" name="review" rows="5" cols="50" required><?php echo htmlspecialchars($data['review']); ?></textarea><br><br>

            <button type="submit" class="button">Update Review</button>
        </form>
    </div>
</body>
</html>
