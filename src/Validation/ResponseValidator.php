<?php

namespace App\Validation;

class ResponseValidator
{
    public function validate(array $data): ValidationResult
    {
        $result = new ValidationResult();

        $response = trim((string) ($data['response_text'] ?? ''));
        if ($response === '') {
            $result->addError('response_text', 'Response text is required.');
        } elseif (mb_strlen($response) < 5) {
            $result->addError('response_text', 'Response text should be at least 5 characters.');
        }

        $userId = (int) ($data['user_id'] ?? 0);
        if ($userId <= 0) {
            $result->addError('user_id', 'A valid responder is required.');
        }

        return $result;
    }
}
