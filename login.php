<?php
session_start();
$conn = new mysqli("localhost", "root", "", "handmadecrafts");

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass = md5($_POST['password']);

  // Admin
  $admin = $conn->query("SELECT * FROM admin WHERE email='$email' AND password='$pass'");
  if ($admin->num_rows > 0) {
    $_SESSION['role'] = "admin";
    $_SESSION['name'] = "Admin";
    header("Location: dashboard.php");
    exit();
  }

  // Artisan - must be active
  $artisan = $conn->query("SELECT * FROM artisan WHERE email='$email' AND password='$pass' AND status='active'");
  if ($artisan->num_rows > 0) {
    $row = $artisan->fetch_assoc();
    $_SESSION['role'] = "artisan";
    $_SESSION['name'] = $row['name'];
    $_SESSION['id'] = $row['id'];
    header("Location: dashboard.php");
    exit();
  }

  // User - must be active
  $user = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass' AND status='active'");
  if ($user->num_rows > 0) {
    $userData = $user->fetch_assoc();
    $_SESSION['role'] = "user";
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['name'] = $userData['name'];
    header("Location: dashboard.php");
    exit();
  }

  echo "<script>alert('Invalid credentials or inactive account');</script>";
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #ffe6f0; }
    .form-box {
      max-width: 500px;
      margin: 80px auto;
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 0 20px rgba(255, 105, 180, 0.3);
    }
    h2 { color: #ff3385; text-align: center; }
    .btn-pink { background-color: #ff66a3; color: white; }
    .btn-pink:hover { background-color: #ff3385; }

    .social-row {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 15px;
    }

    .btn-google {
      flex: 1;
      background-color: #ff99bb;
      color: white;
      border: none;
    }
    .btn-google:hover {
      background-color: #ff80aa;
    }

    .btn-facebook {
      flex: 1;
      background-color: #ff4d94;
      color: white;
      border: none;
    }
    .btn-facebook:hover {
      background-color: #e60073;
    }

    .footer-links {
      margin-top: 20px;
      text-align: center;
    }
    .footer-links a {
      margin: 0 10px;
      color: #d6336c;
      font-weight: 500;
      text-decoration: none;
    }
    .footer-links a:hover {
      text-decoration: underline;
      color: #ff3385;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>Login</h2>
  <form method="post">
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <button type="submit" name="login" class="btn btn-pink w-100">Login</button>
  </form>
<H3 class="text-center text-primary">Other Options</H3>
  <!-- Horizontal Social Buttons -->
  <div class="social-row">
    <a href="https://accounts.google.com/" class="btn btn-google">
      <i class="fab fa-google"></i> Google
    </a>
    <a href="https://www.facebook.com/login" class="btn btn-facebook">
      <i class="fab fa-facebook-f"></i> Facebook
    </a>
  </div>

  <div class="footer-links mt-4">
    <a href="index.php"><i class="fas fa-home"></i> Homepage</a> |
    <a href="Register_user.php"><i class="fas fa-user-plus"></i> Register</a>
  </div>
</div>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
