<?php

namespace App\Repository;

use App\Entity\Feedback;
use PDO;

class FeedbackRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $customerId, string $feedbackText, int $rating, string $feedbackType): Feedback
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO feedback (customer_id, feedback_text, rating, feedback_type) VALUES (:customer_id, :feedback_text, :rating, :feedback_type)'
        );
        $stmt->execute([
            'customer_id' => $customerId,
            'feedback_text' => $feedbackText,
            'rating' => $rating,
            'feedback_type' => $feedbackType,
        ]);

        $id = (int) $this->pdo->lastInsertId();
        $feedback = $this->findById($id);

        if ($feedback === null) {
            throw new \RuntimeException('Unable to load newly created feedback.');
        }

        return $feedback;
    }

    public function findById(int $id): ?Feedback
    {
        $stmt = $this->pdo->prepare(
            'SELECT f.*, c.name AS customer_name FROM feedback f JOIN customers c ON f.customer_id = c.id WHERE f.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Feedback(
            (int) $row['id'],
            (int) $row['customer_id'],
            $row['customer_name'],
            $row['feedback_text'],
            (int) $row['rating'],
            $row['feedback_type'],
            $row['created_at']
        );
    }

    public function all(): array
    {
        $stmt = $this->pdo->query(
            'SELECT f.*, c.name AS customer_name FROM feedback f JOIN customers c ON f.customer_id = c.id ORDER BY f.created_at DESC'
        );
        $rows = $stmt->fetchAll();

        $feedbackItems = [];
        foreach ($rows as $row) {
            $feedbackItems[] = new Feedback(
                (int) $row['id'],
                (int) $row['customer_id'],
                $row['customer_name'],
                $row['feedback_text'],
                (int) $row['rating'],
                $row['feedback_type'],
                $row['created_at']
            );
        }

        return $feedbackItems;
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM feedback WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
