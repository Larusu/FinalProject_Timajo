<?php
require_once '../helpers/auth.php';
require_login();
include '../includes/header.php'; // Assuming this contains your sidebar HTML and styles
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <main class="main-content">
      <h1>Welcome to Mr_Budget!</h1>
      <p>You are logged in.</p>
    </main>


</body>
</html>
