<?php include("connection.php"); session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #d3cce3, #e9e4f0);
            padding: 20px;
        }
        .user-card {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
        }
        img {
            max-width: 100px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <h1>User Information</h1>
    <?php
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    while ($user = mysqli_fetch_assoc($result)) {
        echo "<div class='user-card'>
                <img src='{$user['display_picture']}' alt='Profile Picture'>
                <h2>{$user['full_name']}</h2>
                <p><strong>Program:</strong> {$user['study_program']}</p>
                <p><strong>About Me:</strong> {$user['about_me']}</p>
              </div>";
    }
    ?>
</body>
</html>
