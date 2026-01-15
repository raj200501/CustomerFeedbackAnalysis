<?php

namespace Tests\Unit;

use Tests\Framework\TestCase;

class AdminServiceTest extends TestCase
{
    public function testRespondToFeedbackCreatesResponse(): void
    {
        $app = $GLOBALS['app'];
        $feedbackService = $app->feedbackService();

        $payload = [
            'name' => 'Responder Test',
            'email' => 'responder@example.com',
            'feedback' => 'The service was good overall but had some delays.',
            'rating' => 4,
            'feedback_type' => 'Service',
        ];
        $result = $feedbackService->submit($payload);
        $feedbackId = $result['feedback']->id();

        $user = $app->userRepository()->create('unit_admin', 'password', 'admin');

        $responsePayload = [
            'user_id' => $user->id(),
            'response_text' => 'Thanks for sharing the details, we will follow up.',
        ];

        $responseResult = $app->adminService()->respondToFeedback($feedbackId, $responsePayload);
        $this->assertFalse($responseResult['validation']->hasErrors(), 'Response should validate.');

        $responses = $app->feedbackResponseRepository()->forFeedback($feedbackId);
        $this->assertNotEmpty($responses, 'Response should be persisted.');
    }
}
