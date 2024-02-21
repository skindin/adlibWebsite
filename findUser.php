<?php
    include('database_check.php');
    include('passwordCheck.php'); login();
    include('logout.php');


    function getUsers ($query)
    {

        $sql = "SELECT * FROM users WHERE username LIKE '%?%' ORDER BY username ASC";
        $stmt = mysqli_prepare($conn, $sql);

        // Bind the string parameter
        mysqli_stmt_bind_param($stmt, "s", $query);

        mysqli_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows into an associative array
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Close the statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $users;
    }

    function printUsers ($users)
    {
        foreach ($users as $user)
        {
            $username = $user['username'];
            $postCount = $user['postCount'];
            $timeStamp = $user['timeStamp'];

            echo '<p id = post'.$id.'>';
                echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';
                $suffix = ' Posts';
                if ($postCount == 1) $suffix = ' Post';
                echo $postCount.$suffix;
                echo '<br>Created '.$timeStamp;
            echo '</p>';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Find User</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <body>
        <h2>
            Find User
        </h2>

        <form method = 'post'>
            <input type="text" name ='query'>
            <input type="submit" value = "Find User">
        </form>

        <?php
            if (isset($_POST['query']))
            {
                $query = $_POST['query'];

                $users = getUsers($query);

                if ($mysqli_num_rows > 0)
                {
                    printUsers($users);
                }
                else
                {
                    echo 'No users found...';
                }
            }
        ?>
    </body>
</html>
