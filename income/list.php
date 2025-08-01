<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

$query = "SELECT * FROM income";
$data = $conn->query($query);
$totalAmount = 0;
$count = 0;


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
    <title>List of Incomes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<body class ="income-body">

<?php include '../includes/header.php'; ?>
<div class="members">
    <table role = "grid">
        <thead>
            <tr>
                <th>Source</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Action</th> 
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
                <td><?= $row['source']; ?></td>
                <td><?= $row['date']; ?></td>
                <td>₱<?= number_format($amount, 2);?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete"><i class="fas fa-trash"></i></button>
                        <button type="submit" name="edit"><i class="fas fa-edit"></i></button>
                    </form>
                </td>
            </tr>

        <?php } ?>
        </tbody>

        <tfoot>
            <?php if($count > 0):?>
            <tr>
                <td colspan="1"></td> <!-- Empty 2 columns-->
                <td colspan="1">
                    <td>₱<?= number_format($totalAmount, 2); ?></td> <!-- try mo to na naka strong <strong>Total Amount: <?= $totalAmount ?></strong> -->
                <td>Total Count: <?= $count; ?></td>
            </tr>
            <?php endif; ?>
        </tfoot>
    </table>
</div>
    <br><br>
    <script src="../assets/js/script.js"></script>
</html>