<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name = trim($_POST['goalName']);
    $targetAmount = floatval($_POST['targetAmount']);
    $savedAmount = floatval($_POST['savedAmount']);
    $startDate = trim($_POST['startDate']);
    $endDate = trim($_POST['endDate']);

    $query = "INSERT INTO savings_goals  
            (user_id, goal_name, target_amount, saved_amount, start_date, end_date) 
            VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isddss", $_SESSION['user_id'], $name, $targetAmount, $savedAmount, $startDate, $endDate);

    if($stmt->execute())
    {
        $_SESSION['messages'][] = 'Added to Savings Goals!';
        header("Location: add.php");
        exit();
    }
    else
    {
        $_SESSION['messages'][] = "Database error: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Savings Goals</title>
</head>
<body>

<!--   header section   -->
<?php include '../includes/header.php'; ?>

    <h2>Add Savings Goals</h2>

    <form method="POST">
        <label for="goalName">Goal Name:</label><br>
        <input name="goalName" placeholder="e.g. New Cellphone" required><br><br>

        <label for="targetAmount">Target Amount:</label><br>
        <input name="targetAmount" placeholder="e.g. 1500.00" type="number" step="0.01" required><br><br>
        
        <label for="savedAmount">Saved Amount:</label><br>
        <input name="savedAmount" placeholder="e.g. 1500.00" type="number" step="0.01" required><br><br>

        <label for="startDate">Start Date:</label><br>
        <input type="date" name="startDate" required><br>

        <label for="endDate">End Date:</label><br>
        <input type="date" name="endDate" required><br>

        <button type="submit">Submit</button>
    </form>
    <br><br>
    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="list.php"> 
        <button type="button">Go to List</button>
    </a>
</body>
</html>