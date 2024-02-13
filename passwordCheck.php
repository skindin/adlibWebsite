<?php
session_start();

function testCredentials($username, $password) {
    global $conn;

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        // Handle error
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute statement
    if (!mysqli_stmt_execute($stmt)) {
        // Handle error
        echo "Error: " . mysqli_stmt_error($stmt);
        return false;
    }

    // Get result
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        // Handle error
        echo "Error: " . mysqli_stmt_error($stmt);
        return false;
    }

    // Fetch user data
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        // No user found
        echo 'no users with that username';
        return false;
    }

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Password matches, set session
        $_SESSION['user'] = $user;
        return true;
    } else {
        // Password doesn't match
        echo 'Error: '.$password.' doesnt correspond with '.$user['password'];
        return false;
    }
}


function login ($redirect = true)
{
    // return true;

    if (!isset($_SESSION['user']))//this might cause problems
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
