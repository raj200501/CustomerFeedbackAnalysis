<?php include 'header.php'; ?>
<h1>View Feedback</h1>
<table>
    <thead>
        <tr>
            <th>Customer</th>
            <th>Feedback</th>
            <th>Rating</th>
            <th>Type</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($feedbacks as $feedback): ?>
        <tr>
            <td><?php echo htmlspecialchars($feedback['name']); ?></td>
            <td><?php echo htmlspecialchars($feedback['feedback_text']); ?></td>
            <td><?php echo htmlspecialchars($feedback['rating']); ?></td>
            <td><?php echo htmlspecialchars($feedback['feedback_type']); ?></td>
            <td><?php echo htmlspecialchars($feedback['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
