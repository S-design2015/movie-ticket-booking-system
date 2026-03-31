<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        header("Location: ../user/dashboard.php");
        exit;
    }
}

require_once "../app/config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {
        try {
            $database = new Database();
            $db = $database->connect();

            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify password
                if (password_verify($password, $user['password'])) {

                    // Check email verification (optional)
                    if ($user['is_verified'] == 0) {
                        $error = "Please verify your email before logging in.";
                    } 
                    else {
                        // Set session
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['name']    = $user['name'];
                        $_SESSION['role']    = $user['role'];

                        // Redirect based on role
                        if (strtolower(trim($user['role'])) === 'admin') {
                            header("Location: ../admin/dashboard.php");
                        } else {
                            header("Location: ../user/dashboard.php");
                        }
                        exit;
                    }

                } else {
                    $error = "Invalid email or password";
                }
            } else {
                $error = "Invalid email or password";
            }

        } catch (PDOException $e) {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | Movie Ticket Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .login-box {
            width: 350px;
            margin: 100px auto;
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
            background: #007bff;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
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

<div class="login-box">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="links">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</div>

</body>
</html>
