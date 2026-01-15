<?php
require_once __DIR__ . '/../../config/config.php';

use App\Support\Html;

$basePath = $app->config()->basePath();
$feedbacks = $app->feedbackRepository()->all();
$analyticsRepository = $app->analyticsRepository();
$responseRepository = $app->feedbackResponseRepository();

include __DIR__ . '/../../views/header.php';
?>
<section class="page">
    <h1>Manage Feedback</h1>
    <p>Review feedback, respond to customers, or remove entries.</p>

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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$feedbacks): ?>
                <tr>
                    <td colspan="8">No feedback yet.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($feedbacks as $feedback): ?>
                <?php $analytics = $analyticsRepository->forFeedback($feedback->id()); ?>
                <?php $responses = $responseRepository->forFeedback($feedback->id()); ?>
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
                            <em>No keywords</em>
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
                    <td>
                        <a href="<?php echo $basePath; ?>admin/respond.php?feedback_id=<?php echo Html::escape((string) $feedback->id()); ?>">Respond</a>
                        <a class="danger" href="<?php echo $basePath; ?>admin/delete_feedback.php?feedback_id=<?php echo Html::escape((string) $feedback->id()); ?>" onclick="return confirm('Delete this feedback?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a class="button" href="<?php echo $basePath; ?>index.php">Back to dashboard</a>
</section>
<?php include __DIR__ . '/../../views/footer.php'; ?>
