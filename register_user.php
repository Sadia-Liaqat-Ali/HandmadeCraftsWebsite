<?php
$conn = new mysqli("localhost", "root", "", "handmadecrafts");

if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = md5($_POST['password']);
  $contact = $_POST['contact'];
  $address = $_POST['address'];

  $sql = "INSERT INTO users (name, email, password, contact, address) VALUES ('$name', '$email', '$pass', '$contact', '$address')";
  $conn->query($sql);
  echo "<script>alert('User Registered!');
    window.location='login.php';;
</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <!-- Include Bootstrap and Custom Style (Same as above) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #ffe6f0; }
    .form-box { max-width: 500px; margin: 80px auto; background: white; border-radius: 15px; padding: 30px; box-shadow: 0 0 20px rgba(255, 105, 180, 0.3); }
    h2 { color: #ff3385; text-align: center; }
    .btn-pink { background-color: #ff66a3; color: white; }
    .btn-pink:hover { background-color: #ff3385; }  .footer-links {
      margin-top: 15px;
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
  <h2>User Registration</h2>
  <form method="post">
    <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
    <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
    <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
    <div class="mb-3"><input type="text" name="contact" class="form-control" placeholder="Contact" required></div>
    <div class="mb-3"><textarea name="address" class="form-control" placeholder="Your Address" required></textarea></div>
    <button type="submit" name="register" class="btn btn-pink w-100">Register</button>
    <div class="footer-links mt-4">
    <a href="index.php"><i class="fas fa-home"></i> Homepage</a>
    |
    <a href="login.php"><i class="fas fa-user-plus"></i> Login</a>
  </div>
</div>
  </form>
</div>
</body>
</html>
