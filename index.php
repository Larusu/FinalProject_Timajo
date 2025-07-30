<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Mr_Budget</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">

    <main>
        <section class="login-section">
            <h2>Login</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </section>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>
