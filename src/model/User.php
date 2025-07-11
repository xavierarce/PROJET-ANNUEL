<?php
class User
{
    public int $id;
    public string $pseudo;
    public string $login;
    public string $password;
    public string $email;
    public int $roleId;

    public function __construct(int $id, string $pseudo, string $login, string $password, string $email, int $roleId)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->roleId = $roleId;
    }
}
