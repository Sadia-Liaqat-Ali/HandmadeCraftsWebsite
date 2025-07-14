<?php
session_start();
include("connection.php");

// Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}

// Delete order
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM orders WHERE id = $id");
  echo "<script>alert('Order deleted.'); window.location='admin_manage_orders.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Manage Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; }
    .container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(106,13,173,0.15);
    }
    h3 {
      color: #6a0dad;
      text-align: center;
      font-weight: bold;
      margin-bottom: 30px;
    }
    table {
      font-size: 14px;
    }
    .table th {
      background-color: #d9b3ff;
      color: #4b0082;
    }
    .btn-delete {
      background-color: #ff4d4d;
      color: white;
    }
    .btn-delete:hover {
      background-color: #cc0000;
    }
    .img-thumb {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<?php include("includes/navbar_admin.php"); ?>

<div class="container">
  <h3>📦 All Orders - Admin View</h3>

  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead>
        <tr>
          <th>#</th>
          <th>Product</th>
          <th>User</th>
          <th>Qty</th>
          <th>Tax</th>
          <th>Shipping</th>
          <th>Total</th>
          <th>Status</th>
          <th>Receipt</th>
          <th>Order Date</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $q = "SELECT o.*, u.name AS user_name, u.email, p.name AS product_name, p.image 
              FROM orders o 
              JOIN users u ON o.user_id = u.id
              JOIN product p ON o.product_id = p.id
              ORDER BY o.id DESC";
        $res = $conn->query($q);
        $sn = 1;
        if ($res && $res->num_rows > 0) {
          while ($row = $res->fetch_assoc()) {
            echo "<tr>
              <td>{$sn}</td>
              <td><img src='uploads/{$row['image']}' class='img-thumb me-1'> {$row['product_name']}</td>
              <td>{$row['user_name']}<br><small>{$row['email']}</small></td>
              <td>{$row['quantity']}</td>
              <td>Rs. {$row['tax_amount']}</td>
              <td>Rs. {$row['shipping_fee']}</td>
              <td><strong>Rs. {$row['total_amount']}</strong></td>
              <td><span class='badge bg-secondary'>{$row['status']}</span></td>
              <td>";
              if (!empty($row['payment_receipt']) && file_exists($row['payment_receipt'])) {
                echo "<a href='{$row['payment_receipt']}' target='_blank'>View</a>";
              } else {
                echo "<span class='text-muted'>N/A</span>";
              }
            echo "</td>
              <td>" . date('d M Y', strtotime($row['order_date'])) . "</td>
              <td>
                <a href='?delete={$row['id']}' onclick=\"return confirm('Delete this order?')\" class='btn btn-danger btn-delete'>Delete</a>
              </td>
            </tr>";
            $sn++;
          }
        } else {
          echo "<tr><td colspan='11' class='text-muted'>No orders found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
