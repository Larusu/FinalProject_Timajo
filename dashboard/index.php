<?php
require_once '../helpers/auth.php';
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Mr. Budget</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-body">

  <?php include '../includes/header.php'; ?>

  <main class="container">
    <h1 class="dashboard-heading">
      Welcome to Mr. Budget, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </h1>
    <section id="btn-container">
    <div class="button-group">
        <a href="../income/list.php" class="btn-link">Income List</a>
        <a href="../expenses/list.php" class="btn-link">Expenses List</a>
        <a href="../goals/list.php" class="btn-link">Savings Goals</a>
        <a href="../charts/financial_comparison.php" class="btn-link">Financial Comparison</a>
        <a href="../charts/goal_progress.php" class="btn-link">Goal Progress</a>
    </div>
    </section>
  </main>

  <?php include '../includes/footer.php'; ?>

</body>
</html>
