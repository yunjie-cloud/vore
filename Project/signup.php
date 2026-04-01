<?php include("db.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h2>Create Account</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit" name="signup">Sign Up</button>
    </form>
    <a href="index.html" class="back-btn">← Back to Home</a>
  </div>
</body>
</html>

<?php
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email','$password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account created successfully!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error: ".$conn->error."');</script>";
    }
}
?>
