<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'artisan') {
  echo "<script>alert('Access denied');window.location='login.php';</script>";
  exit();
}

$artisan_id = $_SESSION['id'];


// Update Profile
if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $contact = $_POST['contact'];
  $skills = $_POST['skills'];
  $bio = $_POST['bio'];

  $stmt = $conn->prepare("UPDATE artisan SET name=?, email=?, contact=?, skills=?, bio=? WHERE id=?");
  $stmt->bind_param("sssssi", $name, $email, $contact, $skills, $bio, $artisan_id);
  $stmt->execute();

  echo "<script>alert('Profile updated successfully');</script>";
}

// Fetch current artisan data
$result = $conn->query("SELECT * FROM artisan WHERE id = $artisan_id");
$artisan = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Artisan Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #fff0f5; }
    .profile-box {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(255, 105, 180, 0.2);
    }
    h3 { text-align: center; color: #d63384; font-weight: bold; margin-bottom: 30px; }
    label { font-weight: bold; }
    .btn-pink { background-color: #d63384; color: white; }
    .btn-pink:hover { background-color: #a01b61; }
  </style>
</head>
<body>

<?php include 'includes/navbar_saller.php'; ?>

<div class="profile-box">
  <h3>👤 Artisan Profile Management</h3>
  <form method="POST">
    <div class="mb-3">
      <label>Full Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($artisan['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($artisan['email']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Contact</label>
      <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($artisan['contact']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Skills</label>
      <textarea name="skills" class="form-control" required><?= htmlspecialchars($artisan['skills']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Bio</label>
      <textarea name="bio" class="form-control" rows="4" placeholder="Add a short introduction or description..."><?= htmlspecialchars($artisan['bio'] ?? '') ?></textarea>
    </div>
    <button type="submit" name="update" class="btn btn-success w-100">Update Profile</button>
  </form>
</div>

</body>
</html>
