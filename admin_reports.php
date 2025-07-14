<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "<script>alert('Access denied');window.location='login.php';</script>";
  exit();
}

// Fetch reports
$totalSales = $conn->query("SELECT SUM(total_amount) AS total FROM orders")->fetch_assoc()['total'];
$totalOrders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
$popularProducts = $conn->query("SELECT p.name, COUNT(o.product_id) AS total_orders 
                                FROM orders o 
                                JOIN product p ON o.product_id = p.id 
                                GROUP BY o.product_id 
                                ORDER BY total_orders DESC LIMIT 5");

$customerActivity = $conn->query("SELECT u.name, COUNT(o.id) AS orders 
                                 FROM orders o 
                                 JOIN users u ON o.user_id = u.id 
                                 GROUP BY o.user_id 
                                 ORDER BY orders DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Reports</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php include 'includes/navbar_admin.php'; ?>
  <div class="container mt-5 p-4 bg-white rounded shadow">
    <h3 class="text-center text-primary mb-4">📊 Website Analytics Report</h3>

    <div class="row text-center mb-4">
      <div class="col-md-6"><h5>Total Sales</h5><p class="fw-bold text-success">Rs. <?= $totalSales ?? 0 ?></p></div>
      <div class="col-md-6"><h5>Total Orders</h5><p class="fw-bold text-danger"><?= $totalOrders ?? 0 ?></p></div>
    </div>

    <h5 class="text-primary">🔥 Top Selling Products</h5>
    <ul class="list-group mb-4">
      <?php while ($row = $popularProducts->fetch_assoc()) { ?>
        <li class="list-group-item d-flex justify-content-between">
          <?= $row['name'] ?>
          <span><?= $row['total_orders'] ?> orders</span>
        </li>
      <?php } ?>
    </ul>

    <h5 class="text-primary">👥 Most Active Customers</h5>
    <ul class="list-group">
      <?php while ($row = $customerActivity->fetch_assoc()) { ?>
        <li class="list-group-item d-flex justify-content-between">
          <?= $row['name'] ?>
          <span><?= $row['orders'] ?> orders</span>
        </li>
      <?php } ?>
    </ul>
  </div>
</body>
</html>
