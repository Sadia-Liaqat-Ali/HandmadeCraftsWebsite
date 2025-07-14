<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "handmadecrafts");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query admin table
    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["role"] = "admin";
        $_SESSION["email"] = $email;
        header("Location: dashboard_admin.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #ffe6f0; }
        .login-box { max-width: 400px; margin: 100px auto; padding: 30px; background: white; border-radius: 15px; box-shadow: 0 0 20px rgba(255,105,180,0.3); }
        h2 { color: #ff3385; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Admin Login</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required placeholder="admin@gmail.com">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required placeholder="1234">
        </div>
        <button type="submit" class="btn btn-pink w-100 text-white" style="background-color:#ff3385;">Login</button>
    </form>
</div>
</body>
</html>
