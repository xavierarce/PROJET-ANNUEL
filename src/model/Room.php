<?php
class Room
{
    public int $id;
    public string $name;
    public int $owner_id;
    public string $topic;
    public bool $is_private;
    public bool $is_archived;

    public function __construct(
        int $id,
        string $name,
        int $owner_id,
        string $topic,
        bool $is_private,
        bool $is_archived = false
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->topic = $topic;
        $this->is_private = $is_private;
        $this->is_archived = $is_archived;
    }
}
