<?php
session_start();
include '../includes/db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch matching usernames for search
if (isset($_GET['search_username'])) {
    $search = "%" . $_GET['search_username'] . "%";
    $sql = "SELECT username FROM users WHERE username LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $usernames = [];
    while ($row = $result->fetch_assoc()) {
        $usernames[] = $row['username'];
    }
    echo json_encode($usernames);
    exit();
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Fetch the user ID by username
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Update user role in the database
        $update_sql = "UPDATE users SET role = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $role, $user_id);

        if ($update_stmt->execute()) {
            $success = "User role updated successfully!";
        } else {
            $error = "Error updating user: " . $update_stmt->error;
        }
    } else {
        $error = "User not found.";
    }
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $username = $_POST['username'];

    // Fetch the user ID by username
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

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
    } else {
        $error = "User not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User Info</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function searchUsernames() {
            const searchInput = document.getElementById('username_search').value;
            if (searchInput.trim() === '') return;

            fetch(`update_user_info.php?search_username=${searchInput}`)
                .then(response => response.json())
                .then(data => {
                    const resultsContainer = document.getElementById('search_results');
                    resultsContainer.innerHTML = '';
                    data.forEach(username => {
                        const listItem = document.createElement('li');
                        listItem.textContent = username;
                        resultsContainer.appendChild(listItem);
                    });
                })
                .catch(error => console.error('Error fetching usernames:', error));
        }
    </script>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="admin-action">
        <h1>Update or Delete User</h1>

        <?php if (isset($success)): ?>
            <p style="color: green;">
                <?php echo htmlspecialchars($success); ?>
            </p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <!-- Search Usernames -->
        <div class="form-section">
            <h2>Search Usernames</h2>
            <input type="text" id="username_search" placeholder="Search usernames...">
            <button type="button" onclick="searchUsernames()">Search</button>
            <ul id="search_results"></ul>
        </div>

        <!-- Update User Role Form -->
        <div class="form-section">
            <h2>Update User Role</h2>
            <form action="update_user_info.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>

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
                <label for="username_delete">Username:</label>
                <input type="text" id="username_delete" name="username" required><br>

                <button type="submit" name="delete_user" class="button remove-button">Delete User</button>
            </form>
        </div>
    </div>
</body>
</html>
