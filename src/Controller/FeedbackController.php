<?php

namespace App\Controller;

use App\Service\FeedbackService;
use App\Validation\ValidationResult;

class FeedbackController
{
    private FeedbackService $service;

    public function __construct(FeedbackService $service)
    {
        $this->service = $service;
    }

    public function submit(array $payload): array
    {
        $result = $this->service->submit($payload);
        return $result;
    }

    public function validationResult(array $result): ValidationResult
    {
        return $result['validation'] ?? new ValidationResult();
    }
}
