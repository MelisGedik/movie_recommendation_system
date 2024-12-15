<?php
session_start();
include '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Current user
$friend_id = $_POST['friend_id'] ?? null;

if ($friend_id) {
    // Check if a request already exists
    $sql = "SELECT * FROM friends WHERE user_id = ? AND friend_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $friend_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Send new friend request
        $insert = "INSERT INTO friends (user_id, friend_id, status, created_at, updated_at)
                   VALUES (?, ?, 'pending', NOW(), NOW())";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("ii", $user_id, $friend_id);
        $stmt->execute();

        echo "Friend request sent!";
    } else {
        echo "A request already exists.";
    }
} else {
    echo "Invalid friend ID.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Friend Request</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
</body>

<a href="search_users.php">Back to Search</a>

