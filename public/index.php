<?php
require_once __DIR__ . '/../config/config.php';

$basePath = $app->config()->basePath();

include __DIR__ . '/../views/header.php';
?>
<section class="hero">
    <h1>Customer Feedback Analysis System</h1>
    <p>Capture customer feedback, run lightweight sentiment analytics, and respond to customers with confidence.</p>
</section>
<section class="quick-links">
    <a class="card" href="<?php echo $basePath; ?>submit_feedback.php">Submit Feedback</a>
    <a class="card" href="<?php echo $basePath; ?>view_feedback.php">View Feedback</a>
    <a class="card" href="<?php echo $basePath; ?>analytics.php">View Analytics</a>
    <a class="card" href="<?php echo $basePath; ?>admin/manage_customers.php">Manage Customers</a>
    <a class="card" href="<?php echo $basePath; ?>admin/manage_feedback.php">Manage Feedback</a>
</section>
<?php include __DIR__ . '/../views/footer.php'; ?>
