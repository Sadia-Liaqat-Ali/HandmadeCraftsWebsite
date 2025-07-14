<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'artisan') {
  echo "<script>alert('Access denied');window.location='login.php';</script>";
  exit();
}

$artisan_id = $_SESSION['id'];

// Total sales and orders
$totalSales = $conn->query("SELECT SUM(o.total_amount) AS total 
                            FROM orders o 
                            JOIN product p ON o.product_id = p.id 
                            WHERE p.saller_id = $artisan_id")->fetch_assoc()['total'];

$totalOrders = $conn->query("SELECT COUNT(*) AS total 
                             FROM orders o 
                             JOIN product p ON o.product_id = p.id 
                             WHERE p.saller_id = $artisan_id")->fetch_assoc()['total'];

// Top-selling products
$topProducts = $conn->query("SELECT p.name, COUNT(o.id) AS order_count 
                             FROM orders o 
                             JOIN product p ON o.product_id = p.id 
                             WHERE p.saller_id = $artisan_id 
                             GROUP BY o.product_id 
                             ORDER BY order_count DESC LIMIT 5");

// Feedback (reviews)
$feedback = $conn->query("SELECT p.name, r.user_name, r.rating, r.comment 
                          FROM reviews r 
                          JOIN product p ON r.product_id = p.id 
                          WHERE p.saller_id = $artisan_id 
                          ORDER BY r.created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sales Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php include 'includes/navbar_saller.php'; ?>
  <div class="container mt-5 p-4 bg-white rounded shadow">
    <h3 class="text-center text-danger mb-4">📈 My Sales Report</h3>

    <div class="row text-center mb-4">
      <div class="col-md-6"><h5>Total Sales</h5><p class="fw-bold text-success">Rs. <?= $totalSales ?? 0 ?></p></div>
      <div class="col-md-6"><h5>Total Orders</h5><p class="fw-bold text-danger"><?= $totalOrders ?? 0 ?></p></div>
    </div>

    <h5 class="text-danger">🛍️ Top Products</h5>
    <ul class="list-group mb-4">
      <?php while ($row = $topProducts->fetch_assoc()) { ?>
        <li class="list-group-item d-flex justify-content-between">
          <?= $row['name'] ?>
          <span><?= $row['order_count'] ?> orders</span>
        </li>
      <?php } ?>
    </ul>

    <h5 class="text-danger">💬 Latest Feedback</h5>
    <ul class="list-group">
      <?php while ($row = $feedback->fetch_assoc()) { ?>
        <li class="list-group-item">
          <strong><?= $row['user_name'] ?></strong> rated <strong><?= $row['name'] ?></strong> 
          <span class="badge bg-warning text-dark"><?= $row['rating'] ?>/5</span>
          <br><small class="text-muted"><?= $row['comment'] ?></small>
        </li>
      <?php } ?>
    </ul>
  </div>
</body>
</html>
