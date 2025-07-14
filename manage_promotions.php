<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "<script>alert('Access denied');window.location='login.php';</script>";
  exit();
}

// Delete promotion
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM promotions WHERE id = $id");
  echo "<script>window.location='manage_promotions.php';</script>";
  exit();
}

$promotions = $conn->query("SELECT * FROM promotions ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Promotions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #fff0f5; }
    .container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(255, 105, 180, 0.2);
    }
    h4 { color: #d63384; font-weight: bold; }
    .btn-delete { background-color: #dc3545; color: white; }
    .btn-delete:hover { background-color: #bb2d3b; }
  </style>
</head>
<body>

<?php include 'includes/navbar_admin.php'; ?>

<div class="container mt-4">
  <h4 class="mb-4 text-center">📢 Manage Promotions & Notifications</h4>

  <table class="table table-bordered table-hover">
    <thead class="table-danger">
      <tr>
        <th>#</th>
        <th>Type</th>
        <th>Description</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($promotions->num_rows > 0) {
        $i = 1;
        while ($row = $promotions->fetch_assoc()) {
          echo "<tr>
                  <td>$i</td>
                  <td>{$row['type']}</td>
                  <td>{$row['description']}</td>
                  <td>" . date('d M Y h:i A', strtotime($row['created_at'])) . "</td>
                  <td><a href='?delete={$row['id']}' class='btn btn-danger btn-delete' onclick=\"return confirm('Delete this promotion?')\">Delete</a></td>
                </tr>";
          $i++;
        }
      } else {
        echo "<tr><td colspan='5' class='text-center text-muted'>No promotions found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
