<?php
// Classe rooms pour la gestion des rooms
require_once __DIR__ . '/DB.php';

class Room
{
    public static function getAll()
    {
        $db = DB::connect();
        return $db->query('SELECT * FROM rooms')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getById($id)
    {
        $db = DB::connect();
        $stmt = $db->prepare('SELECT * FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($name, $owner_id, $topic = '', $is_private = 0)
    {
        $db = DB::connect();
        $stmt = $db->prepare('INSERT INTO rooms (name, owner_id, topic, is_private) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$name, $owner_id, $topic, $is_private])) {
            return $db->lastInsertId();
        }
        return false;
    }
}
