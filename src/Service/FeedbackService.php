<?php

namespace App\Service;

use App\Repository\AnalyticsRepository;
use App\Repository\CustomerRepository;
use App\Repository\FeedbackRepository;
use App\Validation\FeedbackValidator;
use App\Validation\ValidationResult;

class FeedbackService
{
    private CustomerRepository $customerRepository;
    private FeedbackRepository $feedbackRepository;
    private AnalyticsRepository $analyticsRepository;
    private AnalyticsService $analyticsService;
    private FeedbackValidator $validator;

    public function __construct(
        CustomerRepository $customerRepository,
        FeedbackRepository $feedbackRepository,
        AnalyticsRepository $analyticsRepository,
        AnalyticsService $analyticsService,
        FeedbackValidator $validator
    ) {
        $this->customerRepository = $customerRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->analyticsRepository = $analyticsRepository;
        $this->analyticsService = $analyticsService;
        $this->validator = $validator;
    }

    public function submit(array $payload): array
    {
        $validation = $this->validator->validate($payload);
        if ($validation->hasErrors()) {
            return ['validation' => $validation];
        }

        $customer = $this->customerRepository->findByEmail($payload['email']);
        if ($customer === null) {
            $customer = $this->customerRepository->create($payload['name'], $payload['email']);
        }

        $feedback = $this->feedbackRepository->create(
            $customer->id(),
            $payload['feedback'],
            (int) $payload['rating'],
            $payload['feedback_type']
        );

        $analysis = $this->analyticsService->analyze($payload['feedback']);

        foreach ($analysis['keywords'] as $keyword) {
            $this->analyticsRepository->create($feedback->id(), $keyword, $analysis['sentimentScore']);
        }

        return [
            'feedback' => $feedback,
            'analysis' => $analysis,
            'validation' => new ValidationResult(),
        ];
    }
}
