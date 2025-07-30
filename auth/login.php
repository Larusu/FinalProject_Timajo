<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: ../index.php");
        exit();
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: ../dashboard/index.php");
                exit();
            } else {
                $_SESSION['error'] = "Invalid password.";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "User not found.";
            header("Location: ../index.php");
            exit();
        }
    }
}
?>