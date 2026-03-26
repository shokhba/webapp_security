<!--signup.php-->
<?php
$conn = mysqli_connect('localhost', 'root', '', 'webapp_security');

if (isset($_POST['submit'])) {
    $Username = $_POST['username'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $Confirmpassword = $_POST['confirmpassword'];

    // Regex username
    if(!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $Username)){
        echo "input valid please Validate username - letters, numbers, underscore only";
        exit();
    }

    // Regex email
    if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email!";
        exit();
    }

 // Regex password
    if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $Password)){
        echo "Password must be 8+ chars, uppercase, lowercase, number, special character!";
        exit();
    }
    

    if ($Password == $Confirmpassword) {
        $hash_pass = password_hash($Password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users(username, email, password) VALUES('$Username', '$Email', '$hash_pass')";
        mysqli_query($conn, $query);
        header('Location: login.php');
    } else {
        echo "Passwords don't match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup_style.css">
</head>

<body>
    <div class="container">
        <div class="tag">WEBAPP_SECURITY</div>
        <h1>CREATE<br><span>ACCOUNT</span></h1>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label>USERNAME</label>
                <input type="text" name="username" placeholder="enter your username">
            </div>
            <div class="form-group">
                <label>EMAIL</label>
                <input type="email" name="email" placeholder="enter your email">
            </div>
            <div class="form-group">
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="enter your password">
            </div>
            <div class="form-group">
                <label>CONFIRM PASSWORD</label>
                <input type="password" name="confirmpassword" placeholder="confirm your password">
            </div>
            <input type="submit" name="submit" value="SIGN UP" class="btn-submit">
        </form>
        <div class="link">
            <p>Already have an account? <a href="login.php">LOGIN</a></p>
        </div>
    </div>
</body>

</html>