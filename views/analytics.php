<?php include 'header.php'; ?>
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
<?php include 'footer.php'; ?>
