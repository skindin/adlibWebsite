<?php
include('database_check.php');
include('passwordCheck.php');

// It's recommended to handle database check in 'database_check.php' to ensure consistency across your application.

$usernameMsg = '';
$passwordMsg = '';

if (isset($_POST['createUser'])) {
    $go = true;

    // Prepare SQL statement to select user by username
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_POST['username']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userCount = mysqli_num_rows($result);

    if ($userCount > 0) {
        $usernameMsg = 'That username is taken!';
        $go = false;
    }

    if ($_POST['password'] != $_POST['confirmPassword']) {
        $passwordMsg = "Passwords don't match!";
        $go = false;
    }

    if ($go) {
        // Prepare SQL statement to insert new user
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        // Hash the password before storing it
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $hashedPassword);
        mysqli_stmt_execute($stmt);
        login();
        header("Location: index.php");
        exit(); // Exit after redirection
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Funny Add Lib</title>
        <!-- <link rel="stylesheet" href="https://classless.de/classless.css"> -->
    </head>

    <h1>New User</h1>
    <div>
        <form action="" method = "post">
            <label for="username">New Username</label>
            <input type="username" name = "username">
            <div style="color:red;"><?php echo $usernameMsg;?></div>
            <label for="password">Password</label>
            <input type="password" name = "password">
            <label for="password">Confirm Password</label>
            <input type="password" name = "confirmPassword">
            <div style="color:red;"><?php echo $passwordMsg;?></div>
            <input type="submit" value = "Create Account" name = "createUser">
        </form>
        <a href="login.php">Login with existing user</a>
    </div>
</html>
