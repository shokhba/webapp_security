<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'webapp_security');
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT posts.*, users.username 
          FROM posts 
          JOIN users ON posts.user_id = users.id
          WHERE posts.title LIKE '%$search%' OR posts.content LIKE '%$search%'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="css/search_style.css">
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
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="search" placeholder="SEARCH POSTS..." value="<?php echo $search; ?>">
            <input type="submit" value="SEARCH">
        </form>

        <div class="tag">RESULTS FOR: <span><?php echo $search; ?></span></div>

        <?php while ($post = mysqli_fetch_assoc($result)) { ?>
            <div class="post-card">
                <h3><?php echo $post['title']; ?></h3>
                <p><?php echo $post['content']; ?></p>
                <div class="by">BY: <?php echo $post['username']; ?></div>
            </div>
        <?php } ?>
    </div>
</body>

</html>