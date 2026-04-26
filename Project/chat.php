<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your db.php file
require_once "db.php";

// Fetch chat history for this user
$stmt = $conn->prepare("SELECT role, message, timestamp 
                        FROM chat_history 
                        WHERE user_id = ? 
                        ORDER BY timestamp ASC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$history = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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

  <section class="chat-layout">
    <section class="chat-area">
      <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
      <div id="chat-area"></div>
      <form id="chat-form">
        <input type="text" id="chat-input" placeholder="Type your question..." required>
        <button type="submit">Send</button>
      </form>
    </section>
  </section>

  <script>
    document.getElementById("chat-form").addEventListener("submit", function(e) {
      e.preventDefault();
      const input = document.getElementById("chat-input").value;
      const chatArea = document.getElementById("chat-area");

      // Display user message immediately
      chatArea.innerHTML += `<div><strong>You:</strong> ${input}</div>`;

      // Send message to Groq backend
      fetch("groq_chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "message=" + encodeURIComponent(input)
      })
      .then(response => response.text())
      .then(data => {
        chatArea.innerHTML += `<div><strong>Assistant:</strong> ${data}</div>`;
        document.getElementById("chat-input").value = "";
        chatArea.scrollTop = chatArea.scrollHeight;
      })
      .catch(error => {
        chatArea.innerHTML += `<div><strong>Assistant:</strong> Error: ${error}</div>`;
      });
    });
  </script>
</body>
</html>
