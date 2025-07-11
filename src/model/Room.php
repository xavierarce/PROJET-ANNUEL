<?php
class Room
{
    public int $id;
    public string $name;
    public int $ownerId;
    public string $topic;
    public bool $isPrivate;

    public function __construct(int $id, string $name, int $ownerId, string $topic, bool $isPrivate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ownerId = $ownerId;
        $this->topic = $topic;
        $this->isPrivate = $isPrivate;
    }
}
