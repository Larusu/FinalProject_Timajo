<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

$query = "SELECT * FROM savings_goals";
$data = $conn->query($query);
$totalAmount = 0;
$count = 0;

echo 'NOTE!!!! okaay lang kahit hindi table para kung may custom design kang gagawin... ';
echo 'Ginawa ko lang to para may reference';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $id = intval($_POST['id']);

    if (isset($_POST['delete'])) 
    {
        $stmt = $conn->prepare("DELETE FROM savings_goals WHERE id = ?");
        $stmt->bind_param("i", $id); // i for integer
        if ($stmt->execute()) 
        {
            $_SESSION['messages'][] = "Deleted successfully!";
            header("Location: list.php");
            exit();
        } 
        else 
        {
            $_SESSION['messages'][] = "Delete failed!";
        }
    }

    if (isset($_POST['edit'])) 
    {
        header("Location: edit.php?id=" . $id);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Saving Goals</title>
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
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th> <!-- FOR BUTTON -->
            </tr>
        </thead>

        <tbody>
        <?php  while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <th><?= $row['goal_name']; ?></th>
                <th><?= number_format($row['target_amount'], 2);?></th>
                <th><?= number_format($row['saved_amount'], 2);?></th>
                <th><?= $row['start_date']; ?></th>
                <th><?= $row['end_date']; ?></th>

                <th>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete">Delete</button>
                        <button type="submit" name="edit">Edit</button>
                    </form>
                </th>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br><br>
    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="add.php">
        <button type="button">Add Goals</button>
    </a>
    <a href="../dashboard/index.php">
        <button type="button">Go back</button>
    </a>
</body>
</html>