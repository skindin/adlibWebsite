<?php
    include('database_check.php');
    include('passwordCheck.php'); login();
    include('logout.php');//dora dora dora dora dora
    include('postList.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>She ? My ? Til I ?</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <body>
        <h2>
            She ? My ? Til I ?
        </h2>

        <form action="newPost.php">
            <input type="submit" value = "New Post">
        </form>


        <?php
            printOrder();
        ?>
    </body>
</html>
