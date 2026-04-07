<?php
session_start();
require_once 'vendor/autoload.php'; // Google API client library

// Replace with your Google API credentials
$clientID = "547972795933-g4avtjaigfvdjdqapfv1ihqem0cndd09.apps.googleusercontent.com";
$clientSecret = "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";
$redirectUri = "https://vore-virtual-assistant.gt.tc/google_login.php";
 // must match Google Console

// Create Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// If we don't have a code yet, redirect to Google
if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    header("Location: " . $authUrl);
    exit();
} else {
    // Exchange code for access token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get user profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();

    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Connect to DB
    include("db.php");

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Existing user → log in
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
    } else {
        // New user → create account
        $sql = "INSERT INTO users (username, email, password) VALUES ('$name','$email','')";
        $conn->query($sql);
        $new_id = $conn->insert_id;
        $_SESSION['user_id'] = $new_id;
        $_SESSION['username'] = $name;
    }

    // Redirect to chat
    header("Location: chat.php");
    exit();
}
?>

`