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
</head>
<body class ="dashboard-body">

<?php include '../includes/header.php'; ?>

    <table class="income-table">
        <thead>
            <tr>
                <th>Source</th>
                <th>Amount</th>
                <th>Date</th>
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
                <th><?= $row['source']; ?></th>
                <th><?= number_format($amount, 2);?></th>
                <th><?= $row['date']; ?></th>

                <th>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete"><i class="fas fa-trash"></i></button>
                        <button type="submit" name="edit"><i class="fas fa-edit"></i></button>
                    </form>
                </th>
            </tr>
        <?php } ?>
        </tbody>

        <tfoot>
            <?php if($count > 0):?>
            <tr>
                <td colspan="2"></td> <!-- Empty 2 columns-->
                <td>Total Count: <?= number_format($count, 2); ?></td>
                <td>Total Amount: <?= number_format($totalAmount, 2); ?></td> <!-- try mo to na naka strong <strong>Total Amount: <?= $totalAmount ?></strong> -->
            </tr>
            <?php endif; ?>
        </tfoot>
    </table>
    <br><br>

    <!-- Toggle Button -->
    <button class="toggle-form-btn" onclick="toggleForm()">
    <i class="fas fa-chevron-down"></i> Add New Entry
    </button>

    <!-- Collapsible Form -->
    <div id="collapsibleForm" class="collapsible-form">
    <form method="POST">
        <label>Source:</label><br>
        <input type="text" name="source" required><br>

        <label>Amount:</label><br>
        <input type="number" name="amount" required><br>

        <label>Date:</label><br>
        <input type="date" name="date" required><br>

        <button type="submit">Add Entry</button>
    </form>
    </div>

    <script src="../assets/js/script.js"></script>

    <!-- gawa ng design dito para mapunta sa list tab -->
</html>