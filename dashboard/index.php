<?php
require_once '../helpers/auth.php';
require_login();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to Mr_Budget!</h1>
    <p>You are logged in.</p>
    <a href="../auth/logout.php">Logout</a>
</body>
</html>
