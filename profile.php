<!--profile.php-->
<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'webapp_security');

if (isset($_POST['submit'])) {

    if (!empty($_FILES['profile_img']['name'])) {
        $file = $_FILES['profile_img'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $upload_path = "uploads/" . $file_name;

        move_uploaded_file($file_tmp, $upload_path);

        $query = "UPDATE users SET profile_pic = '$file_name' WHERE id = '{$_SESSION['user_id']}'";
        mysqli_query($conn, $query);

        $_SESSION['profile_pic'] = $file_name;


        echo "Upload successful!";
    }
    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
        $query = "UPDATE users SET username='$username' WHERE id='{$_SESSION['user_id']}'";
        mysqli_query($conn, $query);
        echo "Change successful!";
    }

    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
        $query = "UPDATE users SET email='$email' WHERE id='{$_SESSION['user_id']}'";
        mysqli_query($conn, $query);
        echo "Change successful!";
    }

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET password='$password' WHERE id='{$_SESSION['user_id']}'";
        mysqli_query($conn, $query);
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