<?php
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h1>Financial Comparison</h1><br>
    <h6>Total Income:<?=$totalIncomeAmount?></h6><br>
    <h6>Total Expenses:<?=$totalExpensesAmount?></h6><br>
    <h6>Net Balance:<?=$netBalance?></h6><br>

    <canvas id="pieChart" style="width: 300px; height: 300px;"></canvas>

    <a href="../dashboard/index.php">
        <button type="button">Go back</button>
    </a>
</body>
<script>
    const totalIncome = <?php echo json_encode($totalIncomeAmount); ?>;
    const totalExpense = <?php echo json_encode($totalExpensesAmount); ?>;

    // Render with Chart.js

    const ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Income', 'Expenses'],
        datasets: [{
          label: 'Income vs Expenses',
          data: [totalIncome, totalExpense],
          backgroundColor: ['#ff6384', '#36a2eb'] //['#ff6384', '#36a2eb', '#ffcd56']
        }]
      },
      options: {
        responsive: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
</script>
</html>