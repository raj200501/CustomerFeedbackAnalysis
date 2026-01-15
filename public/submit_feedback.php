<?php
require_once __DIR__ . '/../config/config.php';

use App\Support\Html;

$basePath = $app->config()->basePath();
$feedbackService = $app->feedbackService();
$errors = [];
$success = false;
$payload = [
    'name' => '',
    'email' => '',
    'feedback' => '',
    'rating' => 5,
    'feedback_type' => 'Product',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'feedback' => $_POST['feedback'] ?? '',
        'rating' => $_POST['rating'] ?? 0,
        'feedback_type' => $_POST['feedback_type'] ?? '',
    ];

    $result = $feedbackService->submit($payload);
    $validation = $result['validation'];
    if ($validation->hasErrors()) {
        $errors = $validation->errors();
    } else {
        $success = true;
        $payload = [
            'name' => '',
            'email' => '',
            'feedback' => '',
            'rating' => 5,
            'feedback_type' => 'Product',
        ];
    }
}

include __DIR__ . '/../views/header.php';
?>
<section class="page">
    <h1>Submit Feedback</h1>
    <p>Share your experience. We automatically analyze keywords and sentiment for your submission.</p>

    <?php if ($success): ?>
        <div class="alert success">Thanks for your feedback! You can view it in the feedback list.</div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="alert error">
            <strong>Please fix the following issues:</strong>
            <ul>
                <?php foreach ($errors as $messages): ?>
                    <?php foreach ($messages as $message): ?>
                        <li><?php echo Html::escape($message); ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="form" action="<?php echo $basePath; ?>submit_feedback.php">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required value="<?php echo Html::escape($payload['name']); ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required value="<?php echo Html::escape($payload['email']); ?>">

        <label for="feedback">Feedback</label>
        <textarea id="feedback" name="feedback" rows="5" required><?php echo Html::escape($payload['feedback']); ?></textarea>

        <label for="rating">Rating (1-5)</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required value="<?php echo Html::escape((string) $payload['rating']); ?>">

        <label for="feedback_type">Feedback Type</label>
        <select id="feedback_type" name="feedback_type" required>
            <?php foreach (['Product', 'Service', 'Other'] as $type): ?>
                <option value="<?php echo Html::escape($type); ?>" <?php echo $payload['feedback_type'] === $type ? 'selected' : ''; ?>>
                    <?php echo Html::escape($type); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Submit</button>
    </form>
</section>
<?php include __DIR__ . '/../views/footer.php'; ?>
