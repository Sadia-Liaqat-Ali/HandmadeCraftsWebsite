<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
  $name = $_POST['product_name'];
  $category = $_POST['category'];
  $details = $_POST['details'];
  $contact = $_POST['contact'];

  // Insert with error check
  $sql = "INSERT INTO custom_requests (user_id, product_name, category, details, contact) 
          VALUES ('$user_id', '$name', '$category', '$details', '$contact')";

  if ($conn->query($sql)) {
    echo "<script>alert('Request submitted successfully!');</script>";
  } else {
    echo "<script>alert('Insert Failed: " . $conn->error . "');</script>";
  }
}

// Only show this user's requests
$requests = $conn->query("SELECT * FROM custom_requests WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Custom Design Request</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #ffe6f0; }
    h3, h5 { color: #ff3385; text-align: center; }
    .btn-submit {
      background-color: #ff3385;
      color: white;
    }
    .btn-submit:hover {
      background-color: #e62e73;
    }
    .card-custom {
      background: #fff;
      border-left: 5px solid #ff3385;
      box-shadow: 0 0 10px rgba(255, 105, 180, 0.15);
      margin-bottom: 15px;
    }
    .card-custom .card-body {
      padding: 15px;
    }
    .main-section {
      max-width: 1200px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(255, 105, 180, 0.2);
    }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="main-section">
  <h3 class="mb-4">Custom-Made Product</h3>

  <div class="row">
    <!-- Form on LHS -->
    <div class="col-md-5">
      <h5 class="mb-3 text-center">Request New Custom Product</h5>
      <form method="POST" class="mb-4">
        <input type="text" name="product_name" class="form-control mb-2" placeholder="Product Name" required>
        <select name="category" class="form-control mb-2" required>
          <option value="">Select Category</option>
          <option value="Jewelry">Jewelry</option>
          <option value="Clothing">Clothing</option>
          <option value="Home Decor">Home Decor</option>
        </select>
        <textarea name="details" class="form-control mb-2" placeholder="Describe your custom design..." rows="4" required></textarea>
        <input type="text" name="contact" class="form-control mb-2" placeholder="Your Contact Info (email or number)" required>
        <button type="submit" name="submit" class="btn btn-success w-100">Send Request</button>
      </form>
    </div>

    <!-- List on RHS -->
    <div class="col-md-7">
      <h5 class="mb-3 text-center">Your Requests</h5>
      <?php
      if ($requests->num_rows > 0) {
        while ($r = $requests->fetch_assoc()) { ?>
          <div class="card card-custom">
            <div class="card-body">
              <h6 class="fw-bold text-danger"><?php echo $r['product_name']; ?> (<?php echo $r['category']; ?>)</h6>
              <p><strong>Details:</strong> <?php echo $r['details']; ?></p>
              <p><strong>Contact:</strong> <?php echo $r['contact']; ?></p>
              <p class="text-muted"><small>Requested on <?php echo $r['created_at']; ?></small></p>
              <a href="chatbox.php?request_id=<?php echo $r['id']; ?>&role=customer" class="btn btn-primary w-100">Chat</a>
            </div>
          </div>
      <?php }
      } else {
        echo "<p class='text-center text-muted'>No requests yet.</p>";
      }
      ?>
    </div>
  </div>
</div>

</body>
</html>
