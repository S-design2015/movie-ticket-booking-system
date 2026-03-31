<!-- <?php
require_once "../app/config/database.php";
require_once "../app/models/Movie.php";

$db = (new Database())->connect();
$movie = new Movie($db);
$stmt = $movie->getAllMovies();
?> -->

<?php
session_start();

require_once "../app/config/database.php";
require_once "../app/models/Movie.php";

$database = new Database();
$db = $database->connect();

$movieModel = new Movie($db);
$movies = $movieModel->getAllMovies(); // <-- use $movies
?>


<!DOCTYPE html>
<html>
<head>
    <title>Movie Ticket Booking</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: auto;
        }
        .header {
            background: #222;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .movie-card {
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .movie-card h3 {
            margin: 0 0 10px;
        }
        .movie-card p {
            margin: 4px 0;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .top-links {
            text-align: right;
            margin-top: 10px;
        }
        .top-links a {
            margin-left: 10px;
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Movie Ticket Booking System</h1>

    <div class="top-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../user/dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">

    <h2>Now Showing</h2>

    <div class="movie-grid">

        <?php if ($movies->rowCount() > 0): ?>
            <?php while ($movie = $movies->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="movie-card">
                    <h3><?= htmlspecialchars($movie['name']) ?></h3>
                    <p><strong>Genre:</strong> <?= htmlspecialchars($movie['genre']) ?></p>
                    <p><strong>Language:</strong> <?= htmlspecialchars($movie['language']) ?></p>
                    <p><strong>Duration:</strong> <?= htmlspecialchars($movie['duration']) ?></p>
                    <p><strong>Director:</strong> <?= htmlspecialchars($movie['director']) ?></p>
                    <p><strong>Release Date:</strong> <?= htmlspecialchars($movie['release_date']) ?></p>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="../user/book_ticket.php?movie_id=<?= $movie['id'] ?>" class="btn">
                            Book Ticket
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn">
                            Login to Book
                        </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No movies available.</p>
        <?php endif; ?>

    </div>
</div>
<!-- <h2>Now Showing</h2>

<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div>
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>Genre: <?= $row['genre'] ?></p>
        <a href="login.php">Book Ticket</a>
    </div>
<?php endwhile; ?> -->

</body>
</html>
