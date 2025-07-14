const socket = new WebSocket("ws://localhost:8081");

socket.addEventListener("open", () => {
  console.log("WebSocket connected");
});

socket.addEventListener("message", (event) => {
  const data = JSON.parse(event.data);
  if (data.roomId === roomId) {
    const messagesDiv = document.querySelector(".messages");

    const messageEl = document.createElement("div");
    messageEl.classList.add("message");
    messageEl.innerHTML = `
            <b>${escapeHtml(data.pseudo)}:</b>
            <span class="msg-text">${escapeHtml(data.message)}</span>
            <i class="msg-time">(${data.timestamp})</i>
        `;

    messagesDiv.appendChild(messageEl);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
  }
});

const form = document.querySelector(".chat-form");
const input = form.querySelector('input[name="message"]');

form.addEventListener("submit", function (event) {
  event.preventDefault();
  const message = input.value.trim();
  if (!message) return;

  fetch(`index.php?action=sendMessage&id=${roomId}`, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ message }),
  })
    .then((res) => {
      if (!res.ok) throw new Error("Failed to send message");
      const msgData = {
        roomId: roomId,
        pseudo: userPseudo,
        message: message,
        timestamp: new Date().toLocaleTimeString(),
      };
      socket.send(JSON.stringify(msgData));
      input.value = "";
    })
    .catch(console.error);
});

function escapeHtml(text) {
  const div = document.createElement("div");
  div.textContent = text;
  return div.innerHTML;
}

window.addEventListener("DOMContentLoaded", () => {
  const messagesDiv = document.querySelector(".messages");
  messagesDiv.scrollTop = messagesDiv.scrollHeight;
});
