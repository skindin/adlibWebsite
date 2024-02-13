<?php
session_start();

function testCredentials ($username, $password)
{
    global $conn;

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password']))
    {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function login ($redirect = true)
{
    return true;

    if (!isset($_SESSION['user']))
    {
        if (isset($_POST['username']) && isset($_POST['password']))
        {
            if (testCredentials($_POST['username'], $_POST['password']))
            {
                return true;
            }
        }
        if ($redirect)
        {
            header("Location: login.php");
            exit();
        }
        return false;
    }
    return true;
}
?>
