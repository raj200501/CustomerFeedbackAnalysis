<?php

namespace App\Entity;

class User
{
    private int $id;
    private string $username;
    private string $role;
    private string $createdAt;

    public function __construct(int $id, string $username, string $role, string $createdAt)
    {
        $this->id = $id;
        $this->username = $username;
        $this->role = $role;
        $this->createdAt = $createdAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function role(): string
    {
        return $this->role;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
