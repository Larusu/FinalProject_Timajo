<?php
require_once '../helpers/auth.php';
require_login();
include '../includes/header.php'; // Assuming this contains your sidebar HTML and styles
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="app-title"><i class="fa-solid fa-piggy-bank"></i></i>Mr. Budget</div>
      </div>

      <nav class="sidebar-nav">
        <ul>
          <li><a href="../dashboard/index.php"><i class="fa-solid fa-house-user"></i> Dashboard</a></li>
          <li><a href="../income/list.php"><i class="fas fa-wallet"></i> Income</a></li>
          <li><a href="../expenses/list.php"><i class="fas fa-money-bill-wave"></i> Expenses</a></li>
          <li><a href="../savings_goals/list.php"><i class="fas fa-bullseye"></i> Goals</a></li>
          <li><a href="../charts/financial_comparison.php"><i class="fas fa-chart-bar"></i> Financial Comparison</a></li>
          <li><a href="../charts/goal_progress.php"><i class="fas fa-chart-line"></i> Goals Progress</a></li>
          <li><a href="../dashboard/profile.php"><i class="fas fa-user"></i> Profile</a></li>
          <li><a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content">
      <h1>Welcome to Mr_Budget!</h1>
      <p>You are logged in.</p>
    </main>
  </div>
</body>
</html>
