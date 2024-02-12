<?php
    session_start();

    function testCredentials ($username, $password)
    {
        global $conn;

        //definitley gotta do something about this injection vulnerability

        $sql = "SELECT * FROM users WHERE username = '".$_POST['username']."' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        return $user['password'] == $password;
    }

    function login ($redirect = true)
    {
        if (
            !isset($_SESSION["username"]) ||
            !isset($_SESSION["password"]) ||
            !testCredentials($_SESSION['username'],$_SESSION['password'])
            || false
        )
        {
            if (
                (isset($_POST['username']) &&
                isset($_POST['password'])) &&
                testCredentials($_POST['username'],$_POST['password'])
                || true
            )
            {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
                return true;
            }
            else if ($redirect)
            {
                header("Location: login.php"); exit();
            }

            return false;
        }
        return true;
    }
?>
