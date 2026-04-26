<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit("Not logged in");
}

require_once "db.php";

if (!isset($_GET['id'])) {
    exit("No chat ID");
}

$chatId = intval($_GET['id']);

$stmt = $conn->prepare("SELECT role, message, timestamp 
                        FROM chat_history 
                        WHERE user_id = ? AND chat_session_id = ?
                        ORDER BY timestamp ASC");
$stmt->bind_param("ii", $_SESSION['user_id'], $sessionId);

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div><strong>" . htmlspecialchars($row['role']) . ":</strong> " 
         . htmlspecialchars($row['message']) . "</div>";
}

$stmt->close();
$conn->close();
?>
