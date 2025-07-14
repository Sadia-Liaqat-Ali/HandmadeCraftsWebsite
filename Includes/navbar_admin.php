<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-custom {
      background-color: #004080;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
      color: white;
      transition: 0.3s;
    }
    .navbar-custom .nav-link:hover {
      color: #ffcc00;
      text-decoration: underline;
    }
    .dropdown-menu {
      background-color: #e6f0ff;
    }
    .dropdown-menu .dropdown-item:hover {
      background-color: #cce0ff;
      color: #004080;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav mb-2 mb-lg-0">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="dashboard_admin.php">Dashboard</a>
        </li>

        <!-- User Management -->
        <li class="nav-item">
          <a class="nav-link" href="manage_users.php">Users Management</a>
        </li>

        <!-- Product Management -->
        <li class="nav-item">
          <a class="nav-link" href="manage_products.php">Product Management</a>
        </li>

        <!-- Order Management -->
        <li class="nav-item">
          <a class="nav-link" href="manage_orders.php">Order Management</a>
        </li>

        <!-- Rates & Promotions -->
        <li class="nav-item">
          <a class="nav-link" href="admin_manage_rates.php">Rates & Shipping Charges</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="admin_view_products.php">View Rates & Shipping Charges</a>
        </li>

        <!-- Reports -->
        <li class="nav-item">
          <a class="nav-link" href="admin_reports.php">Reports & Analytics</a>
        </li>

        <!-- Promotions -->
        <li class="nav-item">
          <a class="nav-link" href="manage_promotions.php">Manage Promotions</a>
        </li>
      </ul>

      <!-- Logout aligned right -->
      <div class="d-flex">
        <a href="includes/logout.php" class="btn btn-warning btn-sm">Logout</a>
      </div>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
