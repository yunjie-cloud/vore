<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI-Based Virtual Assistant - Catbalogan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Municipality of Catbalogan</h1>
    <nav>
      <a href="index.html">Home</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <section class="chat-container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <div id="chat-area"></div>
    <form id="chat-form">
      <input type="text" id="chat-input" placeholder="Type your question..." required>
      <button type="submit">Send</button>
    </form>
  </section>

  <script>
    document.getElementById("chat-form").addEventListener("submit", function(e) {
      e.preventDefault();
      const input = document.getElementById("chat-input").value;
      const chatArea = document.getElementById("chat-area");

      // Display user message
      chatArea.innerHTML += `<div><strong>You:</strong> ${input}</div>`;

      // Simulated AI response (replace later with real backend)
      let response = "This is a placeholder response. Later, I’ll connect to municipal FAQs or AI backend.";
      if (input.toLowerCase().includes("permit")) {
        response = "You can request permits at the Municipal Hall or through our online portal.";
      } else if (input.toLowerCase().includes("hours")) {
        response = "Municipal services are available 24/7 through this assistant.";
      }

      chatArea.innerHTML += `<div><strong>Assistant:</strong> ${response}</div>`;
      document.getElementById("chat-input").value = "";
      chatArea.scrollTop = chatArea.scrollHeight;
    });
  </script>
</body>
</html>
