<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != "artisan") {
  header("Location: login.php");
  exit();
}

$artisan_id = $_SESSION['id'];

// Total Products
$product_count = $conn->query("SELECT COUNT(*) AS total FROM product WHERE saller_id = $artisan_id")->fetch_assoc()['total'];

// Total Orders (only those products that belong to this artisan)
$order_count = $conn->query("
  SELECT COUNT(*) AS total 
  FROM orders o 
  JOIN product p ON o.product_id = p.id 
  WHERE p.saller_id = $artisan_id
")->fetch_assoc()['total'];

// Total Custom Requests (no seller relation, so showing all)
$request_count = $conn->query("SELECT COUNT(*) AS total FROM custom_requests")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Artisan Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f8ff;
      font-family: 'Segoe UI', sans-serif;
   
    }
    h2 {
      color: #004080;
      font-weight: bold;
      margin-bottom: 30px;
      text-align: center;
    }
    .card-custom {
      border: none;
      border-left: 6px solid #004080;
      border-radius: 10px;
      transition: 0.3s;
      background: #e6f0ff;
      box-shadow: 0 4px 12px rgba(0, 64, 128, 0.2);
    }
    .card-custom:hover {
      transform: translateY(-5px);
      background: #d9ecff;
    }
    .card-custom h5 {
      font-weight: 600;
      color: #004080;
    }
    .card-custom p {
      margin: 0;
      color: #333;
      font-size: 24px;
      font-weight: bold;
    }
    .icon {
      font-size: 30px;
      color: #004080;
    }
  </style>
</head>
<body>

<?php include('includes/navbar_saller.php'); ?>
<br>
<div class="container">
  <h2>Welcome Artisan 🎨</h2>
  <div class="row g-4">

    <!-- Total Products -->
    <div class="col-md-4">
      <div class="card card-custom p-4 h-100 text-center">
        <div class="icon mb-2">📦</div>
        <h5>Total Products</h5>
        <p><?= $product_count ?></p>
      </div>
    </div>

    <!-- Total Orders -->
    <div class="col-md-4">
      <div class="card card-custom p-4 h-100 text-center">
        <div class="icon mb-2">🧾</div>
        <h5>My Orders</h5>
        <p><?= $order_count ?></p>
      </div>
    </div>

    <!-- Custom Requests -->
    <div class="col-md-4">
      <div class="card card-custom p-4 h-100 text-center">
        <div class="icon mb-2">🎨</div>
        <h5>Custom Requests</h5>
        <p><?= $request_count ?></p>
      </div>
    </div>

  </div>
</div>

</body>
</html>
