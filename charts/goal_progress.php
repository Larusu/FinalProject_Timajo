<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

$query = "SELECT goal_name, target_amount, saved_amount FROM savings_goals WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$data = $stmt->get_result();

// $goalName += $row['goal_name']; 
// $targetAmount += $row['target_amount']; 
// $savedAmount += $row['saved_amount']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Saving Goals</title>
    <style>
    .progress-container {
        background-color: #e0e0e0;
        width: 100%;
        height: 20px;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        background-color: #4caf50;
        width: 0%;
        transition: width 0.4s ease;
    }
    </style>
</head>
<body>
<!--   header section   -->
<?php include '../includes/header.php'; ?>

<h2>Savings Goals Tab</h2>

<!-- NOTE!!!! okaay lang kahit hindi table, okay lang kahit may design -->
<!-- ginawa ko lang to para may reference -->
    <table style="border-collapse: collapse; width: 100%;" border="1">
        <thead>
            <tr>
                <th>Goal Name</th>
                <th>Target Amount</th>
                <th>Saved Amount</th>
                <th>Percentage</th> <!-- FOR BUTTON -->
            </tr>
        </thead>

        <tbody>
        <?php  
        while ($row = mysqli_fetch_assoc($data)) { 
            $target = $row['target_amount'];
            $saved = $row['saved_amount'];
            $percent = $target > 0 ? ($saved / $target) * 100 : 0;
            $percent = min($percent, 100); // cap at 100%
            ?>
            <tr>
                <td><?= $row['goal_name']; ?></td>
                <td><?= number_format($target, 2);?></td>
                <td><?= number_format($saved, 2);?></td>
                <td>
                    <div class="progress-container">
                    <div class="progress-bar" style="width: <?= $percent ?>%;"></div>
                    </div>
                    <small><?= number_format($percent, 1) ?>%</small>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br><br>
    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="../savings_goals/list.php">
        <button type="button">Go to Goals</button>
    </a>
    <a href="../dashboard/index.php">
        <button type="button">Go back</button>
    </a>
</body>
</html>