<?php
session_start();
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goalName = trim($_POST['goal_name']);
    $targetAmount = floatval($_POST['target_amount']);
    $savedAmount = floatval($_POST['saved_amount']);
    $startDate = trim($_POST['start_date']);
    $endDate = trim($_POST['end_date']);

    $query = "INSERT INTO savings_goals  
              (user_id, goal_name, target_amount, saved_amount, start_date, end_date) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isddss", $_SESSION['user_id'], $goalName, $targetAmount, $savedAmount, $startDate, $endDate);

    if ($stmt->execute()) {
        $_SESSION['messages'][] = 'Savings goal added!';
    } else {
        $_SESSION['messages'][] = 'Database error: ' . $stmt->error;
    }

    header("Location: list.php");
    exit();
}
?>
