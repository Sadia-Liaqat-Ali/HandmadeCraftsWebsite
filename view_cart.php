<?php
session_start();

// Add to cart handler
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    $item = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $price,
        'quantity' => $quantity
    ];

    // Update if already exists
    $_SESSION['cart'][$product_id] = $item;
    header("Location: view_cart.php");
    exit();
}

// Remove item
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    header("Location: view_cart.php");
    exit();
}

// Update quantities
if (isset($_POST['update_cart']) && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $qty = intval($qty);
        if ($qty > 0 && isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }
    header("Location: view_cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff0f5; }
        .container { background: white; padding: 30px; margin-top: 40px; border-radius: 15px; box-shadow: 0 0 25px rgba(255, 105, 180, 0.3); }
        h3 { color: #ff3385; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="container">
    <h3>Your Shopping Cart</h3>

    <?php if (!empty($_SESSION['cart'])) { ?>
        <form method="POST" action="view_cart.php">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Price (Rs.)</th>
                        <th>Quantity</th>
                        <th>Subtotal (Rs.)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item) {
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price'], 2); ?></td>
                        <td style="width: 100px;">
                            <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="form-control">
                        </td>
                        <td><?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <a href="view_cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th colspan="2">Rs. <?php echo number_format($total, 2); ?></th>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between">
                <a href="browse.php" class="btn btn-secondary">Continue Shopping</a>
                <div>
                    <button type="submit" name="update_cart" class="btn btn-warning">Update Cart</button>
                    <a href="checkout.php" class="btn btn-success">Checkout</a>
                </div>
            </div>
        </form>
    <?php } else { ?>
        <p class="text-center text-muted">Your cart is empty.</p>
        <div class="text-center mt-3">
            <a href="browse.php" class="btn btn-primary">Browse Products</a>
        </div>
    <?php } ?>
</div>

</body>
</html>
