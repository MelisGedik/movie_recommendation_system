<?php
session_start();
include '../includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$search_results = [];

// Handle search query
if (isset($_POST['search'])) {
    $search = "%" . $_POST['username'] . "%";
    $sql = "SELECT id, username FROM users 
            WHERE username LIKE ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $search, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Users</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="center-content">
        <h1>Search Users</h1>
        <form method="POST" action="" class="search-form">
            <input type="text" name="username" placeholder="Search by username" required>
            <button type="submit" name="search" class="button">Search</button>
        </form>

        <?php if (!empty($search_results)): ?>
            <ul class="search-results">
                <?php foreach ($search_results as $user): ?>
                    <li>
                        <?php echo htmlspecialchars($user['username']); ?>
                        <form method="POST" action="send_request.php">
                            <input type="hidden" name="friend_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="button">Send Friend Request</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif (isset($_POST['search'])): ?>
            <p>No users found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
