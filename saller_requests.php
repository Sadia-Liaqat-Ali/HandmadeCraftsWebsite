<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'artisan') {
  echo "<script>alert('Access denied');window.location='login.php';</script>";
  exit();
}

$artisan_id = $_SESSION['id'];

// Fetch all custom requests
$requests = $conn->query("SELECT * FROM custom_requests ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Custom Requests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff0f5;
    }
    .container {
      background: white;
      padding: 30px;
      margin-top: 40px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(255, 105, 180, 0.3);
    }
    h3 {
      color: #d63384;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }
    .table th {
      background-color: #ff66a3;
      color: white;
    }
    .table td {
      vertical-align: middle;
    }
    .btn-chat {
      background-color: #6a0dad;
      color: white;
    }
    .btn-chat:hover {
      background-color: #4b0082;
    }
  </style>
</head>
<body>

<?php include 'includes/navbar_saller.php'; ?>

<div class="container">
  <h3>Customer Design Requests</h3>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Product</th>
          <th>Category</th>
          <th>Details</th>
          <th>Contact</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 1;
        while ($r = $requests->fetch_assoc()) {
        ?>
          <tr>
            <td><?= $count++ ?></td>
            <td><?= htmlspecialchars($r['product_name']) ?></td>
            <td><?= htmlspecialchars($r['category']) ?></td>
            <td><?= nl2br(htmlspecialchars($r['details'])) ?></td>
            <td><?= htmlspecialchars($r['contact']) ?></td>
            <td><?= date("d M Y", strtotime($r['created_at'])) ?></td>
            <td>
              <a href="chatbox.php?request_id=<?= $r['id']; ?>&role=seller" class="btn btn-chat btn-primary w-100">Chat with Customer</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
