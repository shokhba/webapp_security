<!--comments.php-->

<?php 

session_start(); 

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect('localhost','root','','webapp_security');



if(isset($_POST['submit'])){
    $post_comments = $_POST['comments'];
    $post_id = $_POST['post_id'];
    $query = "INSERT INTO comments(content, user_id, post_id) 
    VALUES('$post_comments', '{$_SESSION['user_id']}', '$post_id')";
    mysqli_query($conn, $query);
    header('Location: posts.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>