<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine the base path dynamically
$base_path = (basename(dirname($_SERVER['PHP_SELF'])) === 'pages') ? '../' : '';
?>
<div class="navbar">
    <div class="navbar-left">
        <a href="<?php echo $base_path; ?>index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?php echo $base_path; ?>pages/watchlist.php">My Watchlist</a>
        <?php endif; ?>
    </div>
    <div class="navbar-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="<?php echo $base_path; ?>pages/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?php echo $base_path; ?>pages/login.php">Login</a>
            <a href="<?php echo $base_path; ?>pages/signup.php">Signup</a>
        <?php endif; ?>
    </div>
</div>
