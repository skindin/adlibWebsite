<?php
    include('database_check.php');
    include("passwordCheck.php");

    //i don't want to have to include the database check here so put it somewhere before this
    $usernameMsg = '';
    $passwordMsg = '';
    if (isset($_POST['createUser']))
    {
        $go = true;

        $sql = "SELECT * FROM users WHERE username = '".$_POST['username']."' LIMIT 1";
        $result = mysqli_query($conn,$sql);
        $userCount = mysqli_num_rows($result);

        if ($userCount>0)
        {
            $usernameMsg = 'That username is taken!';
            $go = false;
        }

        if ($_POST['password'] != $_POST['confirmPassword'])
        {
            $passwordMsg = "Passwords don't match!";
            $go = false;
        }

        if ($go)
        {
            $sql = "INSERT INTO user (username, password) VALUES ('".$_POST['username']."', '".$_POST['password']."')";
            $result = mysqli_query($conn, $sql);
            header("Location: index.php");
        }
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
            <label for="username">New Username</label>
            <input type="username" name = "username">
            <br>
            <?php print $usernameMsg; ?>
            <br>
            <label for="password">Password</label>
            <input type="password" name = "password">
            <br>
            <label for="password">Confirm Password</label>
            <input type="password" name = "confirmPassword">
            <br>
            <?php print $passwordMsg; ?>
            <br>
            <input type="submit" value = "Create Account" name = "createUser">
        </form>
    </div>
</html>
