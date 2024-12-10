<?php
session_start();
include '../includes/db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Movie Statistics
// Total Movies
$total_movies_sql = "SELECT COUNT(*) AS total_movies FROM movies";
$total_movies_result = $conn->query($total_movies_sql);
$total_movies = $total_movies_result->fetch_assoc()['total_movies'];

// Movies added in the last 7 days
$recent_movies_sql = "SELECT COUNT(*) AS recent_movies FROM movies WHERE release_date > CURDATE() - INTERVAL 7 DAY";
$recent_movies_result = $conn->query($recent_movies_sql);
$recent_movies = $recent_movies_result->fetch_assoc()['recent_movies'];

// Movies by Genre
$genre_sql = "SELECT genre, COUNT(*) AS genre_count FROM movies GROUP BY genre";
$genre_result = $conn->query($genre_sql);
$genres = [];
while ($row = $genre_result->fetch_assoc()) {
    $genres[] = $row;
}

// User Statistics
// Total Users
$total_users_sql = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($total_users_sql);
$total_users = $total_users_result->fetch_assoc()['total_users'];

// Recent User Sign-Ups
$recent_users_sql = "SELECT username, email, created_at FROM users ORDER BY created_at DESC LIMIT 5";
$recent_users_result = $conn->query($recent_users_sql);
$recent_users = [];
while ($row = $recent_users_result->fetch_assoc()) {
    $recent_users[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>

        <!-- Movie Statistics -->
        <section class="stats">
            <div class="stat-box">
                <h2>Total Movies</h2>
                <p><?php echo $total_movies; ?></p>
            </div>
        </section>

        <!-- Movies by Genre Chart -->
        <section class="chart-section">
            <h2>Movies by Genre</h2>
            <canvas id="genreChart" style="max-width: 600px; width: 100%; height: 300px; margin: 0 auto;"></canvas>
            <script>
                var ctx = document.getElementById('genreChart').getContext('2d');
                var genreChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode(array_column($genres, 'genre')); ?>,
                        datasets: [{
                            label: 'Movies by Genre',
                            data: <?php echo json_encode(array_column($genres, 'genre_count')); ?>,
                            backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A1FF33'],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true, // Make the chart responsive
                        maintainAspectRatio: true, // Maintain aspect ratio, prevent stretching
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        </section>


        <!-- User Statistics -->
        <section class="stats">
            <div class="stat-box">
                <h2>Total Users</h2>
                <p><?php echo $total_users; ?></p>
            </div>
        </section>

        <!-- Recent Users -->
        <section class="recent-users">
            <h2>Recent User Sign-Ups</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Sign Up Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
