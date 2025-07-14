<?php
$conn = new mysqli("localhost", "root", "", "handmadecrafts");
$result = $conn->query("SELECT * FROM orders");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #fff0f5;">
<div class="container mt-4">
    <h2 class="text-center text-success">Incoming Orders</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Product</th><th>Customer</th><th>Status</th><th>Update</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['product_name'] ?></td>
            <td><?= $row['customer_name'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <form method="POST" action="update_status.php">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <select name="status" class="form-select">
                        <option value="Processing">Processing</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                    <button class="btn btn-sm btn-primary mt-1">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
