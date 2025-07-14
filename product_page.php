<?php
session_start();
include 'connection.php';

if (!isset($_GET['id'])) {
  header("Location: browse_products.php");
  exit();
}

$id = $_GET['id'];

// Fetch product with artisan name
$product = $conn->query("
  SELECT product.*, artisan.name AS artisan_name 
  FROM product 
  LEFT JOIN artisan ON product.saller_id = artisan.id 
  WHERE product.id = $id
")->fetch_assoc();

$reviews = $conn->query("SELECT * FROM reviews WHERE product_id = $id ORDER BY created_at DESC");

// Get tax and shipping based on category
$category = $product['category'];
$tax_result = $conn->query("SELECT tax_percent FROM taxes WHERE category='$category'");
$ship_result = $conn->query("SELECT shipping_fee FROM shipping_rates WHERE category='$category'");
$tax = $tax_result->num_rows > 0 ? $tax_result->fetch_assoc()['tax_percent'] : 0;
$shipping = $ship_result->num_rows > 0 ? $ship_result->fetch_assoc()['shipping_fee'] : 0;

// Handle new review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
  $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
  $rating = intval($_POST['rating']);
  $comment = mysqli_real_escape_string($conn, $_POST['comment']);

  $conn->query("INSERT INTO reviews (product_id, user_name, rating, comment, created_at)
                VALUES ($id, '$user_name', $rating, '$comment', NOW())");

  echo "<script>window.location.href='product_page.php?id=$id';</script>";
  exit();
}
?>


<!DOCTYPE html>
<html>
<head>
  <title><?php echo $product['name']; ?> - Product Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; padding-top: 80px; }
    .container {
      background: white;
      padding: 30px;
      margin-top: 30px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(106, 13, 173, 0.15);
    }
    .btn-back {
      background-color: #6a0dad;
      color: white;
      border: none;
    }
    .btn-back:hover {
      background-color: #4b0082;
    }
    .rating-star { color: gold; font-size: 18px; }
    .review-box {
      border: 1px solid #e6ccff;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
      background: #f9f0ff;
    }
    textarea { resize: none; }
    h3 { color: #6a0dad; font-weight: bold; }
    h5 { color: #6a0dad; }
    .summary-label { font-weight: bold; color: #6a0dad; }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container">
  <a href="customer_browse.php" class="btn btn-primary mb-3">← Back to Products</a>
  <div class="row mb-4">
    <div class="col-md-5">
      <img src="uploads/<?php echo $product['image']; ?>" class="img-fluid rounded" alt="">
    </div>
    <div class="col-md-7">
      <h3><?php echo $product['name']; ?></h3>
      <p><span class="summary-label">Price:</span> Rs. <?php echo $product['price']; ?></p>
      <p><span class="summary-label">Stock:</span> <?php echo $product['stock']; ?></p>
      <p><span class="summary-label">Category:</span> <?php echo $product['category']; ?></p>
      <p><span class="summary-label">Artisan:</span> <?php echo $product['artisan_name']; ?></p>

      <p><span class="summary-label">Tax:</span> <?php echo $tax; ?>%</p>
      <p><span class="summary-label">Shipping:</span> Rs. <?php echo $shipping; ?></p>
      <p><span class="summary-label">Description:</span><br><?php echo $product['description']; ?></p>
    </div>
  </div>

  <div class="row">
    <!-- LHS: Previous Reviews -->
    <div class="col-md-5">
      <h5 class="text-primary">Previous Reviews</h5>
      <?php
      if ($reviews->num_rows > 0) {
        while ($r = $reviews->fetch_assoc()) {
          echo "<div class='review-box'>";
          echo "<strong>" . htmlspecialchars($r['user_name']) . "</strong><br>";
          echo "<span class='rating-star'>";
          for ($i = 0; $i < $r['rating']; $i++) echo "★";
          for ($i = $r['rating']; $i < 5; $i++) echo "☆";
          echo "</span><br>";
          echo "<p>" . htmlspecialchars($r['comment']) . "</p>";
          echo "<small class='text-muted'>Posted on " . $r['created_at'] . "</small>";
          echo "</div>";
        }
      } else {
        echo "<p class='text-muted'>No reviews yet.</p>";
      }
      ?>
    </div>

    <!-- RHS: Review Submission Form -->
    <div class="col-md-7">
      <h5 class="text-danger">Give Your Review</h5>
      <form method="POST">
        <div class="mb-3">
          <label>Your Name</label>
          <input type="text" name="user_name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Rating (1 to 5)</label>
          <select name="rating" class="form-select" required>
            <option value="">Select</option>
            <?php for ($i = 5; $i >= 1; $i--) echo "<option value='$i'>$i Star</option>"; ?>
          </select>
        </div>
        <div class="mb-3">
          <label>Comment</label>
          <textarea name="comment" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" name="submit_review" class="btn btn-success w-100">Submit Review</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
