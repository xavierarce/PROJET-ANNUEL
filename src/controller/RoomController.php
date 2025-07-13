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

        $rooms = $this->roomService->getAllVisibleRooms(); // update this method in RoomService/DAO
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

        if ($room === null || $room->is_archived) {
            header('Location: index.php?action=login');
            exit;
        }

        $messages = MessageService::getMessagesByRoom($roomId);

        require __DIR__ . '/../view/chat.php';
    }


    public function showCreateRoomForm()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        require __DIR__ . '/../view/createRoom.php';
    }

    public function handleCreateRoom()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $topic = $_POST['topic'] ?? '';
        $is_private = isset($_POST['is_private']);

        try {
            $this->roomService->createRoom($name, $_SESSION['user']['id'], $topic, $is_private);
            header('Location: index.php?action=rooms');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../view/createRoom.php';
        }
    }


    public function archiveRoom()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user = $_SESSION['user'];

        if ($user['role_id'] !== 1) { // 1 = Admin
            http_response_code(403);
            echo "Vous n'avez pas les droits pour archiver une salle.";
            exit;
        }

        $roomId = $_POST['room_id'] ?? null;
        if ($roomId) {
            try {
                $this->roomService->archiveRoom((int)$roomId);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        header('Location: index.php?action=rooms');
        exit;
    }
}
