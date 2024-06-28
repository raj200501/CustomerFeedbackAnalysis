<?php
include_once '../../config/config.php';
include_once '../../src/Controller/FeedbackController.php';

$feedbackController = new FeedbackController($conn);
$feedbacks = $feedbackController->getAllFeedback();

include '../../views/header.php';
?>
<h1>Manage Feedback</h1>
<table>
    <thead>
        <tr>
            <th>Customer</th>
            <th>Feedback</th>
            <th>Rating</th>
            <th>Type</th>
            <th>Submitted At</th>
            <th>Actions</th>
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
            <td>
                <a href="respond.php?feedback_id=<?php echo $feedback['id']; ?>">Respond</a>
                <a href="delete_feedback.php?feedback_id=<?php echo $feedback['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../../views/footer.php'; ?>
