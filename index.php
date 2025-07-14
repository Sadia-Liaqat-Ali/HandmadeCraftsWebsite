<?php
include 'connection.php';
$products = $conn->query("SELECT * FROM product WHERE status='approved'");
$categories = $conn->query("SELECT DISTINCT category FROM product WHERE status='approved'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Handmade Creations</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff7f0;
    }
    nav {
    background-color: #004080;
    }
    nav a.nav-link {
      color: #d6336c;
      font-weight: 500;
      margin-right: 15px;
    }
    nav a.nav-link:hover {
      color: #ff5c8d;
      text-decoration: underline;
    }
    .navbar-nav .nav-link {
    color: #fff !important;
    font-weight: 500;
    transition: 0.3s ease-in-out;
  }
  .navbar-nav .nav-link:hover {
    color: #ffc107 !important;
    text-decoration: underline;
  }
  .hero {
  background: url('uploads/bg.jpg') center/cover no-repeat;
  color: #004080;
  height: 100vh;
  padding: 120px 20px;
  text-align: center;
  background-attachment: fixed;
  position: relative;
  overflow: hidden;
  animation: fadeSlideIn 2s ease-in-out;
}

@keyframes fadeSlideIn {
  0% {
    opacity: 0;
    transform: translateY(-30px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero h1, .hero p, .hero .btn {
  transition: all 0.4s ease-in-out;
}

.hero:hover h1 {
  transform: scale(1.05);
  color: #d6336c;
}

    .category-bar {
      background: #fff0f6;
      padding: 15px;
      text-align: center;
      font-weight: bold;
      font-size: 1.1rem;
      color: #d6336c;
    }
    .category-bar .badge {
      margin: 0 5px;
    }
    .product-card {
      background: white;
      border: 1px solid #f5c2c7;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(255, 105, 180, 0.15);
      transition: transform 0.3s;
    }
    .product-card:hover {
      transform: scale(1.03);
    }
    .product-category {
      position: absolute;
      top: 8px;
      left: 8px;
      background: rgba(255, 255, 255, 0.9);
      color: #d6336c;
      padding: 3px 8px;
      font-size: 13px;
      border-radius: 15px;
    }
    .product-card img {
      height: 200px;
      object-fit: cover;
    }
    .features {
      background: #fff0f6;
      padding: 60px 20px;
    }
    .feature-box {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(255,105,180,0.15);
      text-align: center;
    }
    .feature-box i {
      font-size: 2rem;
      color: #d6336c;
      margin-bottom: 10px;
    }
    .footer {
      background: #004080;
      color: white;
      padding: 30px 15px;
    }
    .footer a {
      color: #ffb6c1;
      text-decoration: none;
    }
    .footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#"><i class="fas fa-gem me-2"></i>Handmade Creations</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
        <li class="nav-item">
          <a class="nav-link" href="Register_artisan.php"><i class="fas fa-paint-brush me-1"></i>Register Artisan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Register_user.php"><i class="fas fa-user-plus me-1"></i>Register User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
          
        <li class="nav-item">
          <a class="nav-link" href="about.php"><i class="fas fa-user-shield me-1"></i>Abou Us</a>
        </li>
        </li>
      </ul>
    </div>
  </div>
</nav>


<!-- Hero Section -->

  <!-- Reused Homepage Hero Section -->
<section class="hero">
  <h1>Handmade Creations</h1>
<p>
  Each item is a story crafted with passion and care by local artisans.<br>
  Our handmade creations reflect culture, creativity, and craftsmanship.<br>
  Support small businesses and own something truly one-of-a-kind.
</p>
  <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
    <a href="Register_user.php" class="btn btn-lg btn-outline-primary">
      <i class="fas fa-shopping-bag me-2"></i>Start Exploring
    </a>
    <a href="adminlogin.php" class="btn btn-lg btn-outline-success px-4">
      <i class="fas fa-user-shield me-2"></i>Admin Login
    </a>
  </div>
</section>


<!-- Categories -->
<div class="category-bar">
  Shop by Category:
  <?php while ($cat = $categories->fetch_assoc()) {
    echo "<span class='badge bg-light text-dark'>{$cat['category']}</span>";
  } ?>
</div>

<!-- Product Grid -->
<section class="container my-5">
  <div class="row">
    <div class="col-12 text-center mb-4">
      <h2 class="text-danger">Our Featured Products</h2>
    </div>
    <?php while ($row = $products->fetch_assoc()) { ?>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card product-card h-100">
          <div class="position-relative">
            <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
            <span class="product-category"><?php echo $row['category']; ?></span>
          </div>
          <div class="card-body">
            <h5 class="card-title text-danger"><?php echo $row['name']; ?></h5>
            <p class="card-text"><?php echo substr($row['description'], 0, 60) . "..."; ?></p>
            <p class="fw-bold">Rs. <?php echo $row['price']; ?></p>
          </div>
          <div class="card-footer bg-white border-0">
            <a href="login.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary w-100">View Details</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<!-- Why Choose Us -->
<section class="features">
  <div class="container">
    <div class="row text-center mb-4">
      <h3 class="text-danger">Why Choose Handmade Creations?</h3>
    </div>
    <div class="row text-center">
      <div class="col-md-4">
        <div class="feature-box">
          <i class="fas fa-heart"></i>
          <h5>Handcrafted with Love</h5>
          <p>Our artisans put care and attention into every product, ensuring quality and uniqueness.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box">
          <i class="fas fa-globe"></i>
          <h5>Eco-Friendly Approach</h5>
          <p>We prioritize sustainability by using recyclable materials and promoting ethical production.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box">
          <i class="fas fa-box-open"></i>
          <h5>Fast & Safe Delivery</h5>
          <p>Receive your favorite handmade goods quickly with our secure delivery system.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-5 mt-5">
  <div class="container">
    <div class="row">
      <!-- About -->
      <div class="col-md-4">
        <h5>Handmade Creations</h5>
        <p>Discover unique handmade treasures crafted by skilled artisans across the globe.</p>
      </div>

      <!-- Categories -->
      <div class="col-md-4">
        <h5>Categories</h5>
        <ul class="list-unstyled">
          <?php
          $catResult = $conn->query("SELECT DISTINCT category FROM product WHERE status='approved'");
          while ($cat = $catResult->fetch_assoc()) {
              echo "<li><a class='text-white' href='products.php?category=" . urlencode($cat['category']) . "'>{$cat['category']}</a></li>";
          }
          ?>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-md-4">
        <h5>Contact Us</h5>
        <address>
          <p><i class="fas fa-map-marker-alt me-2"></i>123 Artisan Street, Craftsville</p>
          <p><i class="fas fa-phone me-2"></i>+92 300 1234567</p>
          <p><i class="fas fa-envelope me-2"></i>support@handmadecreations.com</p>
        </address>
      </div>
    </div>
    <hr class="bg-secondary">
    <div class="text-center">
      <p>&copy; <?= date('Y'); ?> Handmade Creations. All rights reserved.</p>
    </div>
  </div>
</footer>


</body>
</html>
