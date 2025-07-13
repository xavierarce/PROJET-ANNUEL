<?php
class User
{
    public int $id;
    public string $pseudo;
    public string $login;
    private string $password;
    public string $email;
    public int $role_id;

    public function __construct(int $id, string $pseudo, string $login, string $password, string $email, int $role_id)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->role_id = $role_id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'pseudo' => $this->pseudo,
            'login' => $this->login,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }
}
