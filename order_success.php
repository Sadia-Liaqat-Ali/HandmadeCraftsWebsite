<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Order Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; padding-top: 70px; }
    .container {
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(106, 13, 173, 0.15);
    }
    .emoji { font-size: 60px; }
    h2 { color: #6a0dad; font-weight: bold; }
    .status-bar {
      display: flex; justify-content: space-between; margin: 30px 0;
    }
    .stage {
      text-align: center; flex: 1;
    }
    .circle {
      width: 40px; height: 40px;
      background-color: #6a0dad; color: white;
      line-height: 40px; border-radius: 50%;
      margin: 0 auto 10px;
      font-weight: bold;
    }
    .stage.complete .circle {
      background-color: #28a745;
    }
    .btn-custom {
      background-color: #6a0dad; color: white; font-weight: bold;
    }
    .btn-custom:hover {
      background-color: #4b0082;
    }
    .summary-box {
      margin-top: 30px;
      border-left: 5px solid #6a0dad;
      background-color: #f9f0ff;
      padding: 15px;
    }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container">
  <div class="text-center">
    <div class="emoji">🎉</div>
    <h2>Congratulations! Your Order Has Been Placed</h2>
    <p class="text-muted">We have received your order and it's being processed.</p>
  </div>

  <!-- Order Status Timeline -->
  <div class="status-bar">
    <div class="stage complete">
      <div class="circle">1</div>
      <div>Order Placed</div>
    </div>
    <div class="stage">
      <div class="circle">2</div>
      <div>Approved</div>
    </div>
    <div class="stage">
      <div class="circle">3</div>
      <div>Shipped</div>
    </div>
    <div class="stage">
      <div class="circle">4</div>
      <div>Delivered</div>
    </div>
  </div>

  <!-- Instruction Section -->
  <div class="mb-4">
    <p><strong>Next Steps:</strong></p>
    <ul>
      <li>You will receive an email when your order is approved and shipped.</li>
      <li>For custom orders, the artisan may contact you directly.</li>
      <li>Keep your payment receipt until delivery is confirmed.</li>
      <li>Track your orders from the <strong>My Orders</strong> section.</li>
    </ul>
  </div>

  <!-- Order Summary -->
  <?php if (!empty($_SESSION['cart'])): ?>
  <div class="summary-box" id="printSection">
    <h5 class="mb-3">🧾 Order Summary</h5>
    <table class="table table-bordered bg-white">
      <thead class="table-dark">
        <tr><th>#</th><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
      </thead>
      <tbody>
      <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $i => $item):
          $sub = $item['price'] * $item['quantity'];
          $total += $sub;
      ?>
        <tr>
          <td><?= $i+1 ?></td>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td>Rs. <?= $item['price'] ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>Rs. <?= $sub ?></td>
        </tr>
      <?php endforeach; ?>
        <tr>
          <th colspan="4" class="text-end">Total</th>
          <th>Rs. <?= number_format($total, 2) ?></th>
        </tr>
      </tbody>
    </table>
  </div>
  <?php endif; ?>

  <!-- Download Button -->
  <div class="text-center mt-4">
    <a href="customer_browse.php" class="btn btn-secondary ms-2">← Continue Shopping</a>
  </div>
</div>


</body>
</html>
