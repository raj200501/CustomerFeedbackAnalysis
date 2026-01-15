<?php

namespace App\Validation;

class FeedbackValidator
{
    private const TYPES = ['Product', 'Service', 'Other'];

    public function validate(array $data): ValidationResult
    {
        $result = new ValidationResult();

        $name = trim((string) ($data['name'] ?? ''));
        if ($name === '') {
            $result->addError('name', 'Name is required.');
        }

        $email = trim((string) ($data['email'] ?? ''));
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result->addError('email', 'A valid email address is required.');
        }

        $feedback = trim((string) ($data['feedback'] ?? ''));
        if ($feedback === '') {
            $result->addError('feedback', 'Feedback text is required.');
        } elseif (mb_strlen($feedback) < 10) {
            $result->addError('feedback', 'Feedback should be at least 10 characters.');
        }

        $rating = (int) ($data['rating'] ?? 0);
        if ($rating < 1 || $rating > 5) {
            $result->addError('rating', 'Rating must be between 1 and 5.');
        }

        $type = $data['feedback_type'] ?? '';
        if (!in_array($type, self::TYPES, true)) {
            $result->addError('feedback_type', 'Feedback type must be Product, Service, or Other.');
        }

        return $result;
    }
}
