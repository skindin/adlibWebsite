<?php
    //i don't want to have to include the database check here so put it somewhere before this
    include('database_check.php');
    include("passwordCheck.php");

    $loginMsg = '';

    if (isset($_POST['logIn']))
    {
        if (login(false))
        {
            $loginMsg = 'Incorrect information';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Funny Add Lib</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h1>Log In</h1>
    <div>
        <form action="" method = "post">
            <div style="color:red;"><?php echo $loginMsg;?></div>
            <label for="username">Username</label>
            <input type="username" name = "username">
            <br>
            <label for="password">Password</label>
            <input type="password" name = "password">
            <br>
            <input type="submit" value = "Login" name = "logIn">
        </form>
        <br>
        <a href="newUser.php">New User</a>
    </div>
</html>
