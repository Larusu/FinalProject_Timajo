<?php
include_once 'config/database.php';

session_start();

if (isset($_SESSION['user_id'])) 
{
    $user_id = $_SESSION['user_id'];
}
else
{
    $user_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    
</body>
</html>