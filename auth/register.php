<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $_SESSION['messages'][] = "Passwords do not match.";
        header("Location: register.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! You can now login.";
        header("Location: register.php");
        exit();
    } else {
        $_SESSION['messages'][] = "Username or email already exists.";
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Mr_Budget</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body class="login-body">
  <div class="login-panel">
    <div class="login-illustration">
      <img src="../assets/images/login-illustration.svg" alt="Register Illustration" />
    </div>

    <div class="login-form">
      <div class="form-header">
        <p class="small-text-2">Already have an account? <a href="../index.php">Login here</a></p>
        <h2>Create Account</h2>
        <p class="sub-text">Start budgeting smarter today.</p>
      </div>

      <?php
      if (isset($_SESSION['success'])):
      ?>
        <script>
          alert("<?php echo $_SESSION['success']; ?>");
          window.location.href = "../index.php"; 
        </script>
        <?php unset($_SESSION['success']); ?>
      <?php
      endif;

      if (isset($_SESSION['messages'])):
        foreach ($_SESSION['messages'] as $message):
      ?>
          <p class="error"><?php echo htmlspecialchars($message); ?></p>
      <?php
        endforeach;
        unset($_SESSION['messages']);
      endif;
      ?>


      <form action="register.php" method="POST" onsubmit="return validatePasswords()">
        <input type="text" name="username" placeholder="Enter your username" required />
        <input type="email" name="email" placeholder="Enter your email" required />

        <div class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Create a password" required />
          <button type="button" class="toggle-password" onclick="togglePassword(this)">
            <img src="../assets/images/eye-closed.svg" alt="Show password" />
          </button>
        </div>

        <div class="password-wrapper">
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required />
          <button type="button" class="toggle-password" onclick="togglePassword(this)">
            <img src="../assets/images/eye-closed.svg" alt="Show password" />
          </button>
        </div>

        <p id="password-error" class="error hidden-error">Passwords do not match.</p>

        <button type="submit" class="register-btn">Register</button>
      </form>
    </div>
  </div>

  <script src="../assets/js/script.js"></script>
</body>
</html>
