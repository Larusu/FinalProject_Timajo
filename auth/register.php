<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Username or email already exists.";
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Mr_Budget</title>
</head>
<body>
    <h2>Register</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <input name="username" placeholder="Username" required><br><br>
        <input name="email" placeholder="Email" type="email"><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
