document.getElementById("chat-form").addEventListener("submit", async function(e) {
  e.preventDefault();
  const input = document.getElementById("chat-input");
  const message = input.value;
  const chatMessages = document.getElementById("chat-messages");

  // Show user message
  chatMessages.innerHTML += `<div><strong>You:</strong> ${message}</div>`;
  input.value = "";

  try {
    const response = await fetch("groq_chat.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "message=" + encodeURIComponent(message)
    });

    // 👉 Paste the debug line here
    const reply = await response.text();
    console.log("Backend reply:", reply);

    // Show assistant reply
    chatMessages.innerHTML += `<div><strong>Assistant:</strong> ${reply}</div>`;
    chatMessages.scrollTop = chatMessages.scrollHeight;
  } catch (err) {
    chatMessages.innerHTML += `<div><strong>Assistant:</strong> Error: ${err.message}</div>`;
  }
});
