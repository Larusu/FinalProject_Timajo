<?php
session_start();
include_once '../config/database.php';
require_once '../helpers/auth.php';
require_login();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $source = trim($_POST['source']);
    $amount = floatval($_POST['amount']);
    $date = trim($_POST['date']);

    $stmt = $conn->prepare("INSERT INTO income (user_id, source, amount, date) 
                           VALUES (?,?,?,?)");
    $stmt->bind_param("isds", $_SESSION['user_id'], $source, $amount, $date);

    if($stmt->execute())
    {
        $_SESSION['messages'][] = 'Added to income!';
        header("Location: list.php");
        exit();
    }
    else
    {
        $_SESSION['messages'][] = "Database error: " . $stmt->error;
        header("Location: list.php");
        exit();
    }
}
?>