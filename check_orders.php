<?php
session_start();
include("connection.php");

// Check if artisan is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'artisan') {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}

$artisan_id = $_SESSION['id'];

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
  $order_id = $_POST['order_id'];
  $new_status = $_POST['status'];
  $update = "UPDATE orders SET status = '$new_status' WHERE id = '$order_id'";
  mysqli_query($conn, $update);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Orders (Seller)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f3e6ff;
     
    }
    .container {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 25px rgba(106, 13, 173, 0.15);
    }
    h3 {
      color: #6a0dad;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }
    th {
      background-color: #d9b3ff;
      color: #4b0082;
    }
    td, th {
      vertical-align: middle;
      text-align: center;
    }
    .form-select {
      min-width: 120px;
    }
  </style>
</head>
<body>

<?php include("includes/navbar_saller.php"); ?>

<div class="container">
  <h3>Orders For Your Products</h3>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Product</th>
          <th>Customer</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Qty</th>
          <th>Total</th>
          <th>Status</th>
          <th>Receipt</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT o.*, p.name AS product_name, p.image 
                  FROM orders o
                  JOIN product p ON o.product_id = p.id
                  WHERE p.saller_id = $artisan_id
                  ORDER BY o.id DESC";
        $result = mysqli_query($conn, $query);
        $count = 1;
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $count++ . "</td>";
            echo "<td><img src='uploads/{$row['image']}' width='50' height='50' class='me-2 rounded'> {$row['product_name']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['phone']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>Rs. {$row['total_amount']}</td>";
            echo "<td>
              <form method='POST' class='d-flex align-items-center justify-content-center'>
                <input type='hidden' name='order_id' value='{$row['id']}'>
                <select name='status' class='form-select form-select-sm'>
                  <option " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                  <option " . ($row['status'] == 'Processing' ? 'selected' : '') . ">Processing</option>
                  <option " . ($row['status'] == 'Shipped' ? 'selected' : '') . ">Shipped</option>
                  <option " . ($row['status'] == 'Delivered' ? 'selected' : '') . ">Delivered</option>
                </select>
            </td>";
            echo "<td>";
            if (!empty($row['payment_receipt']) && file_exists($row['payment_receipt'])) {
              echo "<a href='{$row['payment_receipt']}' target='_blank' class='btn btn-sm btn-outline-primary'>View</a>";
            } else {
              echo "<span class='text-muted'>N/A</span>";
            }
            echo "</td>";
            echo "<td><button type='submit' name='update_status' class='btn btn-sm btn-success'>Update</button></form></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='10' class='text-center text-muted'>No orders found for your products.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
