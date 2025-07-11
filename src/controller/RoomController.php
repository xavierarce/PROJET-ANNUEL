<?php
// Contrôleur pour la gestion des rooms

require_once __DIR__ . '/../model/Room.php';    // modèle Room, pas Room
require_once __DIR__ . '/../model/Message.php';

class RoomController
{
    public function rooms()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $rooms = Room::getAll();
        require __DIR__ . '/../view/rooms.php';
    }
    public function chat()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $roomId = $_GET['id'] ?? 1;
        $room = Room::getById($roomId);
        $messages = Message::getByRoom($roomId);
        require __DIR__ . '/../view/chat.php';
    }

    public function sendMessage()
    {
        if (isset($_SESSION['user'], $_POST['message'], $_GET['id'])) {
            Message::add($_SESSION['user']['id'], $_GET['id'], $_POST['message']);
        }
        header('Location: index.php?action=chat&id=' . $_GET['id']);
        exit;
    }
    public function createRoom()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $topic = $_POST['topic'] ?? '';
            $is_private = isset($_POST['is_private']) ? 1 : 0;
            if ($name) {
                $id = Room::create($name, $_SESSION['user']['id'], $topic, $is_private);
                if ($id) {
                    $success = 'Room créé !';
                    header('Location: index.php?action=rooms');
                    exit;
                } else {
                    $error = 'Erreur lors de la création.';
                }
            } else {
                $error = 'Le nom est obligatoire.';
            }
            require __DIR__ . '/../view/createRoom.php';
        } else {
            require __DIR__ . '/../view/createRoom.php';
        }
    }
}
