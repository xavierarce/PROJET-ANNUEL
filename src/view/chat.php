<?php require __DIR__ . '/partials/header.php'; ?>

<div class="container chat-container">
    <h2>Salon: <?= htmlspecialchars($room->name) ?></h2>

    <div class="messages">
        <?php foreach ($messages as $msg): ?>
            <div class="message">
                <b><?= htmlspecialchars($msg['pseudo']) ?>:</b>
                <span class="msg-text"><?= htmlspecialchars($msg['message']) ?></span>
                <i class="msg-time">(<?= $msg['timestamp'] ?>)</i>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="post" action="index.php?action=sendMessage&id=<?= $room->id ?>" class="chat-form">
        <input name="message" placeholder="Votre message..." required autocomplete="off" />
        <button class="button" type="submit">Envoyer</button>
    </form>

    <a href="index.php?action=rooms" class="link-back">← Retour aux salons</a>
</div>

<script>
    console.log('script loaded');

    const roomId = <?= json_encode($room->id) ?>;
    const userPseudo = <?= json_encode($_SESSION['user']['pseudo']) ?>;

    // Connect to your WebSocket server (adjust host and port if needed)
    const socket = new WebSocket('ws://localhost:8081');

    socket.addEventListener('open', () => {
        console.log('WebSocket connected');
    });

    socket.addEventListener('message', (event) => {
        const data = JSON.parse(event.data);

        // Only show messages for current room
        if (data.roomId === roomId) {
            const messagesDiv = document.querySelector('.messages');

            const messageEl = document.createElement('div');
            messageEl.classList.add('message');
            messageEl.innerHTML =
                `<b>${escapeHtml(data.pseudo)}:</b> <span class="msg-text">${escapeHtml(data.message)}</span> <i class="msg-time">(${data.timestamp})</i>`;

            messagesDiv.appendChild(messageEl);
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // scroll to bottom
        }
    });

    // Prevent XSS by escaping
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Intercept form submit to send message via AJAX + WebSocket
    const form = document.querySelector('.chat-form');
    const input = form.querySelector('input[name="message"]');

    form.addEventListener('submit', function(event) {
        alert("Message sent successfully!");
        console.log("Message sent successfully!");
        event.preventDefault();

        const message = input.value.trim();
        if (!message) return;

        // Send message to PHP backend to save it in DB
        fetch(`index.php?action=sendMessage&id=${roomId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                message
            })
        }).then(res => {
            if (!res.ok) throw new Error('Failed to send message');

            // Broadcast to other clients via WebSocket
            const msgData = {
                roomId: roomId,
                pseudo: userPseudo,
                message: message,
                timestamp: new Date().toLocaleTimeString()
            };
            socket.send(JSON.stringify(msgData));

            input.value = '';
        }).catch(console.error);
    });
</script>