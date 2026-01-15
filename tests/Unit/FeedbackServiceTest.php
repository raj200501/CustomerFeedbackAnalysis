<?php

namespace Tests\Unit;

use Tests\Framework\TestCase;

class FeedbackServiceTest extends TestCase
{
    public function testSubmitCreatesFeedbackAndAnalytics(): void
    {
        $app = $GLOBALS['app'];
        $service = $app->feedbackService();

        $payload = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'feedback' => 'The product is amazing, fast, and reliable.',
            'rating' => 5,
            'feedback_type' => 'Product',
        ];

        $result = $service->submit($payload);

        $this->assertFalse($result['validation']->hasErrors(), 'Feedback should validate.');
        $this->assertTrue(isset($result['feedback']), 'Feedback entity should be returned.');
        $this->assertTrue(isset($result['analysis']), 'Analysis should be returned.');

        $analytics = $app->analyticsRepository()->forFeedback($result['feedback']->id());
        $this->assertNotEmpty($analytics, 'Analytics entries should be created.');
    }

    public function testValidationRejectsBadPayload(): void
    {
        $app = $GLOBALS['app'];
        $service = $app->feedbackService();

        $payload = [
            'name' => '',
            'email' => 'invalid-email',
            'feedback' => 'bad',
            'rating' => 10,
            'feedback_type' => 'Unknown',
        ];

        $result = $service->submit($payload);

        $this->assertTrue($result['validation']->hasErrors(), 'Validation should fail for invalid payload.');
    }
}
