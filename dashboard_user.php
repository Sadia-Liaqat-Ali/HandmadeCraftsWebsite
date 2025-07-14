<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['name'] ?? 'User';

// Fetch counts
$total_products = $conn->query("SELECT COUNT(*) as total FROM product WHERE status='approved'")->fetch_assoc()['total'];
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders WHERE user_id=$user_id")->fetch_assoc()['total'];
$total_wishlist = $conn->query("SELECT COUNT(*) as total FROM wishlist WHERE user_id=$user_id")->fetch_assoc()['total'];
$total_custom = $conn->query("SELECT COUNT(*) as total FROM custom_requests WHERE contact LIKE '%$username%'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffe6f0;
      padding-top: 80px;
    }
    h2 {
      color: #d63384;
      font-weight: bold;
      margin-bottom: 30px;
    }
    .card {
      background-color: #d63384;
      color: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(214, 51, 132, 0.3);
      transition: 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card-body i {
      font-size: 2.2rem;
    }
    .card h5 {
      font-weight: 600;
    }
    .card p {
      margin: 0;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container mt-4">
  <h2 class="text-center">Welcome, <?= htmlspecialchars($username) ?> 🌸</h2>
  <div class="row g-4">

    <!-- Total Products -->
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="card-body">
          <i>🛍️</i>
          <h5 class="mt-2">Total Products</h5>
          <p><?= $total_products ?></p>
        </div>
      </div>
    </div>

    <!-- My Orders -->
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="card-body">
          <i>📦</i>
          <h5 class="mt-2">My Orders</h5>
          <p><?= $total_orders ?></p>
        </div>
      </div>
    </div>

    <!-- Wishlist -->
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="card-body">
          <i>❤️</i>
          <h5 class="mt-2">Wishlist</h5>
          <p><?= $total_wishlist ?></p>
        </div>
      </div>
    </div>

    <!-- Custom Requests -->
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="card-body">
          <i>✏️</i>
          <h5 class="mt-2">Custom Requests</h5>
          <p><?= $total_custom ?></p>
        </div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
