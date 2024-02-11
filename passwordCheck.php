<?php
    include('database_check.php');

    session_start();

    function testCredentials ($username, $password)
    {
        $sql = 'SELECT * FROM users WHERE username = '$username' LIMIT 1';
        $user = mysqli_query($conn, $sql);
        return $user['password'] == $password;
    }

    function login ()
    {
        if ((!isset($_SESSION("username")) || !isset($_SESSION("password"))) ||)
        {
            if (isset($_POST['username']) && isset($_POST['password']))
            {
                $result = testCredentials($_POST['username'],$_POST['password']);

                if ($result)
                {
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                }
                else
                {
                    header("Location: login.php"); exit();
                }
            }
        }
    }

    function loginMsg ()
    {
        if (!testCredentials($_POST['username'],$_POST['password']))
        {
            echo "Incorrect login information";
        }
    }

    // if (isset($_POST['password']))
    // {
    //     $passEntry = $_POST['password'];
    //     $_SESSION['password'] = $passEntry;
    // }
    // else if (isset($_SESSION['password']))
    // {
    //     $passEntry = $_SESSION['password'];
    // }
    // else
    // {
    //     $set = false;
    // }

    // function redirect ()
    // {
    //     global $passEntry, $password;

    //     if ($passEntry != $password)
    //     {
    //         header("Location: index.php"); exit();
    //     }
    // }

    // function passwordMsg ()
    // {
    //     global $set, $passEntry, $password;

    //     if ($set && $passEntry != $password)
    //     {
    //         echo 'Incorrect Password';
    //     }
    // }
?>
