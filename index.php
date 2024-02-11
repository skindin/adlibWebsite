<?php
    include('database_check.php');
    include('passwordCheck.php'); login();
    include('postList.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Funny Add Lib</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h2>
        She _ My _ Till I _
    </h2>

    <form action="newPost.php">
        <input type="submit" value = "New Post">
    </form>

    <?php
        printRecent();
    ?>
</html>
