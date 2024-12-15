<?php
session_start();
include '../includes/db_connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch friends (accepted status)
$sql = "SELECT u.username AS friend_username, u.id AS friend_id
        FROM friends f
        JOIN users u ON (f.friend_id = u.id OR f.user_id = u.id)
        WHERE (f.user_id = ? OR f.friend_id = ?) 
        AND f.status = 'accepted' 
        AND u.id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Friends</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="center-content">
        <div class="header-action">
            <h1>My Friends</h1>
            <a href="search_users.php" class="button">Search Users</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <ul class="friends-list">
                <?php while ($friend = $result->fetch_assoc()): ?>
                    <li class="friend-card">
                        <span><?php echo htmlspecialchars($friend['friend_username']); ?></span>
                        <a href="view_profile.php?id=<?php echo $friend['friend_id']; ?>" class="button">View Profile</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>You have no friends yet. Start sending some friend requests!</p>
        <?php endif; ?>
    </div>
    <div class="manage-requests">
            <h4>Pending Friend Requests</h4>
            <a href="manage_requests.php" class="button">Manage Requests</a>
    </div>
</body>
</html>
