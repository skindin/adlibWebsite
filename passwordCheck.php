<?php
    session_start();

    function testCredentials ($username, $password)
    {
        global $conn;

        $sql = "SELECT * FROM users WHERE username = '".$_POST['username']."' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        return $user['password'] == $password;
    }

    function login ($redirect = true)
    {
        if (
            (!isset($_SESSION["username"]) || !isset($_SESSION["password"])) ||
            !testCredentials($_SESSION['username'],$_SESSION['password'])
        )
        {
            if (isset($_POST['username']) && isset($_POST['password']))
            {
                $result = testCredentials($_POST['username'],$_POST['password']);

                if ($result)
                {
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    return true;
                }
            }

            if ($redirect)
            {
                header("Location: login.php"); exit();
            }

            return false;
        }
        return true;
    }

    // function  ()
    // {
    //     if ((isset($_POST["username"]) || isset($_POST["password"])))
    //     {
    //         return testCredentials($_POST['username'],$_POST['password']);
    //     }
    // }

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
