<?php
session_start();
$conn = new mysqli("localhost", "root", "", "handmadecrafts");

// Redirect non-admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
  header("Location: login.php");
  exit();
}

// --- Update User ---
if (isset($_POST['update_user'])) {
  $table = $_POST['table'];
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $status = $_POST['status'];
  $conn->query("UPDATE $table SET name='$name', email='$email', status='$status' WHERE id=$id");
}

// --- Delete User ---
if (isset($_GET['delete']) && isset($_GET['type'])) {
  $table = $_GET['type'] == 'artisan' ? 'artisan' : 'users';
  $id = $_GET['delete'];
  $conn->query("DELETE FROM $table WHERE id=$id");
  echo "<script>alert('User deleted'); window.location='manage_users.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f0f8ff; }
    h2 { color: #004080; text-align: center; margin: 30px 0; }
    .table-box { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
    .form-inline { display: flex; flex-wrap: wrap; gap: 10px; }
    .form-inline input, .form-inline select { flex: 1; min-width: 120px; }
  </style>
</head>
<body>

<?php include('includes/navbar_admin.php'); ?>

<div class="container mt-5">
  <h2>User Management</h2>

  <!-- USERS -->
  <div class="table-box mt-4">
    <h4>Users</h4>
    <table class="table table-bordered">
      <thead class="table-primary">
        <tr>
          <th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $result = $conn->query("SELECT * FROM users");
        while ($row = $result->fetch_assoc()) {
      ?>
        <tr>
          <form method="post" class="form-inline">
            <td><?= $row['id'] ?><input type="hidden" name="id" value="<?= $row['id'] ?>"><input type="hidden" name="table" value="users"></td>
            <td><input type="text" name="name" value="<?= $row['name'] ?>" class="form-control"></td>
            <td><input type="email" name="email" value="<?= $row['email'] ?>" class="form-control"></td>
            <td>
              <select name="status" class="form-select">
                <option value="active" <?= $row['status'] == 'active' ? 'selected' : '' ?>>active</option>
                <option value="suspended" <?= $row['status'] == 'suspended' ? 'selected' : '' ?>>suspended</option>
                <option value="banned" <?= $row['status'] == 'banned' ? 'selected' : '' ?>>banned</option>
              </select>
            </td>
            <td>
              <button type="submit" name="update_user" class="btn btn-sm btn-primary">Update</button>
              <a href="?delete=<?= $row['id'] ?>&type=user" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
          </form>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- ARTISANS -->
  <div class="table-box mt-5">
    <h4>Artisans</h4>
    <table class="table table-bordered">
      <thead class="table-info">
        <tr>
          <th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $result = $conn->query("SELECT * FROM artisan");
        while ($row = $result->fetch_assoc()) {
      ?>
        <tr>
          <form method="post" class="form-inline">
            <td><?= $row['id'] ?><input type="hidden" name="id" value="<?= $row['id'] ?>"><input type="hidden" name="table" value="artisan"></td>
            <td><input type="text" name="name" value="<?= $row['name'] ?>" class="form-control"></td>
            <td><input type="email" name="email" value="<?= $row['email'] ?>" class="form-control"></td>
            <td>
              <select name="status" class="form-select">
                <option value="active" <?= $row['status'] == 'active' ? 'selected' : '' ?>>active</option>
                <option value="suspended" <?= $row['status'] == 'suspended' ? 'selected' : '' ?>>suspended</option>
                <option value="banned" <?= $row['status'] == 'banned' ? 'selected' : '' ?>>banned</option>
              </select>
            </td>
            <td>
              <button type="submit" name="update_user" class="btn btn-sm btn-primary">Update</button>
              <a href="?delete=<?= $row['id'] ?>&type=artisan" class="btn btn-sm btn-danger" onclick="return confirm('Delete this artisan?')">Delete</a>
            </td>
          </form>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
