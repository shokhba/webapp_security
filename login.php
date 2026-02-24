<!--login.php-->
<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'webapp_security');

if (isset($_POST['submit'])) {

    $Email = $_POST['email'];
    $Password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$Email'";

    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($Password, $user['password'])) {
        $_SESSION['email'] = $Email;
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['profile_pic'] = $user['profile_pic'];

        header('Location: posts.php');
    } else {
        echo "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login_style.css">
</head>

<body>
    <div class="container">
        <div class="tag">WEBAPP_SECURITY</div>
        <h1>LOGIN TO<br><span>SYSTEM</span></h1>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label>EMAIL</label>
                <input type="email" name="email" placeholder="enter your email">
            </div>
            <div class="form-group">
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="enter your password">
            </div>
            <input type="submit" name="submit" value="LOGIN" class="btn-submit">
        </form>
        <div class="link">
            <p>Don't have an account? <a href="signup.php">SIGN UP</a></p>
        </div>
    </div>
</body>

</html>