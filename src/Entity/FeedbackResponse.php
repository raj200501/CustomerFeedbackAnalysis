<?php

namespace App\Entity;

class FeedbackResponse
{
    private int $id;
    private int $feedbackId;
    private int $userId;
    private string $responseText;
    private string $createdAt;

    public function __construct(int $id, int $feedbackId, int $userId, string $responseText, string $createdAt)
    {
        $this->id = $id;
        $this->feedbackId = $feedbackId;
        $this->userId = $userId;
        $this->responseText = $responseText;
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

    public function userId(): int
    {
        return $this->userId;
    }

    public function responseText(): string
    {
        return $this->responseText;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
