<?php
session_start();
include '../includes/db_connect.php';

// Fetch current user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

    // Update the user info
    $update_sql = "UPDATE users SET username = ?, email = ?" . ($new_password ? ", password = ?" : "") . " WHERE id = ?";
    $stmt = $conn->prepare($update_sql);

    if ($new_password) {
        $stmt->bind_param("sssi", $new_username, $new_email, $new_password, $user_id);
    } else {
        $stmt->bind_param("ssi", $new_username, $new_email, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['username'] = $new_username;
        $success = "Profile updated successfully!";
    } else {
        $error = "An error occurred: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="update-profile-container">
        <h1>Update Profile</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (isset($success)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

            <label for="password">New Password (leave blank to keep current):</label><br>
            <input type="password" id="password" name="password"><br><br>

            <button type="submit" class="button">Update Profile</button>
        </form>
    </div>
</body>
</html>
