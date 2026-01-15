<?php
require_once __DIR__ . '/../config/config.php';

use App\Support\Html;

$basePath = $app->config()->basePath();
$analyticsEntries = $app->analyticsRepository()->all();

include __DIR__ . '/../views/header.php';
?>
<section class="page">
    <h1>Feedback Analytics</h1>
    <p>Keywords are extracted from feedback submissions along with a simple sentiment score.</p>

    <table class="table">
        <thead>
            <tr>
                <th>Feedback ID</th>
                <th>Keyword</th>
                <th>Sentiment Score</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$analyticsEntries): ?>
                <tr>
                    <td colspan="3">No analytics entries yet. Submit feedback to populate this report.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($analyticsEntries as $entry): ?>
                <tr>
                    <td><?php echo Html::escape((string) $entry->feedbackId()); ?></td>
                    <td><?php echo Html::escape($entry->keyword()); ?></td>
                    <td><?php echo Html::escape(number_format($entry->sentimentScore(), 2)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php include __DIR__ . '/../views/footer.php'; ?>
