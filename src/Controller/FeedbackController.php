<?php

class FeedbackController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function submitFeedback($name, $email, $feedback, $rating, $feedback_type)
    {
        $stmt = $this->conn->prepare("INSERT INTO customers (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
        $customerId = $this->conn->lastInsertId();

        $stmt = $this->conn->prepare("INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (:customer_id, :feedback_text, :rating, :feedback_type)");
        $stmt->execute([
            'customer_id' => $customerId,
            'feedback_text' => $feedback,
            'rating' => $rating,
            'feedback_type' => $feedback_type,
        ]);
    }

    public function getAllFeedback()
    {
        $stmt = $this->conn->query("SELECT f.*, c.name FROM feedback f JOIN customers c ON f.customer_id = c.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
