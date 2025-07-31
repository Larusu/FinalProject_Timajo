<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $source = trim($_POST['source']);
    $amount = floatval($_POST['amount']);
    $date = trim($_POST['date']);

    $stmt = $conn->prepare("INSERT INTO income (user_id, source, amount, date) 
                           VALUES (?,?,?,?)");
    $stmt->bind_param("isds", $_SESSION['user_id'], $source, $amount, $date);

    if($stmt->execute())
    {
        $_SESSION['messages'][] = 'Added to income!';
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
    <title>Add Income</title>
</head>
<body>

<!--   header section   -->
<?php include '../includes/header.php'; ?>

    <h2>Add Income</h2>

    <form method="POST">
        <label for="source">Income Source:</label><br>
        <input id="source" name="source" placeholder="e.g. Salary, Freelance" required><br><br>

        <label for="amount">Amount:</label><br>
        <input id="amount" name="amount" placeholder="e.g. 1500.00" type="number" step="0.01" required><br><br>

        <label for="date">Date:</label><br>
        <input id="date" type="date" name="date" required><br><br>

        <button type="submit">Submit</button>
    </form>
    <br><br>
    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="list.php"> 
        <button type="button">Go to List</button>
    </a>
</body>
</html>