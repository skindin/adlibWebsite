<?php
    session_start();

    function testCredentials ($username, $password)
    {
        global $conn;

        //definitley gotta do something about this injection vulnerability

        $sql = "SELECT * FROM users WHERE username = '".$username."' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        if ($user['password'] == $password)
        {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    function login ($redirect = true)
    {
        if (!isset($_SESSION['user']))
        {
            // echo 'session credentials were empty or incorrect! ';

            if (
                (isset($_POST['username']) &&
                isset($_POST['password'])) &&
                testCredentials($_POST['username'],$_POST['password'])
            )
            {
                // $_SESSION['user']['username'] = $_POST['username'];
                // $_SESSION['user']['password'] = $_POST['password'];
                // echo 'session credentials set! ';
                return true;
            }
            else if ($redirect)
            {
                header("Location: login.php"); exit();
            }
            // echo 'new credentials are also incorrect!';

            return false;
        }
        // else echo 'session credentials correct! ';
        return true;
    }
?>
