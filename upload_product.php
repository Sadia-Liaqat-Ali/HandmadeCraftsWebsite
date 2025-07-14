<?php
session_start();
include 'connection.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'artisan') {
  header("Location: login.php");
  exit();
}

$saller_id = $_SESSION['id']; // Correct artisan ID from session
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #e0f0ff; }
    .form-box { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 0 20px rgba(0, 123, 255, 0.2); }
    h3 { color: #0d6efd; text-align: center; margin-bottom: 20px; }
    .btn-blue { background-color: #0d6efd; color: white; }
    .btn-blue:hover { background-color: #0b5ed7; }
  </style>
</head>
<body>

<?php include 'includes/navbar_saller.php'; ?>

<div class="form-box">
  <h3>Add New Product</h3>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
    <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
    <input type="number" name="price" class="form-control mb-2" placeholder="Price" required>
    <input type="number" name="stock" class="form-control mb-2" placeholder="Stock Quantity" required>
    
    <select name="category" class="form-control mb-2" required>
      <option value="">Select Category</option>
      <option value="Jewelry">Jewelry</option>
      <option value="Clothing">Clothing</option>
      <option value="Home Decor">Home Decor</option>
      <option value="Toys">Toys</option>
      <option value="Paintings">Paintings</option>
    </select>

    <input type="file" name="image" class="form-control mb-2" required>

    <select name="custom_request" class="form-control mb-3" required>
      <option value="1">Accept Custom Design</option>
      <option value="0">Decline Custom Design</option>
    </select>

    <button type="submit" name="save" class="btn btn-primary w-100">Upload Product</button>
  </form>
</div>

<?php
if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $category = $_POST['category'];
  $custom = $_POST['custom_request'];

  $imgName = time() . "_" . basename($_FILES['image']['name']);
  $tmp = $_FILES['image']['tmp_name'];

  $status = "Pending"; // Default status

  if (move_uploaded_file($tmp, "uploads/" . $imgName)) {
    $sql = "INSERT INTO product (saller_id, name, description, price, stock, image, custom_request, category, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issiissss", $saller_id, $name, $desc, $price, $stock, $imgName, $custom, $category, $status);

    if ($stmt->execute()) {
      echo "<script>alert('Product Uploaded Successfully');</script>";
    } else {
      echo "<script>alert('Database Insert Failed: " . $stmt->error . "');</script>";
    }
  } else {
    echo "<script>alert('Image Upload Failed');</script>";
  }
}
?>
</body>
</html>
