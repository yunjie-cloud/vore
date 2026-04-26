<?php include("db.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h2>Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit" name="login">Login</button>
      <div class="google-login">
  <a href="google_login.php" class="google-btn">
    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
    Continue with Google
  </a>
</div>

    </form>
    <a href="index.html" class="back-btn">Back to Home</a>
  </div>
</body>
</html>

<?php
include 'db.php'; // your database connection

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result === false) {
    // Debugging: show SQL error
    echo "Database query failed: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    // Login success
    $row = $result->fetch_assoc();
    echo "Welcome, " . $row['email'];
} else {
    echo "No account found with that email.";
}
?>
