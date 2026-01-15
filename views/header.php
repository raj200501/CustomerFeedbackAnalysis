<?php
$basePath = $basePath ?? '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback Analysis System</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>styles.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1>Customer Feedback Analysis System</h1>
            <nav>
                <ul>
                    <li><a href="<?php echo $basePath; ?>index.php">Home</a></li>
                    <li><a href="<?php echo $basePath; ?>submit_feedback.php">Submit Feedback</a></li>
                    <li><a href="<?php echo $basePath; ?>view_feedback.php">View Feedback</a></li>
                    <li><a href="<?php echo $basePath; ?>analytics.php">View Analytics</a></li>
                    <li><a href="<?php echo $basePath; ?>admin/manage_customers.php">Manage Customers</a></li>
                    <li><a href="<?php echo $basePath; ?>admin/manage_feedback.php">Manage Feedback</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
