<?php
session_start();
include '../includes/db_connect.php';

$request_id = $_POST['request_id'];
$action = $_POST['action'];

if ($action == 'accept') {
    $status = 'accepted';
} elseif ($action == 'reject') {
    $status = 'rejected';
}

$sql = "UPDATE friends SET status = ?, updated_at = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $request_id);

if ($stmt->execute()) {
    echo "Request successfully " . $status . ".";
} else {
    echo "Error updating the request.";
}
?>
<a href="manage_requests.php">Back to Requests</a>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
</body>
