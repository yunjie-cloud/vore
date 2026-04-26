document.getElementById("chat-form").addEventListener("submit", async function(e) {
  e.preventDefault();
  const input = document.getElementById("user-input");
  const message = input.value;

  // Show user message
  const chatBox = document.getElementById("chat-box");
  chatBox.innerHTML += `<div class="message user">${message}</div>`;
  input.value = "";

  // Send to backend
  const response = await fetch("groq_chat.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "message=" + encodeURIComponent(message)
  });

  const data = await response.text();

  // Show assistant reply
  chatBox.innerHTML += `<div class="message assistant">${data}</div>`;
  chatBox.scrollTop = chatBox.scrollHeight;
});
