<?php

namespace App\Repository;

use App\Entity\AnalyticsEntry;
use PDO;

class AnalyticsRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $feedbackId, string $keyword, float $sentimentScore): AnalyticsEntry
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO analytics (feedback_id, keyword, sentiment_score) VALUES (:feedback_id, :keyword, :sentiment_score)'
        );
        $stmt->execute([
            'feedback_id' => $feedbackId,
            'keyword' => $keyword,
            'sentiment_score' => $sentimentScore,
        ]);
        $id = (int) $this->pdo->lastInsertId();
        return $this->findById($id);
    }

    public function findById(int $id): ?AnalyticsEntry
    {
        $stmt = $this->pdo->prepare('SELECT * FROM analytics WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new AnalyticsEntry(
            (int) $row['id'],
            (int) $row['feedback_id'],
            $row['keyword'],
            (float) $row['sentiment_score'],
            $row['created_at'] ?? ''
        );
    }

    public function forFeedback(int $feedbackId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM analytics WHERE feedback_id = :feedback_id ORDER BY id ASC');
        $stmt->execute(['feedback_id' => $feedbackId]);
        $rows = $stmt->fetchAll();

        $entries = [];
        foreach ($rows as $row) {
            $entries[] = new AnalyticsEntry(
                (int) $row['id'],
                (int) $row['feedback_id'],
                $row['keyword'],
                (float) $row['sentiment_score'],
                $row['created_at'] ?? ''
            );
        }

        return $entries;
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM analytics ORDER BY id DESC');
        $rows = $stmt->fetchAll();

        $entries = [];
        foreach ($rows as $row) {
            $entries[] = new AnalyticsEntry(
                (int) $row['id'],
                (int) $row['feedback_id'],
                $row['keyword'],
                (float) $row['sentiment_score'],
                $row['created_at'] ?? ''
            );
        }

        return $entries;
    }
}
