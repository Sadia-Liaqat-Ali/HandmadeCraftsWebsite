<?php
$conn = new mysqli("localhost", "root", "", "handmadecrafts");
$result = $conn->query("SELECT * FROM custom_requests");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Custom Design Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #fff0f5;">
<div class="container mt-4">
    <h2 class="text-center text-warning">Custom Design Requests</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Customer</th><th>Details</th><th>Action</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['customer_name'] ?></td>
            <td><?= $row['details'] ?></td>
            <td>
                <a href="request_action.php?id=<?= $row['id'] ?>&action=accept" class="btn btn-success btn-sm">Accept</a>
                <a href="request_action.php?id=<?= $row['id'] ?>&action=decline" class="btn btn-danger btn-sm">Decline</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
