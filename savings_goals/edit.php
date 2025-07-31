<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

if($id = intval($_GET['id']))
{
    $stmt = $conn->prepare("SELECT goal_name, target_amount, saved_amount, start_date, end_date FROM savings_goals WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute())
    {
        $result = $stmt->get_result();

        if ($result->num_rows === 0) 
        {
            $_SESSION['messages'][] = "No goals found.";
            header("Location: list.php");
            exit();
        }

        $data = $result->fetch_assoc();

        $placeholdName = $data['goal_name'];
        $placeholdTargetAmount = $data['target_amount'];
        $placeholdSavedAmount = $data['saved_amount'];
        $placeholdStartDate = $data['start_date'];
        $placeholdEndDate = $data['end_date'];
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
    $name = !empty($_POST['goalName']) ? trim($_POST['goalName']) : $placeholdName;
    $targetAmount = isset($_POST['targetAmount']) && $_POST['targetAmount'] !== '' ? floatval($_POST['targetAmount']) : $placeholdTargetAmount;
    $savedAmount = isset($_POST['savedAmount']) && $_POST['savedAmount'] !== '' ? floatval($_POST['savedAmount']) : $placeholdSavedAmount;
    $startDate = !empty($_POST['startDate']) ? trim($_POST['startDate']) : $placeholdStartDate;
    $endDate = !empty($_POST['endDate']) ? trim($_POST['endDate']) : $placeholdEndDate;
    
    $query = "UPDATE savings_goals SET goal_name = ?, target_amount = ?, saved_amount = ?, start_date = ?, end_date = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sddssi", $name, $targetAmount, $savedAmount, $startDate, $endDate, $id);

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
    <title>Edit Income</title>
</head>
<body>
<!--   header section   -->
<?php include '../includes/header.php'; ?>

    <form method="POST">
        <label for="goalName">Goal Name:</label><br>
        <input name="goalName" placeholder="<?=$placeholdName?>"><br><br>

        <label for="targetAmount">Target Amount:</label><br>
        <input name="targetAmount" placeholder="<?=$placeholdTargetAmount?>" type="number" step="0.01"><br><br>
        
        <label for="savedAmount">Target Amount:</label><br>
        <input name="savedAmount" placeholder="<?=$placeholdSavedAmount?>" type="number" step="0.01"><br><br>

        <label for="startDate">Start Date:<?=$placeholdStartDate?></label><br>
        <input type="date" name="startDate"><br>

        <label for="endDate">End Date:<?=$placeholdEndDate?></label><br>
        <input type="date" name="endDate"><br>

        <button type="submit">Update</button>
    </form>
    <br><br>

    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="list.php">
        <button type="button">Go to List</button>
    </a>
</body>
</html>