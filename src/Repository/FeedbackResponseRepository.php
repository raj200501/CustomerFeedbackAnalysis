<?php

namespace App\Repository;

use App\Entity\FeedbackResponse;
use PDO;

class FeedbackResponseRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $feedbackId, int $userId, string $responseText): FeedbackResponse
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO feedback_responses (feedback_id, user_id, response_text) VALUES (:feedback_id, :user_id, :response_text)'
        );
        $stmt->execute([
            'feedback_id' => $feedbackId,
            'user_id' => $userId,
            'response_text' => $responseText,
        ]);
        $id = (int) $this->pdo->lastInsertId();
        return $this->findById($id);
    }

    public function findById(int $id): ?FeedbackResponse
    {
        $stmt = $this->pdo->prepare('SELECT * FROM feedback_responses WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new FeedbackResponse(
            (int) $row['id'],
            (int) $row['feedback_id'],
            (int) $row['user_id'],
            $row['response_text'],
            $row['created_at']
        );
    }

    public function forFeedback(int $feedbackId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM feedback_responses WHERE feedback_id = :feedback_id ORDER BY created_at DESC');
        $stmt->execute(['feedback_id' => $feedbackId]);
        $rows = $stmt->fetchAll();

        $responses = [];
        foreach ($rows as $row) {
            $responses[] = new FeedbackResponse(
                (int) $row['id'],
                (int) $row['feedback_id'],
                (int) $row['user_id'],
                $row['response_text'],
                $row['created_at']
            );
        }

        return $responses;
    }

    public function deleteForFeedback(int $feedbackId): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM feedback_responses WHERE feedback_id = :feedback_id');
        $stmt->execute(['feedback_id' => $feedbackId]);
    }
}
