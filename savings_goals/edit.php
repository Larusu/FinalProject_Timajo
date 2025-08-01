<?php
session_start();
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['messages'][] = "Invalid request.";
    header("Location: list.php");
    exit();
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if (!$id) {
    $_SESSION['messages'][] = "Missing goal ID.";
    header("Location: list.php");
    exit();
}

// Fetch existing values
$stmt = $conn->prepare("SELECT goal_name, target_amount, saved_amount, start_date, end_date FROM savings_goals WHERE id = ?");
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    $_SESSION['messages'][] = "Failed to retrieve existing goal.";
    header("Location: list.php");
    exit();
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['messages'][] = "Goal not found.";
    header("Location: list.php");
    exit();
}

$existing = $result->fetch_assoc();

// Get updated values or fallback to existing
$name = !empty($_POST['goal_name']) ? trim($_POST['goal_name']) : $existing['goal_name'];
$targetAmount = $_POST['target_amount'] !== '' ? floatval($_POST['target_amount']) : $existing['target_amount'];
$savedAmount = $_POST['saved_amount'] !== '' ? floatval($_POST['saved_amount']) : $existing['saved_amount'];
$startDate = !empty($_POST['start_date']) ? $_POST['start_date'] : $existing['start_date'];
$endDate = !empty($_POST['end_date']) ? $_POST['end_date'] : $existing['end_date'];

// Update query
$update = $conn->prepare("UPDATE savings_goals 
    SET goal_name = ?, target_amount = ?, saved_amount = ?, start_date = ?, end_date = ? 
    WHERE id = ?");
$update->bind_param("sddssi", $name, $targetAmount, $savedAmount, $startDate, $endDate, $id);

if ($update->execute()) {
    $_SESSION['messages'][] = "Goal updated successfully!";
} else {
    $_SESSION['messages'][] = "Update failed: " . $update->error;
}

header("Location: list.php");
exit();
?>
