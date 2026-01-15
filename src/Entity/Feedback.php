<?php

namespace App\Entity;

class Feedback
{
    private int $id;
    private int $customerId;
    private string $customerName;
    private string $feedbackText;
    private int $rating;
    private string $feedbackType;
    private string $createdAt;

    public function __construct(
        int $id,
        int $customerId,
        string $customerName,
        string $feedbackText,
        int $rating,
        string $feedbackType,
        string $createdAt
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->customerName = $customerName;
        $this->feedbackText = $feedbackText;
        $this->rating = $rating;
        $this->feedbackType = $feedbackType;
        $this->createdAt = $createdAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function customerId(): int
    {
        return $this->customerId;
    }

    public function customerName(): string
    {
        return $this->customerName;
    }

    public function feedbackText(): string
    {
        return $this->feedbackText;
    }

    public function rating(): int
    {
        return $this->rating;
    }

    public function feedbackType(): string
    {
        return $this->feedbackType;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
