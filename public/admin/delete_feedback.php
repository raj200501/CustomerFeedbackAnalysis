<?php
require_once __DIR__ . '/../../config/config.php';

$basePath = $app->config()->basePath();
$feedbackId = (int) ($_GET['feedback_id'] ?? 0);

if ($feedbackId > 0) {
    $app->adminService()->deleteFeedback($feedbackId);
}

header('Location: ' . $basePath . 'admin/manage_feedback.php');
exit;
