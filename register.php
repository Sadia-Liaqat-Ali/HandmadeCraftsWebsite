<?php include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #ffecd2, #fcb69f);
            text-align: center;
            padding: 20px;
        }
        form {
            display: inline-block;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>Register Here</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="full_name" placeholder="Full Name (3-12 characters, no spaces)" required pattern="^[A-Za-z]{3,12}$">
        <input type="email" name="email" placeholder="Email" required>
        <input type="file" name="display_picture" required>
        <input type="password" name="password" placeholder="Password (min 8 chars, 1 uppercase, 1 special)" required pattern="(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}">
        <input type="text" name="cnic" placeholder="CNIC (13 digits)" required pattern="^\d{13}$">
        <select name="study_program" required>
            <option value="" disabled selected>Select Study Program</option>
            <option value="BSCS">BSCS</option>
            <option value="BSIT">BSIT</option>
            <option value="BSSE">BSSE</option>
            <option value="BSDS">BSDS</option>
            <option value="BSMGT">BSMGT</option>
            <option value="BSAI">BSAI</option>
            <option value="MCS">MCS</option>
            <option value="MIT">MIT</option>
            <option value="ADPCS">ADPCS</option>
            <option value="MSCS">MSCS</option>
        </select>
        <textarea name="about_me" placeholder="About Me" required></textarea>
        <button type="submit" name="signup">Signup</button>
        <button type="reset">Clear All</button>
    </form>

    <?php
    if (isset($_POST['signup'])) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $cnic = $_POST['cnic'];
        $study_program = $_POST['study_program'];
        $about_me = $_POST['about_me'];
        
        // Handle file upload
        $display_picture = $_FILES['display_picture']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($display_picture);
        move_uploaded_file($_FILES['display_picture']['tmp_name'], $target_file);

        $query = "INSERT INTO users (full_name, email, display_picture, password, cnic, study_program, about_me) 
                  VALUES ('$full_name', '$email', '$target_file', '$password', '$cnic', '$study_program', '$about_me')";
        if (mysqli_query($conn, $query)) {
            echo "<p>Registration successful! <a href='login.php'>Login here</a>.</p>";
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>
</body>
</html>
