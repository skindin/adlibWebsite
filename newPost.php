<?php
    //i don't want to have to include the database check here so put it somewhere before this
    include('database_check.php');
    include('passwordCheck.php'); login();

    $user = $_SESSION['user'];

    if (isset($_POST['post']))
    {
        $input1 = $_POST['input1'];
        $input2 = $_POST['input2'];
        $input3 = $_POST['input3'];

        $content = 'She '.$input1.' my '.$input2." 'till I ".$input3;

        $sql = "INSERT INTO posts(userId, userName, content)
        VALUES ('".$user['userId']."', '".$user['username']."', '".$content."')";

        mysqli_query($conn, $sql);
        $sql = "UPDATE users SET posts = posts + 1 WHERE 'userId' = '".$user['userId']."'";
        mysqli_query($conn, $sql);
    }
    header("Location: index.php");// exit(); i don't think exiting is necessary here...?
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
            She <input type="text" name = "input1">
            my <input type="text" name = "input2">
            till I <input type="text" name = "input3">
            <div>
                <input type="submit" value = "Post" name = "post">
            </div>
        </form>
    </div>
</html>
