<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "<script>alert('Access denied');window.location='login.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>View All Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f0f8ff; }
    .scroll-btn {
      font-size: 18px;
      font-weight: bold;
      background-color: #6a0dad;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 25px;
      margin: 20px auto;
      display: block;
      transition: 0.3s;
    }
    .scroll-btn:hover {
      background-color: #4b0082;
    }
    .table td, .table th {
      vertical-align: middle;
    }
    .badge-status {
      font-size: 0.85em;
    }
  </style>
</head>
<body>

<?php include('includes/navbar_admin.php'); ?>



<div class="container" id="productlist">
  <h3 class="text-primary mt-4 mb-3">📦 All Product Listings</h3>
  <table class="table table-bordered table-hover bg-white shadow-sm">
    <thead class="table-primary">
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price (Rs.)</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Tax %</th>
        <th>Shipping (Rs.)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $products = $conn->query("SELECT * FROM product ORDER BY created_at DESC");
      while ($p = $products->fetch_assoc()) {
        $cat = $p['category'];
        $tax_q = $conn->query("SELECT tax_percent FROM taxes WHERE category='$cat'");
        $ship_q = $conn->query("SELECT shipping_fee FROM shipping_rates WHERE category='$cat'");
        $tax = ($tax_q->num_rows > 0) ? $tax_q->fetch_assoc()['tax_percent'] : 0;
        $ship = ($ship_q->num_rows > 0) ? $ship_q->fetch_assoc()['shipping_fee'] : 0;
      ?>
        <tr>
          <td><img src="uploads/<?php echo $p['image']; ?>" width="70" height="70" class="rounded"></td>
          <td><?php echo $p['name']; ?></td>
          <td><?php echo $cat; ?></td>
          <td><?php echo $p['price']; ?></td>
          <td><?php echo $p['stock']; ?></td>
          <td>
            <span class="badge bg-<?php echo $p['status'] == 'Active' ? 'success' : ($p['status'] == 'Rejected' ? 'danger' : 'secondary'); ?> badge-status">
              <?php echo $p['status']; ?>
            </span>
          </td>
          <td><?php echo $tax; ?>%</td>
          <td><?php echo $ship; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Scroll to Manage Tax/Promotions Button -->
  <a href="admin_manage_rates.php" class="scroll-btn text-center">⚙️ Manage Tax & Promotions</a>
</div>

</body>
</html>
