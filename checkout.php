<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; padding-top: 80px; }
    .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 0 25px rgba(106,13,173,0.2); }
    h4 { color: #6a0dad; margin-bottom: 20px; font-weight: bold; }
    .btn-primary, .btn-success, .btn-secondary { font-weight: bold; }
    .btn-secondary { background-color: #6a0dad; color: white; border: none; }
    .btn-secondary:hover { background-color: #4b0082; }
    .summary-box {
      background-color: #f9f0ff;
      border-left: 5px solid #6a0dad;
      padding: 15px;
      margin-top: 10px;
      font-size: 16px;
    }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h4>Checkout Form</h4>
      <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
        <a href="browse_products.php" class="btn btn-secondary">← Continue Shopping</a>
      <?php else: ?>
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
        $user_id = $_SESSION['user_id'] ?? 0;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $address = $_POST['address'];
        $payment = $_POST['payment'];
        $receipt = $_FILES['receipt']['name'];
        $tmp = $_FILES['receipt']['tmp_name'];

        $errors = [];

        if (!$name || !$email || !$phone || !$state || !$zip || !$address || !$payment || !$receipt) {
          $errors[] = "All fields are required.";
        }

        if (empty($errors)) {
          $receipt_path = "uploads/receipts/" . time() . "_" . basename($receipt);
          move_uploaded_file($tmp, $receipt_path);

          $used_categories = [];
          foreach ($_SESSION['cart'] as $item) {
            $pid = (int)$item['id'];
            $qty = (int)$item['quantity'];
            $price = (float)$item['price'];
            $subtotal = $price * $qty;

            $p = $conn->query("SELECT category FROM product WHERE id = $pid")->fetch_assoc();
            $cat = $p['category'] ?? '';

            $tax_r = $conn->query("SELECT tax_percent FROM taxes WHERE category='$cat'")->fetch_assoc();
            $taxp = floatval($tax_r['tax_percent'] ?? 0);
            $tax_amt = round($subtotal * $taxp / 100, 2);

            // Shipping fee only once per category
            $ship_amt = 0;
            if (!isset($used_categories[$cat])) {
              $ship_r = $conn->query("SELECT shipping_fee FROM shipping_rates WHERE category='$cat'")->fetch_assoc();
              $ship_amt = floatval($ship_r['shipping_fee'] ?? 0);
              $used_categories[$cat] = true;
            }

            $total_amt = $subtotal + $tax_amt + $ship_amt;

            $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, payment_gateway, tax_amount, shipping_fee, total_amount, name, email, phone, state, zip, address, payment_receipt)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiisdddsssssss", $user_id, $pid, $qty, $payment, $tax_amt, $ship_amt, $total_amt, $name, $email, $phone, $state, $zip, $address, $receipt_path);
            $stmt->execute();
          }

          $_SESSION['cart'] = [];
          echo "<script>window.location='order_success.php';</script>";
          exit();
        } else {
          echo "<div class='alert alert-danger'>" . implode('<br>', $errors) . "</div>";
        }
      }
      ?>

      <form method="post" enctype="multipart/form-data">
        <div class="mb-2"><input type="text" name="name" class="form-control" placeholder="Your Name" required></div>
        <div class="mb-2"><input type="email" name="email" class="form-control" placeholder="Your Email" required></div>
        <div class="mb-2"><input type="text" name="phone" class="form-control" placeholder="Phone Number" required></div>
        <div class="row">
          <div class="col-md-6 mb-2"><input type="text" name="state" class="form-control" placeholder="State" required></div>
          <div class="col-md-6 mb-2"><input type="text" name="zip" class="form-control" placeholder="ZIP Code" required></div>
        </div>
        <div class="mb-2"><textarea name="address" class="form-control" placeholder="Delivery Address" required></textarea></div>

        <div class="mb-2">
          <select name="payment" class="form-select" required>
            <option value="">Select Payment Method</option>
            <?php
            $pg = $conn->query("SELECT gateway_name FROM payment_gateways WHERE allowed=1");
            while ($rw = $pg->fetch_assoc()) {
              echo "<option value='{$rw['gateway_name']}'>{$rw['gateway_name']}</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-2"><input type="file" name="receipt" class="form-control" required></div>
        <button type="submit" name="place_order" class="btn btn-primary w-100">Place Order</button>
      </form>
      <?php endif; ?>
    </div>

    <div class="col-md-6">
      <h4>Order Summary</h4>
      <?php
      if (!empty($_SESSION['cart'])):
        $total = 0;
        $tax_total = 0;
        $shipping_total = 0;
        $used_categories = [];

        foreach ($_SESSION['cart'] as $item) {
          $pid = $item['id'];
          $qty = $item['quantity'];
          $price = $item['price'];
          $subtotal = $price * $qty;
          $total += $subtotal;

          $p = $conn->query("SELECT category FROM product WHERE id = $pid")->fetch_assoc();
          $cat = $p['category'] ?? '';

          $tax_r = $conn->query("SELECT tax_percent FROM taxes WHERE category='$cat'")->fetch_assoc();
          $taxp = floatval($tax_r['tax_percent'] ?? 0);
          $item_tax = $subtotal * ($taxp / 100);
          $tax_total += $item_tax;

          if (!isset($used_categories[$cat])) {
            $ship_r = $conn->query("SELECT shipping_fee FROM shipping_rates WHERE category='$cat'")->fetch_assoc();
            $shipping_total += floatval($ship_r['shipping_fee'] ?? 0);
            $used_categories[$cat] = true;
          }
        }

        $grand_total = $total + $tax_total + $shipping_total;

        echo "<div class='summary-box'>
                <p><strong>Subtotal:</strong> Rs. " . number_format($total, 2) . "</p>
                <p><strong>Tax:</strong> Rs. " . number_format($tax_total, 2) . "</p>
                <p><strong>Shipping:</strong> Rs. " . number_format($shipping_total, 2) . "</p>
                <hr>
                <p class='text-success fw-bold'><strong>Total Payable:</strong> Rs. " . number_format($grand_total, 2) . "</p>
              </div>";

        echo '<a href="browse_products.php" class="btn btn-secondary w-100 mt-3">← Continue Shopping</a>';
      else:
        echo "<p>No items in cart.</p>";
      endif;
      ?>
    </div>
  </div>
</div>

</body>
</html>
