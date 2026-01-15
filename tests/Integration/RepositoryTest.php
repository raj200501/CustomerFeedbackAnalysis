<?php

namespace Tests\Integration;

use Tests\Framework\TestCase;

class RepositoryTest extends TestCase
{
    public function testCustomerRepositoryCreatesAndFinds(): void
    {
        $app = $GLOBALS['app'];
        $repository = $app->customerRepository();

        $customer = $repository->create('Integration User', 'integration@example.com');
        $found = $repository->findByEmail('integration@example.com');

        $this->assertSame($customer->id(), $found->id(), 'Customer should be retrievable by email.');
    }

    public function testFeedbackRepositoryStoresFeedback(): void
    {
        $app = $GLOBALS['app'];
        $customer = $app->customerRepository()->create('Feedback Owner', 'feedbackowner@example.com');

        $feedback = $app->feedbackRepository()->create($customer->id(), 'I enjoyed the onboarding experience.', 5, 'Service');
        $allFeedback = $app->feedbackRepository()->all();

        $this->assertTrue(count($allFeedback) >= 1, 'Feedback should be listed.');
        $this->assertSame($feedback->feedbackType(), 'Service', 'Feedback type should match.');
    }
}
