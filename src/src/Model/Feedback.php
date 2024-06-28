<?php

class Feedback
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function submitFeedback($customerId, $feedbackText, $rating, $feedbackType)
    {
        $stmt = $this->conn->prepare("INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (:customer_id, :feedback_text, :rating, :feedback_type)");
        $stmt->execute([
            'customer_id' => $customerId,
            'feedback_text' => $feedbackText,
            'rating' => $rating,
            'feedback_type' => $feedbackType,
        ]);
    }

    public function getAllFeedback()
    {
        $stmt = $this->conn->query("SELECT f.*, c.name FROM feedback f JOIN customers c ON f.customer_id = c.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
