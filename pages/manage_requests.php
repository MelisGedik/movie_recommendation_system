<?php
session_start();
include '../includes/db_connect.php';

$user_id = $_SESSION['user_id'];

// Fetch pending requests
$sql = "SELECT f.id, u.username AS sender_username 
        FROM friends f
        JOIN users u ON f.user_id = u.id
        WHERE f.friend_id = ? AND f.status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Friend Requests</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="center-content">
        <h1>Pending Friend Requests</h1>
        <?php if ($result->num_rows > 0): ?>
            <ul class="requests-list">
                <?php while ($request = $result->fetch_assoc()): ?>
                    <li>
                        <?php echo htmlspecialchars($request['sender_username']); ?>
                        <form method="POST" action="handle_request.php">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="action" value="accept" class="button">Accept</button>
                            <button type="submit" name="action" value="reject" class="button remove-button">Reject</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No pending friend requests.</p>
        <?php endif; ?>
    </div>
</body>
</html>
