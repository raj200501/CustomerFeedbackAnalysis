<?php

namespace App\Entity;

class Customer
{
    private int $id;
    private string $name;
    private string $email;
    private string $createdAt;

    public function __construct(int $id, string $name, string $email, string $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
