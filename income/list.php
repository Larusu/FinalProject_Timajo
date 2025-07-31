<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

$query = "SELECT * FROM income";
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
        $stmt = $conn->prepare("DELETE FROM income WHERE id = ?");
        $stmt->bind_param("i", $id); // i for integer
        if ($stmt->execute()) 
        {
            $_SESSION['messages'][] = "Deleted successfully!";
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
    <title>List of Incomes</title>
</head>
<body>
<!--   header section   -->
<?php include '../includes/header.php'; ?>

<!-- NOTE!!!! okaay lang kahit hindi table, okay lang kahit may design -->
<!-- ginawa ko lang to para may reference -->
    <table style="border-collapse: collapse; width: 100%;" border="1">
        <thead>
            <tr>
                <th>Source</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Action</th> <!-- FOR BUTTON -->
            </tr>
        </thead>

        <tbody>
        <?php 
            while ($row = mysqli_fetch_assoc($data)) {
            $amount = $row['amount']; 
            $totalAmount += $amount;
            $count++;
        ?>
            <tr>
                <th><?= $row['source']; ?></th>
                <th><?= number_format($amount);?></th>
                <th><?= $row['date']; ?></th>

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

        <tfoot>
            <?php if($count > 0):?>
            <tr>
                <td colspan="2"></td> <!-- Empty 2 columns-->
                <td>Total Count: <?= $count ?></td>
                <td>Total Amount: <?= $totalAmount ?></td> <!-- try mo to na naka strong <strong>Total Amount: <?= $totalAmount ?></strong> -->
            </tr>
            <?php endif; ?>
        </tfoot>
    </table>
    <br><br>
    <!-- gawa ng design dito para mapunta sa list tab -->
    <a href="add.php">
        <button type="button">Add Income</button>
    </a>
    <a href="../dashboard/index.php">
        <button type="button">Go back</button>
    </a>
</body>
</html>