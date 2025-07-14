<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
  header("Location: login.php");
  exit();
}

// Fetch dynamic counts
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_artisans = $conn->query("SELECT COUNT(*) AS count FROM artisan")->fetch_assoc()['count'];
$total_products = $conn->query("SELECT COUNT(*) AS count FROM product")->fetch_assoc()['count'];
$total_orders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
$total_promos = $conn->query("SELECT COUNT(*) AS count FROM promotions")->fetch_assoc()['count'];
$total_custom = $conn->query("SELECT COUNT(*) AS count FROM custom_requests")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f0f8ff; font-family: 'Segoe UI', sans-serif;  }
    h2 { color: #004080; font-weight: bold; margin-bottom: 30px; text-align: center; }
    .card-custom {
      border-left: 6px solid #004080;
      border-radius: 10px;
      background: #e6f0ff;
      box-shadow: 0 4px 12px rgba(0, 64, 128, 0.2);
      transition: 0.3s;
    }
    .card-custom:hover { background: #d9ecff; transform: translateY(-5px); }
    .card-custom h5 { font-weight: 600; color: #004080; }
    .card-custom .count { font-size: 28px; color: #004080; font-weight: bold; }
    .icon { font-size: 24px; color: #004080; }
  </style>
</head>
<body>

<?php include('includes/navbar_admin.php'); ?>
<br><br>
<div class="container">
  <h2>Welcome Admin 👑</h2>
  <div class="row g-4">

    <div class="col-md-4">
      <div class="card card-custom p-4">
        <div class="icon mb-2">👥</div>
        <h5>Total Users</h5>
        <div class="count"><?= $total_users ?></div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4">
        <div class="icon mb-2">🎨</div>
        <h5>Total Artisans</h5>
        <div class="count"><?= $total_artisans ?></div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4">
        <div class="icon mb-2">🛍️</div>
        <h5>Total Products</h5>
        <div class="count"><?= $total_products ?></div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4">
        <div class="icon mb-2">📦</div>
        <h5>Total Orders</h5>
        <div class="count"><?= $total_orders ?></div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4">
        <div class="icon mb-2">📢</div>
        <h5>Total Promotions</h5>
        <div class="count"><?= $total_promos ?></div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4">
        <div class="icon mb-2">🧵</div>
        <h5>Custom Requests</h5>
        <div class="count"><?= $total_custom ?></div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
