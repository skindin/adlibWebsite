<?php
    include('database_check.php');
    include('passwordCheck.php'); login();
    include('postList.php');
    include('logout.php');

    $userId = -1;
    $username = '';

    if (isset($_GET['user']))
    {
        $username = $_GET['user'];

        $user = getUser($username);
        if (!$user)
        {
            echo '<h1>User '.$username.' does not exist!</h1>';
            exit();
        }
        else
        {
            $userId = $user['userId'];
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Funny Add Lib</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h2>
        <?php echo $username."'s Posts";?>
    </h2>

    <?php
        printRecent($userId);
    ?>
</html>