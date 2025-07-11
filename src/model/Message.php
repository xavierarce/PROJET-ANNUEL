<?php
// Classe messages pour la gestion des messages
require_once __DIR__ . '/DB.php';

class Message
{
    public static function getByRoom($room_id)
    {
        $db = DB::connect();
        $stmt = $db->prepare('SELECT m.*, u.pseudo FROM messages m JOIN users u ON m.user_id = u.id WHERE room_id = ? ORDER BY timestamp ASC');
        $stmt->execute([$room_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function add($user_id, $room_id, $message)
    {
        $db = DB::connect();
        $stmt = $db->prepare('INSERT INTO messages (user_id, room_id, message) VALUES (?, ?, ?)');
        return $stmt->execute([$user_id, $room_id, $message]);
    }
}
