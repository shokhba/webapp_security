<!--posts.php-->
<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'webapp_security');

if (isset($_POST['submit'])) {
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts(title, content, user_id) VALUES(?, ?, ?)");
    $stmt->bind_param("ssi", $post_title, $post_content, $user_id);
    $stmt->execute();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="css/posts_style.css">
</head>

<body>
    <nav class="navbar">
        <div class="welcome">WELCOME, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span></div>
        <div class="nav-links">
            <a href="profile.php">PROFILE</a>
            <a href="logout.php">LOGOUT</a>
            <img src="uploads/<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>">
        </div>
    </nav>

    <div class="main">
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="search" placeholder="SEARCH POSTS...">
            <input type="submit" value="SEARCH">
        </form>

        <div class="post-form">
            <div class="tag">NEW_POST</div>
            <form action="posts.php" method="POST">
                <input type="text" name="post_title" placeholder="TITLE">
                <input type="text" name="post_content" placeholder="CONTENT">
                <input type="submit" name="submit" value="POST">
            </form>
        </div>

        <?php
        $query = "SELECT posts.id, posts.title, posts.content, users.username 
                  FROM posts JOIN users ON posts.user_id = users.id";
        $result = mysqli_query($conn, $query);

        while ($post = mysqli_fetch_assoc($result)) {
            echo "<div class='post-card'>";
            echo "<h3>" .  htmlspecialchars($post['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($post['content']) . "</p>";
            echo "<div class='by'>BY: " . htmlspecialchars($post['username']) . "</div>";

            $post_id = $post['id'];
            $comments_query = "SELECT comments.content, users.username 
                               FROM comments 
                               JOIN users ON comments.user_id = users.id
                               WHERE comments.post_id = '$post_id'";
            $comments_result = mysqli_query($conn, $comments_query);
            while ($comment = mysqli_fetch_assoc($comments_result)) {
                echo "<div class='comment'><span>" . htmlspecialchars($comment['username']) . "</span>: " . htmlspecialchars($comment['content']) . "</div>";
            }

            echo "<form class='comment-form' action='comments.php' method='POST'>";
            echo "<input type='hidden' name='post_id' value='" . $post['id'] . "'>";
            echo "<textarea name='comments' placeholder='Write a comment...'></textarea>";
            echo "<input type='submit' name='submit' value='COMMENT'>";
            echo "</form>";

            echo "</div>";
        }
        ?>
    </div>
</body>

</html>