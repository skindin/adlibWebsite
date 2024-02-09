<?php
    $passEntry = '';
    $password = 'lemonWatt';
    $set = true;

    session_start();

    if (isset($_POST['password']))
    {
        $passEntry = $_POST['password'];
        $_SESSION['password'] = $passEntry;
    }
    else if (isset($_SESSION['password']))
    {
        $passEntry = $_SESSION['password'];
    }
    else
    {
        $set = false;
    }

    function redirect ()
    {
        global $passEntry, $password;

        if ($passEntry != $password)
        {
            header("Location: index.php"); exit();
        }
    }

    function passwordMsg ()
    {
        global $set, $passEntry, $password;

        if ($set && $passEntry != $password)
        {
            echo 'Incorrect Password';
        }
    }
?>
