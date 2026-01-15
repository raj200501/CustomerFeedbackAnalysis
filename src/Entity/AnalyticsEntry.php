<?php

namespace App\Entity;

class AnalyticsEntry
{
    private int $id;
    private int $feedbackId;
    private string $keyword;
    private float $sentimentScore;
    private string $createdAt;

    public function __construct(int $id, int $feedbackId, string $keyword, float $sentimentScore, string $createdAt)
    {
        $this->id = $id;
        $this->feedbackId = $feedbackId;
        $this->keyword = $keyword;
        $this->sentimentScore = $sentimentScore;
        $this->createdAt = $createdAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function feedbackId(): int
    {
        return $this->feedbackId;
    }

    public function keyword(): string
    {
        return $this->keyword;
    }

    public function sentimentScore(): float
    {
        return $this->sentimentScore;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
