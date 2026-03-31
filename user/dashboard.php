<!-- User: Shayan 
password: 12345678 

User: Admin
password: 12345678  -->


<?php
session_start();

// Protect page (user must be logged in)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

require_once "../app/config/database.php";

$database = new Database();
$db = $database->connect();

// Fetch user details
$sqlUser = "SELECT name, email, created_at FROM users WHERE id = :id";
$stmtUser = $db->prepare($sqlUser);
$stmtUser->bindParam(":id", $_SESSION['user_id']);
$stmtUser->execute();
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Fetch booking count
$sqlBookings = "SELECT COUNT(*) AS total FROM bookings WHERE user_id = :uid";
$stmtBookings = $db->prepare($sqlBookings);
$stmtBookings->bindParam(":uid", $_SESSION['user_id']);
$stmtBookings->execute();
$bookingData = $stmtBookings->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
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
        }
        .header a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
        }
        .card {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .stat-box {
            flex: 1;
            background: #007bff;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .actions a {
            display: inline-block;
            margin-right: 10px;
            margin-top: 10px;
            padding: 10px 15px;
            background: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .actions a.logout {
            background: #dc3545;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h2>
    <a href="../public/index.php">Home</a>
    <a href="../public/logout.php">Logout</a>
</div>

<div class="container">

    <div class="card">
        <h3>Profile Information</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Member Since:</strong> <?= date("d M Y", strtotime($user['created_at'])) ?></p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3><?= $bookingData['total'] ?></h3>
            <p>Total Bookings</p>
        </div>
    </div>

    <div class="card actions">
        <h3>Quick Actions</h3>
        <a href="booking_history.php">My Bookings</a>
        <a href="profile.php">Edit Profile</a>
        <a href="../public/index.php">Book Tickets</a>
        <a href="../public/logout.php" class="logout">Logout</a>
    </div>

</div>

</body>
</html>