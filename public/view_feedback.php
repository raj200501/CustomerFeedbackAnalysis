<?php
require_once __DIR__ . '/../config/config.php';

use App\Support\Html;

$basePath = $app->config()->basePath();
$feedbackRepository = $app->feedbackRepository();
$responseRepository = $app->feedbackResponseRepository();
$analyticsRepository = $app->analyticsRepository();
$feedbacks = $feedbackRepository->all();

include __DIR__ . '/../views/header.php';
?>
<section class="page">
    <h1>View Feedback</h1>
    <p>Browse all feedback submitted by customers. Each entry includes the automatically extracted keywords.</p>

    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Feedback</th>
                <th>Rating</th>
                <th>Type</th>
                <th>Keywords</th>
                <th>Responses</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$feedbacks): ?>
                <tr>
                    <td colspan="7">No feedback has been submitted yet.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($feedbacks as $feedback): ?>
                <?php
                    $analytics = $analyticsRepository->forFeedback($feedback->id());
                    $responses = $responseRepository->forFeedback($feedback->id());
                ?>
                <tr>
                    <td><?php echo Html::escape($feedback->customerName()); ?></td>
                    <td><?php echo Html::escape($feedback->feedbackText()); ?></td>
                    <td><?php echo Html::escape((string) $feedback->rating()); ?></td>
                    <td><?php echo Html::escape($feedback->feedbackType()); ?></td>
                    <td>
                        <?php if ($analytics): ?>
                            <ul class="tag-list">
                                <?php foreach ($analytics as $entry): ?>
                                    <li><?php echo Html::escape($entry->keyword()); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <em>No keywords yet.</em>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($responses): ?>
                            <ul class="response-list">
                                <?php foreach ($responses as $response): ?>
                                    <li><?php echo Html::escape($response->responseText()); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <em>No responses</em>
                        <?php endif; ?>
                    </td>
                    <td><?php echo Html::escape($feedback->createdAt()); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php include __DIR__ . '/../views/footer.php'; ?>
