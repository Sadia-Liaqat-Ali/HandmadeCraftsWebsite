<?php
?>
<!DOCTYPE html>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar {
      background-color: #004080;
    }
    .navbar-brand, .nav-link, .navbar-text {
      color: white !important;
      transition: 0.3s;
    }
    .nav-link:hover {
      color: #ffcc00 !important;
      text-decoration: underline;
    }
    .dropdown-menu {
      background-color: #f8e9f1;
    }
    .dropdown-menu .dropdown-item:hover {
      background-color: #f0cce0;
      color: #d63384;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="dashboard_user.php">🌸 Handmade Crafts</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon bg-light rounded"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="dashboard_user.php">Dashboard</a>
        </li>

        <!-- Products -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Products
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="customer_browse.php">Browse Products</a></li>
            <li><a class="dropdown-item" href="wishlist.php">My Wishlist</a></li>
          </ul>
        </li>

        <!-- Orders -->
        <li class="nav-item">
          <a class="nav-link" href="my_orders.php">My Orders</a>
        </li>
 <!-- Orders -->
        <li class="nav-item">
          <a class="nav-link" href="cart.php">View Cart</a>
        </li>

        <!-- Custom Design -->
        <li class="nav-item">
          <a class="nav-link" href="custom_design.php">Custom Design</a>
        </li>

  <!-- Custom Design -->
        <li class="nav-item">
          <a class="nav-link" href="view_promotions.php">View Promotions</a>
        </li>

    <!-- Custom Design -->
        <li class="nav-item">
          <a class="nav-link" href="edit_userprofile.php">Edit Profile</a>
        </li>

        
      </ul>

      <span class="navbar-text me-3">
        Welcome, <?= $_SESSION['username'] ?? 'User'; ?>
      </span>
      <a href="includes/logout.php" class="btn btn-warning btn-sm">Logout</a>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
