<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}
$user_id = $_SESSION['user_id'];


?>
<!DOCTYPE html>
<html>
<head>
  <title>My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; padding-top: 80px; }
    .container {
      background: white; padding: 30px; border-radius: 15px;
      box-shadow: 0 0 25px rgba(106, 13, 173, 0.15);
    }
    h3 { color: #6a0dad; font-weight: bold; text-align: center; margin-bottom: 30px; }
    .badge-status {
      font-size: 13px; padding: 6px 10px; border-radius: 20px;
    }
    .img-thumb {
      height: 50px; width: 50px; object-fit: cover; border-radius: 5px;
    }
    .receipt-link {
      text-decoration: none;
      font-size: 14px;
      color: #6a0dad;
    }
    .receipt-link:hover {
      text-decoration: underline;
      color: #4b0082;
    }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container">
  <h3>My Orders</h3>

  <table class="table table-bordered table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Tax</th>
        <th>Shipping</th>
        <th>Total</th>
        <th>Status</th>
        <th>Receipt</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $orders = $conn->query("SELECT o.*, p.name, p.image 
                              FROM orders o 
                              JOIN product p ON o.product_id = p.id 
                              WHERE o.user_id = $user_id 
                              ORDER BY o.id DESC");

      if ($orders->num_rows > 0) {
        $count = 1;
        while ($row = $orders->fetch_assoc()) {
          $status = $row['status'] ?? 'Pending';
          $badge = ($status == 'Delivered') ? 'success' : (($status == 'Shipped') ? 'info' : (($status == 'Approved') ? 'primary' : 'secondary'));

          echo "<tr>
            <td>{$count}</td>
            <td>
              <img src='uploads/{$row['image']}' class='img-thumb me-2'>
              {$row['name']}
            </td>
            <td>{$row['quantity']}</td>
            <td>Rs. {$row['total_amount']}</td>
            <td>Rs. {$row['tax_amount']}</td>
            <td>Rs. {$row['shipping_fee']}</td>
            <td class='fw-bold'>Rs. {$row['total_amount']}</td>
            <td><span class='badge bg-$badge badge-status'>$status</span></td>
            <td>";
              if (!empty($row['payment_receipt']) && file_exists($row['payment_receipt'])) {
                echo "<a href='{$row['payment_receipt']}' target='_blank' class='receipt-link'>View</a>";
              } else {
                echo "<span class='text-muted'>N/A</span>";
              }
          echo "</td>
            <td>" . date('d M Y', strtotime($row['created_at'] ?? $row['order_date'] ?? 'now')) . "</td>
          </tr>";
          $count++;
        }
      } else {
        echo "<tr><td colspan='10' class='text-center text-muted'>No orders found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
