<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "<script>alert('Access denied');window.location='login.php';</script>";
  exit();
}

// Approve/Reject product
if (isset($_GET['action']) && isset($_GET['pid'])) {
  $id = (int) $_GET['pid'];
  $status = $_GET['action'] == 'approve' ? 'Active' : 'Rejected';
  $conn->query("UPDATE product SET status='$status' WHERE id=$id");

  if ($status == 'Active') {
    $prod = $conn->query("SELECT name, category FROM product WHERE id=$id")->fetch_assoc();
    $cat = $prod['category'];

    // Ensure category exists in tax/shipping
    $conn->query("INSERT IGNORE INTO taxes (category, tax_percent) VALUES ('$cat', 0)");
    $conn->query("INSERT IGNORE INTO shipping_rates (category, shipping_fee) VALUES ('$cat', 0)");

    $conn->query("INSERT INTO promotions (type, description) VALUES 
      ('Product Activated', 'Product \"{$prod['name']}\" has been activated by admin.')");
  }

  header("Location: admin_manage_rates.php");
  exit();
}

// Update Tax
if (isset($_POST['update_tax'])) {
  $cat = $_POST['category'];
  $tax = $_POST['tax'];

  // Check if exists
  $check = $conn->query("SELECT * FROM taxes WHERE category='$cat'");
  if ($check->num_rows > 0) {
    $conn->query("UPDATE taxes SET tax_percent=$tax WHERE category='$cat'");
  } else {
    $conn->query("INSERT INTO taxes (category, tax_percent) VALUES ('$cat', $tax)");
  }

  $conn->query("INSERT INTO promotions (type, description) VALUES 
    ('Tax Updated', 'Tax updated to $tax% for category: $cat')");
}

// Update Shipping
if (isset($_POST['update_shipping'])) {
  $cat = $_POST['category'];
  $fee = $_POST['shipping_fee'];

  // Check if exists
  $check = $conn->query("SELECT * FROM shipping_rates WHERE category='$cat'");
  if ($check->num_rows > 0) {
    $conn->query("UPDATE shipping_rates SET shipping_fee=$fee WHERE category='$cat'");
  } else {
    $conn->query("INSERT INTO shipping_rates (category, shipping_fee) VALUES ('$cat', $fee)");
  }

  $conn->query("INSERT INTO promotions (type, description) VALUES 
    ('Shipping Updated', 'Shipping updated to Rs. $fee for category: $cat')");
}

// Update Payment Gateways
if (isset($_POST['update_gateway'])) {
  $gateways = $conn->query("SELECT id FROM payment_gateways");
  while ($g = $gateways->fetch_assoc()) {
    $gid = $g['id'];
    $allowed = isset($_POST['gateway'][$gid]) ? 1 : 0;
    $conn->query("UPDATE payment_gateways SET allowed=$allowed WHERE id=$gid");
  }
  header("Location: admin_manage_rates.php");
  exit();
}

// Add New Payment Gateway
if (isset($_POST['add_gateway'])) {
  $name = $conn->real_escape_string($_POST['gateway_name']);
  $conn->query("INSERT INTO payment_gateways (gateway_name, allowed) VALUES ('$name', 1)");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Rates & Gateways</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #fff0f5; }
    .table td, .table th { vertical-align: middle; }
    .badge-status { font-size: 0.85em; }
  </style>
</head>
<body>

<?php include('includes/navbar_admin.php'); ?>

  <div class="row mt-5">
    <div class="col-md-6">
      <h4 class="text-danger">➕ Add New Payment Gateway</h4>
      <form method="post" class="bg-white p-4 rounded shadow-sm">
        <label>Gateway Name</label>
        <input type="text" name="gateway_name" class="form-control mb-3" required>
        <button type="submit" name="add_gateway" class="btn btn-primary">Add Gateway</button>
      </form>
    </div>

    <div class="col-md-6">
      <h4 class="text-danger">✅ Allowed Gateways</h4>
      <form method="post" class="bg-white p-4 rounded shadow-sm">
        <?php
        $gateways = $conn->query("SELECT * FROM payment_gateways");
        while ($g = $gateways->fetch_assoc()) {
        ?>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="gateway[<?php echo $g['id']; ?>]" <?php if ($g['allowed']) echo 'checked'; ?>>
            <label class="form-check-label"><?php echo $g['gateway_name']; ?></label>
          </div>
        <?php } ?>
        <button type="submit" name="update_gateway" class="btn btn-success mt-3">Update Gateways</button>
      </form>
    </div>
  </div>

  <hr class="my-5">

  <h4 class="text-danger">⚙️ Update Tax & Shipping</h4>
  <div class="row">
    <div class="col-md-6">
      <form method="post" class="bg-white p-4 rounded shadow-sm">
        <h6 class="mb-3">📌 Tax by Category</h6>
        <select name="category" class="form-select mb-2" required>
          <?php
          $cats = $conn->query("SELECT DISTINCT category FROM product");
          while ($c = $cats->fetch_assoc()) echo "<option value='{$c['category']}'>{$c['category']}</option>";
          ?>
        </select>
        <input type="number" name="tax" class="form-control mb-2" placeholder="Tax %" required>
        <button name="update_tax" class="btn btn-dark">Update Tax</button>
      </form>
    </div>

    <div class="col-md-6">
      <form method="post" class="bg-white p-4 rounded shadow-sm">
        <h6 class="mb-3">🚚 Shipping by Category</h6>
        <select name="category" class="form-select mb-2" required>
          <?php
          $cats = $conn->query("SELECT DISTINCT category FROM product");
          while ($c = $cats->fetch_assoc()) echo "<option value='{$c['category']}'>{$c['category']}</option>";
          ?>
        </select>
        <input type="number" name="shipping_fee" class="form-control mb-2" placeholder="Shipping Rs." required>
        <button name="update_shipping" class="btn btn-dark">Update Shipping</button>
       
      </form>
    </div>
  </div>
</div>

</body>
</html>
