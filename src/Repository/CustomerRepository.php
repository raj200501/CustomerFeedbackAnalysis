<?php

namespace App\Repository;

use App\Entity\Customer;
use PDO;

class CustomerRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(string $name, string $email): Customer
    {
        $stmt = $this->pdo->prepare('INSERT INTO customers (name, email) VALUES (:name, :email)');
        $stmt->execute(['name' => $name, 'email' => $email]);
        $id = (int) $this->pdo->lastInsertId();

        return $this->findById($id);
    }

    public function findById(int $id): ?Customer
    {
        $stmt = $this->pdo->prepare('SELECT * FROM customers WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Customer((int) $row['id'], $row['name'], $row['email'], $row['created_at']);
    }

    public function findByEmail(string $email): ?Customer
    {
        $stmt = $this->pdo->prepare('SELECT * FROM customers WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Customer((int) $row['id'], $row['name'], $row['email'], $row['created_at']);
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM customers ORDER BY created_at DESC');
        $rows = $stmt->fetchAll();

        $customers = [];
        foreach ($rows as $row) {
            $customers[] = new Customer((int) $row['id'], $row['name'], $row['email'], $row['created_at']);
        }

        return $customers;
    }
}
