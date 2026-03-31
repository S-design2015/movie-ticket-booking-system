<?php
session_start();

require_once "../app/config/database.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } else {

        try {
            $database = new Database();
            $db = $database->connect();

            // Check if email already exists
            $checkSql = "SELECT id FROM users WHERE email = :email";
            $checkStmt = $db->prepare($checkSql);
            $checkStmt->bindParam(":email", $email);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                $error = "Email already registered";
            } else {

                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert user
                $sql = "INSERT INTO users (name, email, password, role, is_verified)
                        VALUES (:name, :email, :password, 'user', 1)";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $hashedPassword);

                if ($stmt->execute()) {
                    $success = "Registration successful. You can now login.";
                } else {
                    $error = "Registration failed. Try again.";
                }
            }

        } catch (PDOException $e) {
            $error = "Something went wrong. Please try later.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register | Movie Ticket Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .register-box {
            width: 380px;
            margin: 80px auto;
            background: #fff;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background: #1e7e34;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 10px;
        }
        .links {
            text-align: center;
            margin-top: 10px;
        }
        .links a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>Create Account</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>

    <div class="links">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>
