<?php
    //i don't want to have to include the database check here so put it somewhere before this
    include('database_check.php');
    include("passwordCheck.php");

    if (isset($_POST['logIn']))
    {
        header('Location: postList.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Funny Add Lib</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h1>New Post</h1>
    <div>
        <form action="" method = "post">
            <div style="color:red;"><?php loginMsg();?></div>
            <label for="username">Username</label>
            <input type="username" name = "username">
            <br>
            <label for="password">Password</label>
            <input type="password" name = "password">
            <br>
            <input type="submit" value = "Login" name = "logIn">
        </form>
    </div>
</html>
