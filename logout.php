<?php
    echo 'Signed in as '.$_SESSION['user']['username'];
    echo '<form method = "post"><input type="submit" value = "Log Out" name = "logout"></form>';

    if (isset($_POST['logout']))
    {
        header("Location: login.php");
        unset($_SESSION['user']);
    }
?>
