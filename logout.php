<?php
    echo 'Signed in as '.$_SESSION['user']['username'];
    echo '<form method = "post"><input type="submit" value = "Log Out" name = "logout"></form>';
    echo '<div><a href="findUser.php">Find User</a></div>';

    if (isset($_POST['logout']))
    {
        header("Location: login.php");
        unset($_SESSION['user']);
        unset($_POST['logout']);
    }
?>
