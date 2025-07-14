<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'artisan') {
  header("Location: login.php");
  exit();
}

$saller_id = $_SESSION['id'];

if (!isset($_GET['id'])) {
  echo "<script>alert('No product selected'); window.location.href='manage_inventory.php';</script>";
  exit();
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM product WHERE id = $id AND saller_id = $saller_id");

if ($result->num_rows == 0) {
  echo "<script>alert('Product not found or unauthorized'); window.location.href='manage_inventory.php';</script>";
  exit();
}

$product = $result->fetch_assoc();

if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $category = $_POST['category'];
  $custom = $_POST['custom_request'];

  // Check if image is changed
  if ($_FILES['image']['name']) {
    $imgName = time() . "_" . basename($_FILES['image']['name']);
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $imgName);
  } else {
    $imgName = $product['image']; // Keep old image
  }

  $update = $conn->prepare("UPDATE product SET name=?, description=?, price=?, stock=?, image=?, custom_request=?, category=? WHERE id=? AND saller_id=?");
  $update->bind_param("ssdiisiii", $name, $desc, $price, $stock, $imgName, $custom, $category, $id, $saller_id);

  if ($update->execute()) {
    echo "<script>alert('Product Updated'); window.location.href='manage_inventory.php';</script>";
  } else {
    echo "<script>alert('Update Failed');</script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f0f8ff; }
    .edit-box { max-width: 650px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
    h3 { text-align: center; color: #0d6efd; }
    .btn-blue { background-color: #0d6efd; color: white; }
    .btn-blue:hover { background-color: #0b5ed7; }
  </style>
</head>
<body>

<?php include 'includes/navbar_saller.php'; ?>

<div class="edit-box">
  <h3>Edit Product</h3>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" class="form-control mb-2" value="<?= $product['name'] ?>" required>
    <textarea name="description" class="form-control mb-2" required><?= $product['description'] ?></textarea>
    <input type="number" name="price" class="form-control mb-2" value="<?= $product['price'] ?>" required>
    <input type="number" name="stock" class="form-control mb-2" value="<?= $product['stock'] ?>" required>

    <select name="category" class="form-control mb-2" required>
      <option value="">Select Category</option>
      <option value="Jewelry" <?= $product['category'] == 'Jewelry' ? 'selected' : '' ?>>Jewelry</option>
      <option value="Clothing" <?= $product['category'] == 'Clothing' ? 'selected' : '' ?>>Clothing</option>
      <option value="Home Decor" <?= $product['category'] == 'Home Decor' ? 'selected' : '' ?>>Home Decor</option>
      <option value="Toys" <?= $product['category'] == 'Toys' ? 'selected' : '' ?>>Toys</option>
      <option value="Paintings" <?= $product['category'] == 'Paintings' ? 'selected' : '' ?>>Paintings</option>
    </select>

    <label>Current Image:</label><br>
    <img src="uploads/<?= $product['image'] ?>" width="100" class="mb-2"><br>
    <input type="file" name="image" class="form-control mb-2">

    <select name="custom_request" class="form-control mb-3" required>
      <option value="1" <?= $product['custom_request'] == 1 ? 'selected' : '' ?>>Accept Custom Design</option>
      <option value="0" <?= $product['custom_request'] == 0 ? 'selected' : '' ?>>Decline Custom Design</option>
    </select>

    <button type="submit" name="update" class="btn btn-success w-100">Update Product</button>
  </form>
</div>

</body>
</html>
