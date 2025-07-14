<?php
session_start();
include 'connection.php';

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
  header("Location: login.php");
  exit();
}

// Update product status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
  $id = $_POST['product_id'];
  $status = $_POST['status'];
  $conn->query("UPDATE product SET status='$status' WHERE id=$id");
}

// Fetch all products
$products = $conn->query("SELECT * FROM product ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #fff0f5; }
    h2 { text-align: center; margin-top: 30px; color: #cc0066; }
    .product-card {
      border: 1px solid #ffb6c1;
      border-radius: 15px;
      padding: 15px;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.2);
      background-color: white;
      transition: 0.3s;
    }
    .product-card:hover { transform: scale(1.02); }
    .card-img-top { height: 220px; object-fit: cover; border-radius: 10px; }
    .btn-group { margin-top: 10px; }
    .status-badge { padding: 4px 10px; border-radius: 8px; font-size: 14px; }
    .Pending { background-color: #fff3cd; color: #856404; }
    .Approved { background-color: #d4edda; color: #155724; }
    .Rejected { background-color: #f8d7da; color: #721c24; }
  </style>
</head>
<body>

<?php include('includes/navbar_admin.php'); ?>
<br><br>
<div class="container">
  <h2>Manage Product Listings</h2>
  <div class="row mt-4">

    <?php while ($row = $products->fetch_assoc()) { ?>
      <div class="col-md-4 mb-4">
        <div class="product-card">
          <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
          <div class="card-body">
            <h5 class="card-title text-danger"><?php echo htmlspecialchars($row['name']); ?></h5>
            <p class="mb-1"><strong>Price:</strong> Rs. <?php echo $row['price']; ?></p>
            <p class="mb-1"><strong>Stock:</strong> <?php echo $row['stock']; ?></p>
            <p class="mb-1"><strong>Category:</strong> <?php echo $row['category']; ?></p>
            <p class="mb-1"><strong>Custom Requests:</strong> <?php echo $row['custom_request'] ? 'Yes' : 'No'; ?></p>
            <p class="mb-1"><strong>Created At:</strong> <?php echo $row['created_at']; ?></p>
            <p class="mb-1"><strong>Status:</strong>
              <span class="status-badge <?php echo $row['status']; ?>">
                <?php echo $row['status']; ?>
              </span>
            </p>

            <!-- Status Form -->
            <form method="POST" class="btn-group w-100" role="group">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="status" value="Approved">
              <button type="submit" name="update_status" class="btn btn-success btn-sm">Approve</button>
            </form>

            <form method="POST" class="btn-group w-100 mt-2" role="group">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="status" value="Rejected">
              <button type="submit" name="update_status" class="btn btn-danger btn-sm">Reject</button>
            </form>

          </div>
        </div>
      </div>
    <?php } ?>

  </div>
</div>

</body>
</html>
