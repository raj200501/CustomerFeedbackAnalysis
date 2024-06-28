<?php

class Customer
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addCustomer($name, $email)
    {
        $stmt = $this->conn->prepare("INSERT INTO customers (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
        return $this->conn->lastInsertId();
    }

    public function getAllCustomers()
    {
        $stmt = $this->conn->query("SELECT * FROM customers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
