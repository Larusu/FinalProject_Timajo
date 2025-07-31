<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Mr_Budget</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="login-body">
  <div class="login-card">
    <div class="login-illustration">
      <img src="assets/images/login-illustration.svg" alt="Budgeting Illustration" />
    </div>

    <div class="login-form">
      <div class="form-header">
        <p class="small-text">Not a member? <a href="auth/register.php">Register here</a></p>
        <h2>Welcome Back!</h2>
        <p class="sub-text">We're happy to see you again.</p>
      </div>

      <?php if (isset($_SESSION['messages'])): ?>
        <?php foreach ($_SESSION['messages'] as $message): ?>
          <p class="error"><?php echo htmlspecialchars($message); ?></p>
        <?php endforeach; unset($_SESSION['messages']); ?>
      <?php endif; ?>

      <form action="auth/login.php" method="POST">
        <input 
            type="email" 
            name="email" 
            placeholder="Enter your email" 
            value="<?php echo isset($_SESSION['old_email']) ? htmlspecialchars($_SESSION['old_email']) : ''; ?>" 
            required 
        />
        
        <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Password" required />
            <button type="button" class="toggle-password" onclick="togglePassword(this)">
            <img src="assets/images/eye-closed.svg" alt="Show password" />
            </button>
        </div>

        <button type="submit" class="login-btn">Sign In</button>
        </form>

        <?php unset($_SESSION['old_email']); ?>
    </div>
  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>
