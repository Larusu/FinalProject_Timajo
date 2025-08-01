<?php
session_start();
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

$totalIncomeAmount = 0.0;
$totalExpensesAmount = 0.0;
$netBalance = 0.0;

// Get Total Income
$incomeQuery = $conn->prepare("SELECT amount FROM income WHERE user_id = ?");
$incomeQuery->bind_param("i", $_SESSION['user_id']);
$incomeQuery->execute();
$result = $incomeQuery->get_result();

while($row = mysqli_fetch_assoc($result))
{ 
    $totalIncomeAmount += $row['amount']; 
}

// Get Total Expense
$expenseQuery = $conn->prepare("SELECT amount FROM expenses WHERE user_id = ?");
$expenseQuery->bind_param("i", $_SESSION['user_id']);
$expenseQuery->execute();
$result = $expenseQuery->get_result();

while($row = mysqli_fetch_assoc($result)) 
{ 
    $totalExpensesAmount += $row['amount']; 
}

// Calculate Net Balance
$netBalance = $totalIncomeAmount - $totalExpensesAmount;

function getTotalIncome(): float
{ 
    global $totalIncomeAmount;
    return $totalIncomeAmount; 
}
function getTotalExpense(): float
{
    global $totalExpensesAmount;
    return $totalExpensesAmount;
}
function getNetBalance(): float
{
    global $netBalance;
    return $netBalance;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Vs Expenses</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class ="financial_comparison-body">

    <?php include '../includes/header.php'; ?>

  <div class="main-container">
    <div class="top-row">
      <div class="total-income"><h2>Total Income</h2></div>
      <div class="total-expense"><h2>Total Expenses</h2></div>
      <div class="net-balance"><h2>Net Balance</h2></div>
    </div>

    <div class="bottom-row">
      <div class="ie-pie-chart"></div>
    </div>
  </div>


</body>

<script src="../assets/js/script.js"></script>

</html>