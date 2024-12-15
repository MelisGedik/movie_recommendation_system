<?php
session_start();
include '../includes/db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    // Update user role in the database
    $sql = "UPDATE users SET role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $role, $user_id);
    
    if ($stmt->execute()) {
        $success = "User info updated successfully!";
    } else {
        $error = "Error updating user: " . $stmt->error;
    }
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Begin transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Step 1: Delete related records from user_movie_selections
        $delete_movies_sql = "DELETE FROM user_movie_selections WHERE user_id = ?";
        $delete_movies_stmt = $conn->prepare($delete_movies_sql);
        $delete_movies_stmt->bind_param("i", $user_id);
        $delete_movies_stmt->execute();

        // Step 2: Delete related ratings if they exist
        $delete_ratings_sql = "DELETE FROM ratings WHERE user_id = ?";
        $delete_ratings_stmt = $conn->prepare($delete_ratings_sql);
        $delete_ratings_stmt->bind_param("i", $user_id);
        $delete_ratings_stmt->execute();

        // Step 3: Delete user from users table
        $delete_user_sql = "DELETE FROM users WHERE id = ?";
        $delete_user_stmt = $conn->prepare($delete_user_sql);
        $delete_user_stmt->bind_param("i", $user_id);
        $delete_user_stmt->execute();

        // Commit transaction
        $conn->commit();
        $success = "User and all related data deleted successfully!";
    } catch (mysqli_sql_exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error = "Error deleting user: " . $e->getMessage();
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
        <h1>Update or Delete User</h1>

        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Update User Role Form -->
        <div class="form-section">
            <h2>Update User Role</h2>
            <form action="update_user_info.php" method="POST">
                <label for="user_id">User ID:</label>
                <input type="number" id="user_id" name="user_id" required><br>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select><br>

                <button type="submit" name="update_user" class="button">Update User</button>
            </form>
        </div>

        <!-- Delete User Form -->
        <div class="form-section">
            <h2>Delete User</h2>
            <form action="update_user_info.php" method="POST">
                <label for="user_id_delete">User ID:</label>
                <input type="number" id="user_id_delete" name="user_id" required><br>

                <button type="submit" name="delete_user" class="button remove-button">Delete User</button>
            </form>
        </div>
    </div>
</body>
</html>
