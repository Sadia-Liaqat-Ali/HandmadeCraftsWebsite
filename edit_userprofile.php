<?php
session_start();
$conn = new mysqli("localhost", "root", "", "handmadecrafts");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}

$user_id = intval($_SESSION['user_id']);

// Update user profile
if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $new_password = $_POST['password'];

  if (!empty($new_password)) {
    $hashed_pass = md5($new_password);
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, contact=?, address=?, password=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $email, $contact, $address, $hashed_pass, $user_id);
  } else {
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, contact=?, address=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $contact, $address, $user_id);
  }

  if ($stmt->execute()) {
    echo "<script>alert('Profile updated successfully!');</script>";
  } else {
    echo "<script>alert('Error: " . $conn->error . "');</script>";
  }

  // Update payment method selections
  $conn->query("DELETE FROM saved_payment_methods WHERE user_id='$user_id'");
  if (isset($_POST['gateways'])) {
    $insert_stmt = $conn->prepare("INSERT INTO saved_payment_methods (user_id, gateway_id) VALUES (?, ?)");
    foreach ($_POST['gateways'] as $gid) {
      $gid = intval($gid);
      $insert_stmt->bind_param("ii", $user_id, $gid);
      $insert_stmt->execute();
    }
  }
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
  $user = $result->fetch_assoc();
} else {
  echo "<script>alert('User not found.'); window.location='login.php';</script>";
  exit();
}

// Fetch available payment gateways (allowed = 1)
$gateways = $conn->query("SELECT * FROM payment_gateways WHERE allowed = 1");

// Fetch user’s saved payment methods
$saved_ids = [];
$saved = $conn->query("SELECT gateway_id FROM saved_payment_methods WHERE user_id='$user_id'");
if ($saved) {
  while ($row = $saved->fetch_assoc()) {
    $saved_ids[] = $row['gateway_id'];
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f3e6ff;
      padding-top: 80px;
    }
    .form-container {
      max-width: 750px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(106, 13, 173, 0.15);
    }
    h2 {
      color: #6a0dad;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }
    label {
      font-weight: 500;
      color: #333;
    }
    .btn-purple {
      background-color: #6a0dad !important;
      border: none;
      color: white !important;
      font-weight: bold;
      transition: 0.3s ease;
    }
    .btn-purple:hover {
      background-color: #4b0082 !important;
      color: #fff !important;
    }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="form-container">
  <h2>Edit Your Profile</h2>
  <form method="post">
    <div class="mb-3">
      <label>Full Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Email Address</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Contact Number</label>
      <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($user['contact']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Address</label>
      <textarea name="address" class="form-control" rows="3" required><?= htmlspecialchars($user['address']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>
      <input type="password" name="password" class="form-control" placeholder="Enter new password">
    </div>

    <hr class="my-4">
    <h5 class="text-primary">Select Your Preferred Payment Methods</h5>
    <div class="mb-3">
      <?php if ($gateways && $gateways->num_rows > 0): ?>
        <?php while ($row = $gateways->fetch_assoc()): ?>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="gateways[]" value="<?= $row['id'] ?>"
              <?= in_array($row['id'], $saved_ids) ? 'checked' : '' ?>>
            <label class="form-check-label"><?= htmlspecialchars($row['gateway_name']) ?></label>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-muted">No available payment methods found.</p>
      <?php endif; ?>
    </div>

    <button type="submit" name="update" class="btn btn-primary w-100">Update Profile</button>
  </form>
</div>

</body>
</html>
