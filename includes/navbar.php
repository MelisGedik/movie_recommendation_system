<!-- Navbar -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine the base path dynamically
$base_path = (basename(dirname($_SERVER['PHP_SELF'])) === 'pages') ? '../' : '';
?>
<div class="navbar">
    <div class="navbar-left">
        
        <!-- If the user is an admin, show admin tools -->
        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
            <a href="<?php echo $base_path; ?>pages/admin_dashboard.php">Admin Dashboard</a>
            <a href="<?php echo $base_path; ?>pages/add_movie.php">Add Movie</a>
            <a href="<?php echo $base_path; ?>pages/modify_movie_search.php">Modify Movie</a>
            <a href="<?php echo $base_path; ?>pages/update_user_info.php">Update User Info</a>
        <?php elseif (isset($_SESSION['user_id'])): ?>
            <!-- If the user is not an admin, show user tools -->
            <a href="<?php echo $base_path; ?>index.php">Home</a>
            <a href="<?php echo $base_path; ?>pages/watchlist.php">My Watchlist</a>
            <a href="<?php echo $base_path; ?>pages/profile.php">Profile</a>
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
        
        <!-- Search Form -->
        <form action="<?php echo $base_path; ?>pages/search_results.php" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Search by movie name or genre" required>
            <button type="submit">Search</button>
        </form>
    </div>
</div>
