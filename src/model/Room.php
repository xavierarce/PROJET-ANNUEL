<?php
class Room
{
    public int $id;
    public string $name;
    public int $ownerId;
    public string $topic;
    public bool $is_private;
    public bool $is_archived;

    public function __construct(
        int $id,
        string $name,
        int $ownerId,
        string $topic,
        bool $is_private,
        bool $is_archived = false
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->ownerId = $ownerId;
        $this->topic = $topic;
        $this->is_private = $is_private;
        $this->is_archived = $is_archived;
    }
}
