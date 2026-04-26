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
