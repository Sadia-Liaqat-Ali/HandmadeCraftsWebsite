<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - Handmade Creations</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fffdf7;
    }

    .hero {
      background: url('uploads/bg.jpg') center/cover no-repeat;
      color: #004080;
      padding: 120px 20px;
      text-align: center;
      background-attachment: fixed;
      animation: fadeSlideIn 2s ease-in-out;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: bold;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero p {
      font-size: 1.2rem;
      margin: 15px auto;
      max-width: 650px;
    }

    .hero .btn {
      margin-top: 20px;
      background: #ff66a3;
      color: white;
      border-radius: 25px;
    }

    @keyframes fadeSlideIn {
      0% {
        opacity: 0;
        transform: translateY(-40px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .about-section {
      padding: 60px 20px;
    }

    .about-box {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .about-box h3 {
      color: #d6336c;
    }

    .about-icon {
      font-size: 2.5rem;
      color: #004080;
      margin-bottom: 15px;
    }

    .mission {
      background: #fff0f6;
      padding: 50px 20px;
    }

    .footer {
      background: #004080;
      color: white;
      padding: 30px 15px;
    }
  </style>
</head>
<body>


<!-- Reused Homepage Hero Section -->
<section class="hero">
  <h1>About Handmade Creations</h1>
  <p>Each item is a story crafted with passion and care by local artisans.</p>
  <a href="login.php" class="btn btn-lg px-4"><i class="fas fa-shopping-bag me-2"></i>Explore Products</a>
</section>

<!-- About Content -->
<div class="container about-section">
  <div class="row">
    <div class="col-md-6">
      <div class="about-box">
        <div class="about-icon"><i class="fas fa-hands-helping"></i></div>
        <h3>Our Story</h3>
        <p>Handmade Creations was born out of love for art and a desire to support local talent. We connect skilled artisans with appreciative buyers to celebrate the beauty of handmade work.</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="about-box">
        <div class="about-icon"><i class="fas fa-bullseye"></i></div>
        <h3>Our Mission</h3>
        <p>We aim to empower artisans globally by providing them with a platform to showcase and sell their creations while promoting ethical, eco-conscious craftsmanship.</p>
      </div>
    </div>
  </div>
</div>

<!-- Mission Area -->
<div class="mission text-center">
  <h3 class="text-danger mb-4">Why We Stand Out</h3>
  <p class="lead mb-4">Every product at Handmade Creations is a piece of art—authentic, personal, and meaningful.</p>
  <div class="row justify-content-center">
    <div class="col-md-3">
      <i class="fas fa-star fa-2x text-warning"></i>
      <h5 class="mt-2">Premium Quality</h5>
    </div>
    <div class="col-md-3">
      <i class="fas fa-seedling fa-2x text-success"></i>
      <h5 class="mt-2">Sustainably Sourced</h5>
    </div>
    <div class="col-md-3">
      <i class="fas fa-users fa-2x text-info"></i>
      <h5 class="mt-2">Community Driven</h5>
    </div>
  </div>
</div>

<!-- Footer -->

</body>
</html>
