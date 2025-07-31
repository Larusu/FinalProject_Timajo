<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $amount = floatval($_POST['amount']);
    $date = trim($_POST['date']);

    $query = "INSERT INTO expenses (user_id, category, description, amount, date)
              VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("issds", $_SESSION['user_id'], $category, $description, $amount, $date);

    if($stmt->execute())
    {
        $_SESSION['messages'][] = 'Added to expenses!';
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
    <title>Add Expenses</title>
</head>
<body>

<!--   header section   -->
<?php include '../includes/header.php'; ?>

    <h2>Add Expenses</h2>

    <form method="POST">
        <br>
        <label for="category">Category:</label><br>  <!-- <label> tag connects the label to the corresponding <input>  -->
        <input name="category" placeholder="e.g. Groceries, Utilities" required><br><br>

        <label for="description">Description:</label><br>
        <input name="description" placeholder="Brief description (e.g. Grocery at SM)" required><br><br>
        
        <label for="amount">Amount:</label><br>
        <input name="amount" placeholder="e.g. 1500.00" type="number" step="0.01" required><br><br>

        <label for="date">Start Date:</label><br>
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