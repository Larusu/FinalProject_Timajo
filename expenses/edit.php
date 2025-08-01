<?php
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $date = trim($_POST['date'] ?? '');

    if ($id && $category && $description && $amount && $date) {
        $stmt = $conn->prepare("UPDATE expenses SET category = ?, description = ?, amount = ?, date = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $category, $description, $amount, $date, $id);

        if ($stmt->execute()) {
            $_SESSION['messages'][] = "Updated successfully!";
        } else {
            $_SESSION['messages'][] = "Update failed: " . $stmt->error;
        }
    } else {
        $_SESSION['messages'][] = "All fields are required.";
    }

    // Redirect back to list
    header("Location: list.php");
    exit();
}

// If not POST, redirect
$_SESSION['messages'][] = "Invalid request.";
header("Location: list.php");
exit();
?>
