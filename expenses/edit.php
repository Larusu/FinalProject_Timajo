<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

if($id = intval($_GET['id']))
{
    $stmt = $conn->prepare("SELECT category, description, amount, date FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute())
    {
        $result = $stmt->get_result();

        if ($result->num_rows === 0) 
        {
            $_SESSION['messages'][] = "No income found.";
            header("Location: list.php");
            exit();
        }

        $data = $result->fetch_assoc();

        $placeholdCategory = $data['category'];
        $placeholdDescription = $data['description'];
        $placeholdAmount = $data['amount'];
        $placeholdDate = $data['date'];
    }
}
else
{
    $_SESSION['messages'][] = "Select a row first.";
    header("Location: list.php");
    exit();
}


if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $category = !empty($_POST['category']) ? trim($_POST['category']) : $placeholdCategory;
    $description = !empty($_POST['description']) ? trim($_POST['description']) : $placeholdDescription;
    $amount = isset($_POST['amount']) && $_POST['amount'] !== '' ? floatval($_POST['amount']) : $placeholdAmount;
    $date = !empty($_POST['date']) ? trim($_POST['date']) : $placeholdAmount;
    
    $query = "UPDATE expenses SET category = ?, description = ?, amount = ?, date = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdsi", $category, $description, $amount, $date, $id);

    if($stmt->execute())
    {
        $_SESSION['messages'][] = 'Updated succesfully!';
        header("Location: list.php");
        exit();
    }
    else
    {
        $_SESSION['messages'][] = "Database error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expenses</title>
</head>
<body>
<!--   header section   -->
<?php include '../includes/header.php'; ?>

    <form method="POST">
        <label for="category">Category:</label><br>
        <input name="category" placeholder="<?=$placeholdCategory?>"><br><br>

        <label for="description">Description:</label><br>
        <input name="description" placeholder="<?=$placeholdDescription?>"><br><br>

        <label for="amount">Amount:</label><br>
        <input name="amount" placeholder="<?=$placeholdAmount?>"><br><br>

        <label for="date">Date: <?=$placeholdDate?></label><br>
        <input type="date" name="date"><br><br>
        <button type="submit">Update</button>
    </form>
    <br><br>

    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="list.php">
        <button type="button">Go to List</button>
    </a>
</body>
</html>