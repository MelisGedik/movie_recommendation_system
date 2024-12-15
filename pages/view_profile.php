<?php
session_start();
include '../includes/db_connect.php';

// Ensure a valid user ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid profile ID.";
    exit();
}

$profile_id = intval($_GET['id']); // ID of the user whose profile is being viewed

// Fetch the user's profile details
$sql = "SELECT username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();

// Fetch user stats: Movies watched and reviews submitted
$watched_sql = "SELECT COUNT(DISTINCT movie_id) AS watched_count FROM ratings WHERE user_id = ?";
$watched_stmt = $conn->prepare($watched_sql);
$watched_stmt->bind_param("i", $profile_id);
$watched_stmt->execute();
$watched_result = $watched_stmt->get_result();
$watched_count = $watched_result->fetch_assoc()['watched_count'] ?? 0;

$review_sql = "SELECT COUNT(id) AS review_count FROM ratings WHERE user_id = ? AND review IS NOT NULL AND review != ''";
$review_stmt = $conn->prepare($review_sql);
$review_stmt->bind_param("i", $profile_id);
$review_stmt->execute();
$review_result = $review_stmt->get_result();
$review_count = $review_result->fetch_assoc()['review_count'] ?? 0;

// Fetch the user's reviews and ratings
$comments_sql = "SELECT r.rating, r.review, m.title AS movie_title, m.poster_url 
                 FROM ratings r
                 JOIN movies m ON r.movie_id = m.id
                 WHERE r.user_id = ? AND r.review IS NOT NULL AND r.review != '' 
                 ORDER BY r.timestamp DESC";
$comments_stmt = $conn->prepare($comments_sql);
$comments_stmt->bind_param("i", $profile_id);
$comments_stmt->execute();
$comments_result = $comments_stmt->get_result();

// Check if the logged-in user is already friends with this user
$current_user_id = $_SESSION['user_id'] ?? null;

$friendship_sql = "SELECT status FROM friends WHERE 
                  (user_id = ? AND friend_id = ?) OR 
                  (user_id = ? AND friend_id = ?)";
$friendship_stmt = $conn->prepare($friendship_sql);
$friendship_stmt->bind_param("iiii", $current_user_id, $profile_id, $profile_id, $current_user_id);
$friendship_stmt->execute();
$friendship_result = $friendship_stmt->get_result();
$friendship_status = $friendship_result->fetch_assoc()['status'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="profile-container">
        <h1><?php echo htmlspecialchars($user['username']); ?>'s Profile</h1>
        <div class="profile-card">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Member Since:</strong> <?php echo htmlspecialchars(date("F j, Y", strtotime($user['created_at']))); ?></p>
            <p><strong>Movies Watched:</strong> <?php echo $watched_count; ?></p>
            <p><strong>Reviews Submitted:</strong> <?php echo $review_count; ?></p>
        </div>

        <!-- Friendship Status -->
        <?php if ($current_user_id && $current_user_id != $profile_id): ?>
            <div class="friendship-actions">
                <?php if ($friendship_status === 'accepted'): ?>
                    <p>You are friends with <?php echo htmlspecialchars($user['username']); ?>.</p>
                <?php elseif ($friendship_status === 'pending'): ?>
                    <p>Friend request is pending.</p>
                <?php else: ?>
                    <form method="POST" action="send_friend_request.php">
                        <input type="hidden" name="friend_id" value="<?php echo $profile_id; ?>">
                        <button type="submit" class="button">Send Friend Request</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- User Reviews Section -->
        <div class="reviews-section">
            <h2><?php echo htmlspecialchars($user['username']); ?>'s Reviews</h2>
            <?php if ($comments_result->num_rows > 0): ?>
                <div class="reviews-list">
                    <?php while ($review = $comments_result->fetch_assoc()): ?>
                        <div class="review-card">
                            <img src="../<?php echo htmlspecialchars($review['poster_url']); ?>" alt="Movie Poster" class="movie-poster">
                            <h3><?php echo htmlspecialchars($review['movie_title']); ?></h3>
                            <p><strong>Rating:</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                            <div class="review-container">
                                <p><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>This user hasn't written any reviews yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
