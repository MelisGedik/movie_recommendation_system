<?php
// signup.php
session_start();
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $selected_movies = isset($_POST['movies']) ? $_POST['movies'] : [];

    if (count($selected_movies) < 7 || count($selected_movies) > 10) {
        $error = "Please select between 7 and 10 movies.";
    } else {
        // Check if the email is already registered
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already in use.";
        } else {
            // Insert new user
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $user_id = $stmt->insert_id; // Get the newly inserted user ID

                // Insert selected movies into user_movie_selections table
                $sql = "INSERT INTO user_movie_selections (user_id, movie_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);

                foreach ($selected_movies as $movie_id) {
                    $stmt->bind_param("ii", $user_id, $movie_id);
                    $stmt->execute();
                }

                $success = "Signup successful. You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

// Fetch movies from the database for selection
$sql = "SELECT id, title, genre, poster_url FROM movies ORDER BY title ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Existing styles remain unchanged */
    </style>
    <script>
        function validateMovieSelection(event) {
            // Get all checked checkboxes
            const selectedMovies = document.querySelectorAll('input[name="movies[]"]:checked');

            // Check if the count is within the range of 7 to 10
            if (selectedMovies.length < 7 || selectedMovies.length > 10) {
                // Prevent form submission
                event.preventDefault();

                // Display a warning to the user
                alert("Please select between 7 and 10 movies.");
            }
        }
    </script>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="center-content">
        <h2>Signup</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        
        <!-- Add onsubmit event to trigger JavaScript validation -->
        <form method="POST" action="" onsubmit="validateMovieSelection(event)" autocomplete="off>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <label for="movies">Select Your Favorite Movies (7-10):</label><br>
            <div class="movie-selection">
                <?php while ($movie = $result->fetch_assoc()) { ?>
                    <div class="movie-item">
                        <img src="../<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="Poster">
                        <input type="checkbox" name="movies[]" value="<?php echo $movie['id']; ?>">
                        <span><?php echo htmlspecialchars($movie['title']); ?></span>
                    </div>
                <?php } ?>
            </div><br>

            <button type="submit" class="button">Signup</button>
        </form>
    </div>
</body>
</html>
