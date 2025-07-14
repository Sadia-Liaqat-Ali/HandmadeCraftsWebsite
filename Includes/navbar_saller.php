<?php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'artisan') {
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
    <a class="navbar-brand fw-bold" href="#">Artisan Panel</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Product Management -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown">
            Product Management
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="Upload_product.php">Upload Product</a></li>
            <li><a class="dropdown-item" href="manage_inventory.php">Manage Inventory</a></li>
            <li><a class="dropdown-item" href="saller_requests.php">Custom Requests</a></li>
          </ul>
        </li>

        <!-- Order Management -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-bs-toggle="dropdown">
            Order Management
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="check_orders.php">Manage Orders</a></li>
          </ul>
        </li>

       

        <!-- Reports -->
        <li class="nav-item">
          <a class="nav-link" href="artisan_sales_report.php">Sales Reports</a>
        </li>

        <!-- Profile -->
        <li class="nav-item">
          <a class="nav-link" href="artisan_profile.php">Manage Profile</a>
        </li>

      </ul>

      <span class="navbar-text text-white me-3">
        Welcome, <?= $_SESSION['name']; ?>
      </span>
      <a href="includes/logout.php" class="btn btn-warning btn-sm">Logout</a>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
