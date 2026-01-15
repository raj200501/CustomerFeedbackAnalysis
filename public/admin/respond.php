<?php
require_once __DIR__ . '/../../config/config.php';

use App\Support\Html;

$basePath = $app->config()->basePath();
$feedbackId = (int) ($_GET['feedback_id'] ?? 0);
$feedback = $app->feedbackRepository()->findById($feedbackId);
$users = $app->userRepository()->all();
$errors = [];
$success = false;
$payload = [
    'user_id' => $users[0]->id() ?? 0,
    'response_text' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
        'user_id' => $_POST['user_id'] ?? 0,
        'response_text' => $_POST['response_text'] ?? '',
    ];

    $result = $app->adminService()->respondToFeedback($feedbackId, $payload);
    $validation = $result['validation'];
    if ($validation->hasErrors()) {
        $errors = $validation->errors();
    } else {
        $success = true;
        $payload['response_text'] = '';
    }
}

include __DIR__ . '/../../views/header.php';
?>
<section class="page">
    <h1>Respond to Feedback</h1>
    <?php if ($feedback === null): ?>
        <div class="alert error">Feedback entry not found.</div>
        <a class="button" href="<?php echo $basePath; ?>admin/manage_feedback.php">Back</a>
    <?php else: ?>
        <div class="card">
            <h2><?php echo Html::escape($feedback->customerName()); ?></h2>
            <p><?php echo Html::escape($feedback->feedbackText()); ?></p>
        </div>

        <?php if (!$users): ?>
            <div class="alert error">No responders available. Seed the database or create a user.</div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success">Response saved.</div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert error">
                <ul>
                    <?php foreach ($errors as $messages): ?>
                        <?php foreach ($messages as $message): ?>
                            <li><?php echo Html::escape($message); ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" class="form">
            <label for="user_id">Responder</label>
            <select id="user_id" name="user_id" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo Html::escape((string) $user->id()); ?>" <?php echo (int) $payload['user_id'] === $user->id() ? 'selected' : ''; ?>>
                        <?php echo Html::escape($user->username() . ' (' . $user->role() . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="response_text">Response</label>
            <textarea id="response_text" name="response_text" rows="4" required><?php echo Html::escape($payload['response_text']); ?></textarea>

            <button type="submit">Save Response</button>
            <a class="button secondary" href="<?php echo $basePath; ?>admin/manage_feedback.php">Cancel</a>
        </form>
    <?php endif; ?>
</section>
<?php include __DIR__ . '/../../views/footer.php'; ?>
