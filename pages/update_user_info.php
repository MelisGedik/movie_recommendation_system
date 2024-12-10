<?php
session_start();
include '../includes/db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // Update the user info in the database
    $sql = "UPDATE users SET role = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $role, $status, $user_id);
    
    if ($stmt->execute()) {
        echo "User info updated successfully!";
    } else {
        echo "Error updating user: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User Info</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="admin-action">
        <h1>Update User Info</h1>
        <form action="update_user_info.php" method="POST">
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" required><br>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select><br>

            <button type="submit">Update User</button>
        </form>
    </div>
</body>
</html>
