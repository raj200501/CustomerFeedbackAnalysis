<?php
require_once __DIR__ . '/../../config/config.php';

use App\Support\Html;

$basePath = $app->config()->basePath();
$customers = $app->customerRepository()->all();

include __DIR__ . '/../../views/header.php';
?>
<section class="page">
    <h1>Manage Customers</h1>
    <p>Review customers who have submitted feedback.</p>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$customers): ?>
                <tr>
                    <td colspan="3">No customers yet.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo Html::escape($customer->name()); ?></td>
                    <td><?php echo Html::escape($customer->email()); ?></td>
                    <td><?php echo Html::escape($customer->createdAt()); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a class="button" href="<?php echo $basePath; ?>index.php">Back to dashboard</a>
</section>
<?php include __DIR__ . '/../../views/footer.php'; ?>
