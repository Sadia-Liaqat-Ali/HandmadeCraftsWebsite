<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'artisan') {
  header("Location: login.php");
  exit();
}

$saller_id = $_SESSION['id'];

// Handle deletion
if (isset($_GET['delete_id'])) {
  $delete_id = intval($_GET['delete_id']);
  $conn->query("DELETE FROM product WHERE id = $delete_id AND saller_id = $saller_id");
  header("Location: manage_inventory.php"); // Make sure this is the correct filename
  exit();
}

// Fetch products
$products = $conn->query("SELECT * FROM product WHERE saller_id = $saller_id");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #e0f0ff; }
    h2 { color: #0d6efd; text-align: center; margin-top: 30px; }
    table { background-color: white; border-radius: 10px; overflow: hidden; }
    .table th { background-color: #007bff; color: white; }
    .btn-edit { background-color: #ffc107; color: white; }
    .btn-delete { background-color: #dc3545; color: white; }
  </style>
</head>
<body>

<?php include 'includes/navbar_saller.php'; ?>

<div class="container mt-4">
  <h2>Manage Your Products</h2>
  <table class="table table-bordered mt-4 text-center">
    <thead>
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Custom</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      while ($row = $products->fetch_assoc()) {
        echo "<tr>
          <td>{$i}</td>
          <td><img src='uploads/{$row['image']}' width='70'></td>
          <td>{$row['name']}</td>
          <td>{$row['category']}</td>
          <td>Rs. {$row['price']}</td>
          <td>{$row['stock']}</td>
          <td>" . ($row['custom_request'] ? 'Accepted' : 'Declined') . "</td>
          <td>
            <a href='edit_product.php?id={$row['id']}' class='btn btn-primary btn-edit'>Edit</a>
            <a href='?delete_id={$row['id']}' class='btn btn-danger btn-delete' onclick='return confirm(\"Delete this product?\")'>Delete</a>
          </td>
        </tr>";
        $i++;
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
