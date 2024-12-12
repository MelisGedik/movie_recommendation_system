<?php
session_start();
include '../includes/session_check.php'; // Ensure user is logged in
include '../includes/db_connect.php'; // Database connection

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch user stats
$watched_sql = "SELECT COUNT(DISTINCT movie_id) AS watched_count FROM ratings WHERE user_id = ?";
$watched_stmt = $conn->prepare($watched_sql);
$watched_stmt->bind_param("i", $user_id);
$watched_stmt->execute();
$watched_result = $watched_stmt->get_result();
$watched_count = $watched_result->fetch_assoc()['watched_count'] ?? 0;

$review_sql = "SELECT COUNT(id) AS review_count FROM ratings WHERE user_id = ? AND review IS NOT NULL AND review != ''";
$review_stmt = $conn->prepare($review_sql);
$review_stmt->bind_param("i", $user_id);
$review_stmt->execute();
$review_result = $review_stmt->get_result();
$review_count = $review_result->fetch_assoc()['review_count'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="../index.php">Home</a>
            <a href="watchlist.php">My Watchlist</a>
        </div>
        <div class="navbar-right">
            <span>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</span>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="profile-container">
        <h1>Welcome to Your Profile</h1>

        <div class="profile-card">
            <h2>Profile Information</h2>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Member Since:</strong> <?php echo htmlspecialchars(date("F j, Y", strtotime($user['created_at']))); ?></p>
        </div>

        <div class="profile-stats">
            <div>
                <p>Movies Watched:</p>
                <strong><?php echo $watched_count; ?></strong>
            </div>
            <div>
                <p>Reviews Submitted:</p>
                <strong><?php echo $review_count; ?></strong>
            </div>
        </div>


        <div class="profile-actions">
            <h2>Actions</h2>
            <a href="update_user_profile.php" class="button">Update Profile</a>
            <a href="my_reviews.php" class="button">View My Reviews</a>
        </div>
    </div>
</body>
</html>
