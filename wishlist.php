<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  echo "<script>alert('Access denied'); window.location='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id'];

// Add to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $product_id = $_POST['product_id'];
    $check = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id='$user_id' AND product_id='$product_id'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id) VALUES ('$user_id', '$product_id')");
    }
    header("Location: wishlist.php");
    exit;
}

// Remove from wishlist
if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    mysqli_query($conn, "DELETE FROM wishlist WHERE user_id='$user_id' AND product_id='$product_id'");
    header("Location: wishlist.php");
    exit;
}

// Get wishlist items
$query = "SELECT p.* FROM wishlist w 
          JOIN product p ON w.product_id = p.id 
          WHERE w.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Wishlist</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; padding-top: 80px; }
    .container {
      background: white;
      padding: 30px;
      margin-top: 20px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(106, 13, 173, 0.15);
    }
    h3 {
      color: #6a0dad;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
    }
    th {
      background-color: #6a0dad;
      color: white;
    }
    td, th {
      padding: 12px;
      text-align: center;
      vertical-align: middle;
    }
    tr:nth-child(even) {
      background-color: #f9eaff;
    }
    img.thumb {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 8px;
    }
    .btn-remove {
      background-color: #ff4d6d;
      color: white;
      border: none;
    }
    .btn-remove:hover {
      background-color: #cc0033;
    }
    .btn-warning {
      font-weight: bold;
    }
    .btn-warning:hover {
      background-color: #e69500;
    }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container">
  <h3>💖 My Wishlist</h3>

  <?php if ($result && mysqli_num_rows($result) > 0) { ?>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Product Name</th>
          <th>Price (Rs.)</th>
          <th>Stock</th>
          <th>Category</th>
          <th>Add to Cart</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sn = 1;
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <tr>
          <td><?php echo $sn++; ?></td>
          <td><img src="uploads/<?php echo $row['image']; ?>" class="thumb"></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['price']; ?></td>
          <td><?php echo $row['stock']; ?></td>
          <td><?php echo $row['category']; ?></td>
          <td>
            <form method="POST" action="cart.php" class="d-flex justify-content-center">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
              <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
              <input type="number" name="quantity" value="1" min="1" max="<?php echo $row['stock']; ?>" class="form-control me-1" style="width: 70px;" required>
              <button type="submit" name="add_to_cart" class="btn btn-warning btn-sm">Add</button>
            </form>
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="remove" class="btn btn-remove btn-sm">✖</button>
            </form>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
  <?php } else {
    echo "<p class='text-center text-muted'>Your wishlist is empty.</p>";
  } ?>
</div>

</body>
</html>
