<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="center-content">
        <h1>You have successfully logged out.</h1>
        <p>
            <a href="login.php" class="button">Log in again</a>
        </p>
    </div>
</body>
</html>
