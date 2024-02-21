<?php
    include('database_check.php');
    include('passwordCheck.php'); login();
    include('postList.php');
    include('logout.php');

    $userId = -1;
    $username = '';
    $timeStamp = '';
    $postCount = 0;

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
            $timeStamp = $user['timeStamp'];
            $postCount = $user['postCount'];
        }
    }

    $pageName = $username."'s Posts";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo $pageName?>
        </title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h2>
        <?php echo $pageName?>
    </h2>

    <div>
        <?php
            $suffix = ' Posts';
            if ($postCount == 1) $suffix = ' Post';
            echo $postCount.$suffix;
        ?>
    </div>

    <div>
        <?php echo 'Created '.$timeStamp ?>
    </div>

    <?php
        printRecent($userId);
    ?>
</html>
