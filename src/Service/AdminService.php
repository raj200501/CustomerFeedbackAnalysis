<?php

namespace App\Service;

use App\Repository\FeedbackRepository;
use App\Repository\FeedbackResponseRepository;
use App\Repository\UserRepository;
use App\Validation\ResponseValidator;
use App\Validation\ValidationResult;

class AdminService
{
    private FeedbackRepository $feedbackRepository;
    private FeedbackResponseRepository $responseRepository;
    private UserRepository $userRepository;
    private ResponseValidator $responseValidator;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        FeedbackResponseRepository $responseRepository,
        UserRepository $userRepository,
        ResponseValidator $responseValidator
    ) {
        $this->feedbackRepository = $feedbackRepository;
        $this->responseRepository = $responseRepository;
        $this->userRepository = $userRepository;
        $this->responseValidator = $responseValidator;
    }

    public function respondToFeedback(int $feedbackId, array $payload): array
    {
        $validation = $this->responseValidator->validate($payload);
        if ($validation->hasErrors()) {
            return ['validation' => $validation];
        }

        $feedback = $this->feedbackRepository->findById($feedbackId);
        if ($feedback === null) {
            $validation = new ValidationResult();
            $validation->addError('feedback', 'Feedback not found.');
            return ['validation' => $validation];
        }

        $user = $this->userRepository->findById((int) $payload['user_id']);
        if ($user === null) {
            $validation = new ValidationResult();
            $validation->addError('user_id', 'Responder not found.');
            return ['validation' => $validation];
        }

        $response = $this->responseRepository->create($feedbackId, $user->id(), $payload['response_text']);

        return [
            'response' => $response,
            'validation' => new ValidationResult(),
        ];
    }

    public function deleteFeedback(int $feedbackId): void
    {
        $this->responseRepository->deleteForFeedback($feedbackId);
        $this->feedbackRepository->delete($feedbackId);
    }
}
