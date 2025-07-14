<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; }
    .container {
      background: white; padding: 30px; margin-top: 40px;
      border-radius: 15px; box-shadow: 0 0 25px rgba(106, 13, 173, 0.2);
    }
    h3 {
      color: #6a0dad; text-align: center;
      margin-bottom: 30px; font-weight: bold;
    }
    .summary-box {
      background-color: #f9f0ff;
      border-left: 5px solid #6a0dad;
      padding: 15px; margin-top: 20px;
      font-size: 16px;
    }
    .btn-danger { background-color: #ff4d4d; border: none; }
    .btn-danger:hover { background-color: #cc0000; }
    .btn-success { background-color: #28a745; font-weight: bold; border: none; }
    .btn-success:hover { background-color: #218838; }
    .btn-secondary { background-color: #6a0dad; border: none; font-weight: bold; }
    .btn-secondary:hover { background-color: #4b0082; }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container">
  <h3>Your Cart</h3>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $item = [
      "id" => $_POST['product_id'],
      "name" => $_POST['product_name'],
      "price" => $_POST['price'],
      "quantity" => $_POST['quantity']
    ];
    $_SESSION['cart'][] = $item;
  }

  if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
  }

  if (!empty($_SESSION['cart'])) {
    echo '<form method="POST" action="checkout.php">';
    echo '<table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>#</th><th>Product</th><th>Category</th><th>Price</th>
          <th>Qty</th><th>Subtotal</th><th>Action</th>
        </tr>
      </thead><tbody>';

    $total = 0;
    $tax_total = 0;
    $shipping_total = 0;
    $used_categories = [];

    foreach ($_SESSION['cart'] as $index => $item) {
      $pid = $item['id'];
      $qty = $item['quantity'];
      $price = $item['price'];

      // Fetch category
      $p = $conn->query("SELECT category FROM product WHERE id = $pid")->fetch_assoc();
      $category = $p['category'] ?? 'Unknown';

      // Subtotal
      $subtotal = $price * $qty;
      $total += $subtotal;

      // Tax per item
      $taxQ = $conn->prepare("SELECT tax_percent FROM taxes WHERE category = ?");
      $taxQ->bind_param("s", $category);
      $taxQ->execute();
      $taxQ->bind_result($tax_percent);
      $taxQ->fetch();
      $taxQ->close();
      $tax_percent = $tax_percent ?? 0;
      $item_tax = $subtotal * ($tax_percent / 100);
      $tax_total += $item_tax;

      // Shipping once per category
      if (!isset($used_categories[$category])) {
        $shipQ = $conn->prepare("SELECT shipping_fee FROM shipping_rates WHERE category = ?");
        $shipQ->bind_param("s", $category);
        $shipQ->execute();
        $shipQ->bind_result($ship_fee);
        $shipQ->fetch();
        $shipQ->close();
        $shipping_total += ($ship_fee ?? 0);
        $used_categories[$category] = true;
      }

      echo "<tr>
        <td>" . ($index + 1) . "</td>
        <td>{$item['name']}</td>
        <td>{$category}</td>
        <td>Rs. {$price}</td>
        <td>{$qty}</td>
        <td>Rs. {$subtotal}</td>
        <td><a href='?remove=$index' class='btn btn-danger btn-sm'>Remove</a></td>
      </tr>";
    }

    $grand_total = $total + $tax_total + $shipping_total;

    echo '</tbody></table>';

    echo "<div class='summary-box'>
      <p><strong>Subtotal:</strong> Rs. " . number_format($total, 2) . "</p>
      <p><strong>Tax:</strong> Rs. " . number_format($tax_total, 2) . "</p>
      <p><strong>Shipping:</strong> Rs. " . number_format($shipping_total, 2) . "</p>
      <hr>
      <p class='text-success fw-bold'><strong>Total Payable:</strong> Rs. " . number_format($grand_total, 2) . "</p>
    </div>";

    echo "<input type='hidden' name='subtotal' value='{$total}'>
          <input type='hidden' name='tax_amount' value='{$tax_total}'>
          <input type='hidden' name='shipping_fee' value='{$shipping_total}'>
          <input type='hidden' name='total_amount' value='{$grand_total}'>";

    echo '<button type="submit" name="proceed" class="btn btn-success w-100 mt-3">Proceed to Checkout</button>';
    echo '</form>';
    echo '<a href="customer_browse.php" class="btn btn-secondary w-100 mt-2">← Continue Shopping</a>';

  } else {
    echo "<p class='text-center text-muted'>Your cart is empty.</p>";
    echo '<div class="text-center mt-4">
            <a href="customer_browse.php" class="btn btn-secondary">← Continue Shopping</a>
          </div>';
  }
  ?>
</div>

</body>
</html>
