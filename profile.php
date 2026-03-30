<!--profile.php-->
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'webapp_security');

if (isset($_POST['submit'])) {

    if (!empty($_FILES['profile_img']['name'])) {
        $file_name = $_FILES['profile_img']['name'];
        move_uploaded_file($_FILES['profile_img']['tmp_name'], "uploads/" . $file_name);
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("UPDATE users SET profile_pic=? WHERE id=?");
        $stmt->bind_param("si", $file_name, $user_id);
        $stmt->execute();
        $_SESSION['profile_pic'] = $file_name;

        echo "Upload successful!";
    }

    if (!empty($_POST['username'])) {
        // Regex username
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $_POST['username'])) {
            echo "input valid please Validate username - letters, numbers, underscore only";
            exit();
        }
        $username = $_POST['username'];
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("UPDATE users SET username=? WHERE id=?");
        $stmt->bind_param("si", $username, $user_id);
        $stmt->execute();
        $_SESSION['username'] = $username;

        echo "Change successful!";
    }

    if (!empty($_POST['email'])) {
        // Regex email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email!";
            exit();
        }
        $email = $_POST['email'];
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("UPDATE users SET email=? WHERE id=?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();

        echo "Change successful!";
    }

    if (!empty($_POST['password'])) {
        // Regex password
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $_POST['password'])) {
            echo "Password must be 8+ chars, uppercase, lowercase, number, special character!";
            exit();
        }
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $password, $user_id);
        $stmt->execute();
        echo "Change successful!";
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile_style.css">
</head>

<body>
    <nav class="navbar">
        <div class="welcome">WEBAPP_SECURITY</div>
        <div class="nav-links">
            <a href="posts.php">POSTS</a>
            <a href="logout.php">LOGOUT</a>
            <img src="uploads/<?php echo $_SESSION['profile_pic']; ?>" width="40" height="40">
        </div>
    </nav>

    <div class="main">
        <div class="container">
            <div class="tag">EDIT_PROFILE</div>
            <div class="profile-pic-section">
                <img src="uploads/<?php echo $_SESSION['profile_pic']; ?>" width="100" height="100" class="profile-img">
            </div>
            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>PROFILE PICTURE</label>
                    <input type="file" name="profile_img">
                </div>
                <div class="form-group">
                    <label>USERNAME</label>
                    <input type="text" name="username" placeholder="Enter new username">
                </div>
                <div class="form-group">
                    <label>EMAIL</label>
                    <input type="email" name="email" placeholder="Enter new email">
                </div>
                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" placeholder="Enter new password">
                </div>
                <input type="submit" name="submit" value="UPDATE" class="btn-submit">
            </form>
        </div>
    </div>
</body>

</html>