<?php
session_start();
include 'connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}

$promotions = $conn->query("SELECT * FROM promotions ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Latest Promotions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; padding-top: 80px; }
    .promo-box {
      max-width: 800px;
      margin: 0 auto;
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(106, 13, 173, 0.15);
    }
    .promo-msg {
      background: #f9f0ff;
      border-left: 5px solid #6a0dad;
      margin-bottom: 15px;
      padding: 15px;
      border-radius: 10px;
    }
    .promo-msg h6 { margin-bottom: 5px; color: #6a0dad; }
    .promo-msg small { color: #888; }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="promo-box mt-4">
  <h4 class="text-center text-primary mb-4">🔔 Latest Updates & Notifications</h4>

  <?php if ($promotions->num_rows > 0): ?>
    <?php while ($row = $promotions->fetch_assoc()): ?>
      <div class="promo-msg">
        <h6><?= htmlspecialchars($row['type']) ?></h6>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <small>📅 <?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></small>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-muted text-center">No notifications yet.</p>
  <?php endif; ?>
</div>

</body>
</html>
