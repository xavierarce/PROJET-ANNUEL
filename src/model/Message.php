<?php
class Message
{
    public int $id;
    public int $user_id;
    public int $room_id;
    public string $message;
    public string $timestamp;

    public function __construct($id, $user_id, $room_id, $message, $timestamp)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->room_id = $room_id;
        $this->message = $message;
        $this->timestamp = $timestamp;
    }
}
