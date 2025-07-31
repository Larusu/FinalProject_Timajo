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
        <input name="source" placeholder="Income Source" required><br><br>
        <input name="amount" placeholder="Amount" type="number" step="0.01" required><br><br>
        <input type="date" name="date" required><br>
        <button type="submit">Submit</button>
    </form>
    <br><br>
    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="list.php"> 
        <button type="button">Go to List</button>
    </a>
</body>
</html>