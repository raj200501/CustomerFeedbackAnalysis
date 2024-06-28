<?php
include_once '../config/config.php';
include_once '../src/Controller/FeedbackController.php';

$feedbackController = new FeedbackController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];
    $feedback_type = $_POST['feedback_type'];
    $feedbackController->submitFeedback($name, $email, $feedback, $rating, $feedback_type);
    header('Location: view_feedback.php');
}

include '../views/header.php';
?>
<h1>Submit Feedback</h1>
<form method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="feedback">Feedback:</label>
    <textarea id="feedback" name="feedback" required></textarea>
    <br>
    <label for="rating">Rating:</label>
    <input type="number" id="rating" name="rating" min="1" max="5" required>
    <br>
    <label for="feedback_type">Feedback Type:</label>
    <select id="feedback_type" name="feedback_type" required>
        <option value="Product">Product</option>
        <option value="Service">Service</option>
        <option value="Other">Other</option>
    </select>
    <br>
    <button type="submit">Submit</button>
</form>
<?php include '../views/footer.php'; ?>
