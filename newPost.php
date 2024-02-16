<?php
    include('database_check.php');
    include('passwordCheck.php');
    login();
    include('logout.php');

    $user = $_SESSION['user'];

    if (isset($_POST['post']))
    {
        $input1 = htmlspecialchars($_POST['input1']); // Sanitize input against JS injection
        $input2 = htmlspecialchars($_POST['input2']); // Sanitize input against JS injection
        $input3 = htmlspecialchars($_POST['input3']); // Sanitize input against JS injection

        // Prepared statement to prevent SQL injection
        $sql = "INSERT INTO posts(userId, username, content) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $user['userId'], $user['username'], $content);

        // Combine input into content variable
        $content = 'She '.$input1.' my '.$input2." till I ".$input3;

        // Execute prepared statement
        mysqli_stmt_execute($stmt);

        // Close statement
        mysqli_stmt_close($stmt);

        // Increment post count with prepared statement
        $sql = "UPDATE users SET postCount = postCount + 1 WHERE userId = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user['userId']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: index.php");
        exit(); // Exit after redirection
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>New Post</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h1>New Post</h1>
    <div>
        <form action="" method = "post">
            She <input type="text" name = "input1">
            my <input type="text" name = "input2">
            till I <input type="text" name = "input3">
            <div>
                <input type="submit" value = "Post" name = "post">
            </div>
        </form>
    </div>
</html>
