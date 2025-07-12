<?php
require_once __DIR__ . '/../service/RoomService.php';
require_once __DIR__ . '/../service/MessageService.php'; // Assuming you have this

class RoomController
{
    private RoomService $roomService;

    public function __construct()
    {
        $this->roomService = new RoomService();
    }

    public function rooms()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $rooms = $this->roomService->getAllRooms();
        require __DIR__ . '/../view/rooms.php';
    }

    public function chat()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $roomId = (int)($_GET['id'] ?? 1);
        $room = $this->roomService->getRoomById($roomId);

        if ($room === null) {
            header('HTTP/1.0 404 Not Found');
            echo 'Room not found';
            exit;
        }

        $messages = MessageService::getMessagesByRoom($roomId);

        require __DIR__ . '/../view/chat.php';
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
            $isPrivate = isset($_POST['is_private']);

            try {
                $this->roomService->createRoom($name, $_SESSION['user']['id'], $topic, $isPrivate);
                header('Location: index.php?action=rooms');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            require __DIR__ . '/../view/createRoom.php';
        } else {
            require __DIR__ . '/../view/createRoom.php';
        }
    }
}
