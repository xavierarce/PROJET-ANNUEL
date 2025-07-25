<?php
class Room
{
    public int $id;
    public string $name;
    public int $owner_id;
    public string $topic;
    public bool $is_private;
    private ?string $password;
    public bool $is_visible;
    public bool $is_archived;

    public function __construct(
        int $id,
        string $name,
        int $owner_id,
        string $topic,
        bool $is_private,
        bool $is_visible,
        bool $is_archived = false,
        ?string $password = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->topic = $topic;
        $this->is_private = $is_private;
        $this->is_visible = $is_visible;
        $this->is_archived = $is_archived;
        $this->password = $password;
    }

    public function checkPassword(string $input): bool
    {
        if ($this->password === null) return true;
        return password_verify($input, $this->password);
    }
}
