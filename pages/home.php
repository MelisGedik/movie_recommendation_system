<?php
session_start();
include '../includes/session_check.php'; // Ensure user is logged in
include '../includes/db_connect.php'; // Database connection

// Example content
echo "Welcome to your profile, " . $_SESSION['username'] . "!";
?>

<link rel="stylesheet" href="../css/style.css">
<div class="navbar">
    <div class="navbar-left">
        <a href="../index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="watchlist.php">My Watchlist</a>
        <?php endif; ?>
    </div>
    <div class="navbar-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        <?php endif; ?>
    </div>
</div>