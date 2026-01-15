<?php

namespace App\Model;

use App\Entity\Feedback as FeedbackEntity;
use App\Repository\FeedbackRepository;

class Feedback
{
    private FeedbackRepository $repository;

    public function __construct(FeedbackRepository $repository)
    {
        $this->repository = $repository;
    }

    public function submitFeedback(int $customerId, string $feedbackText, int $rating, string $feedbackType): FeedbackEntity
    {
        return $this->repository->create($customerId, $feedbackText, $rating, $feedbackType);
    }

    public function getAllFeedback(): array
    {
        return $this->repository->all();
    }
}
