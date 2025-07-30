<!DOCTYPE html>
<html>
<head>
    <title>Login - Mr_Budget</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Login</h2>

    <form action="auth/login.php" method="POST">
        <input name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
