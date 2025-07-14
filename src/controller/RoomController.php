<?php
require_once __DIR__ . '/../service/RoomService.php';
require_once __DIR__ . '/../service/MessageService.php'; // Assuming you have this
require_once __DIR__ . '/BaseController.php';

class RoomController extends BaseController
{
    private RoomService $roomService;

    public function __construct()
    {
        $this->roomService = new RoomService();
    }

    public function rooms()
    {

        $rooms = $this->roomService->getAllVisibleRooms(); // update this method in RoomService/DAO
        require __DIR__ . '/../view/rooms.php';
    }


    public function chat()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
            exit;
        }

        $roomId = (int)($_GET['id'] ?? 1);
        $room = $this->roomService->getRoomById($roomId);

        if ($room === null || $room->is_archived) {
            $this->redirect('login');
            exit;
        }

        $messages = MessageService::getMessagesByRoom($roomId);

        require __DIR__ . '/../view/chat.php';
    }


    public function showCreateRoomForm()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
            exit;
        }

        require __DIR__ . '/../view/createRoom.php';
    }

    public function handleCreateRoom()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $topic = trim($_POST['topic'] ?? '');
        $isPrivate = isset($_POST['is_private']) && $_POST['is_private'] === '1';
        $isVisibleRaw = $_POST['is_visible'] ?? '1';
        $isVisible = $isVisibleRaw === '1' ? true : false;


        try {
            $this->roomService->createRoom($name, $_SESSION['user']['id'], $topic, $isPrivate, $isVisible);
            $this->redirect('rooms');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../view/createRoom.php';
        }
    }


    public function archiveRoom()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
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

        $this->redirect('rooms');
        exit;
    }

    public function updateRoom(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
            exit;
        }

        $roomId = $_GET['id'] ?? null;
        $newName = trim($_POST['new_name'] ?? '');
        $isPrivate = isset($_POST['is_private']) && $_POST['is_private'] === '1';
        $isVisibleRaw = $_POST['is_visible'] ?? '1';
        $isVisible = $isVisibleRaw === '1' ? true : false;
        $userId = $_SESSION['user']['id'];

        try {
            RoomService::updateRoom((int)$roomId, $userId, $newName, $isPrivate, $isVisible);
            $_SESSION['success'] = "Salon mis à jour.";
            $this->redirect('chat&id=' . urlencode($roomId));
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $this->redirect('chat&id=' . urlencode($roomId));
        }

        exit;
    }
}
