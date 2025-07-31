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

    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="../income/list.php">
        <button type="button">Go to Income List</button>
    </a>
    <a href="../expenses/list.php">
        <button type="button">Go to Expenses List</button>
    </a>
    <a href="../savings_goals/list.php">
        <button type="button">Go to Savings Goals</button>
    </a>
    <a href="../charts/financial_comparison.php">
        <button type="button">Go to Financial Comparison</button>
    </a>
    <a href="../charts/goal_progress.php">
        <button type="button">Go to Goal Progress</button>
    </a>
</body>
</html>
