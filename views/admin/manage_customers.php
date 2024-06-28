<?php include '../header.php'; ?>
<h1>Manage Customers</h1>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?php echo htmlspecialchars($customer['name']); ?></td>
            <td><?php echo htmlspecialchars($customer['email']); ?></td>
            <td><?php echo htmlspecialchars($customer['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../footer.php'; ?>
