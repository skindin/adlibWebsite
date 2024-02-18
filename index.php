<?php
    include('database_check.php');
    include('passwordCheck.php'); login();
    include('postList.php');
    include('logout.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>She ? My ? Til I ?</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h2>
        She ? My ? Til I ?
    </h2>

    <form action="newPost.php">
        <input type="submit" value = "New Post">
    </form>

    <?php
        printRecent();
    ?>
</html>
