<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $amount = floatval($_POST['amount']);
    $date = trim($_POST['date']);

    $query = "INSERT INTO expenses (user_id, category, description, amount, date)
              VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("issds", $_SESSION['user_id'], $category, $description, $amount, $date);

    if ($stmt->execute()) {
        $_SESSION['messages'][] = 'Expense added successfully!';
    } else {
        $_SESSION['messages'][] = "Database error: " . $stmt->error;
    }

    // Redirect back to the expenses page
    header("Location: list.php");
    exit();
}
?>
