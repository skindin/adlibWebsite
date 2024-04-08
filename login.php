<?php
    //i don't want to have to include the database check here so put it somewhere before this
    include('database_check.php');
    include("passwordCheck.php");

    $loginMsg = '';

    if (isset($_POST['logIn']))
    {
        if (!login(false))
        {
            $loginMsg = 'Incorrect information';
        }
        else
        {
            header("Location: userPage.php"); exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h1>Log In</h1>
    <div>
        <form action="" method = "post">
            <label for="username">Username</label>
            <input type="username" name = "username">
            <label for="password">Password</label>
            <input type="password" name = "password">
            <div style="color:red;"><?php echo $loginMsg;?></div>
            <input type="submit" value = "Login" name = "logIn">
        </form>
        <a href="newUser.php">New User</a>
    </div>
</html>
