<?php
include_once '../config/config.php';
include_once '../src/Controller/AnalyticsController.php';

$analyticsController = new AnalyticsController($conn);
$analyticsData = $analyticsController->getAnalytics();

include '../views/header.php';
?>
<h1>Feedback Analytics</h1>
<table>
    <thead>
        <tr>
            <th>Feedback ID</th>
            <th>Keyword</th>
            <th>Sentiment Score</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($analyticsData as $data): ?>
        <tr>
            <td><?php echo htmlspecialchars($data['feedback_id']); ?></td>
            <td><?php echo htmlspecialchars($data['keyword']); ?></td>
            <td><?php echo htmlspecialchars($data['sentiment_score']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../views/footer.php'; ?>
