<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h2>Login</h2>
    <form method="POST" action="login_process.php">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit" name="login">Login</button>
    </form>

    <div class="google-login">
      <a href="google_login.php" class="google-btn">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
        Continue with Google
      </a>
    </div>

    <a href="index.html" class="back-btn">Back to Home</a>
  </div>
</body>
</html>
