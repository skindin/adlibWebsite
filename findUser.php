<?php
    include('database_check.php');
    include('passwordCheck.php'); login();
    include('logout.php');


    function getUsers($query = '')
    {
        global $conn;

        if ($query != '')
        {
            $sql = "SELECT * FROM users WHERE username LIKE ? ORDER BY username ASC";
            $stmt = mysqli_prepare($conn, $sql);

            // Check if the statement preparation succeeded
            if ($stmt) {
                // Bind the string parameter
                $search_query = '%' . $query . '%';
                mysqli_stmt_bind_param($stmt, "s", $search_query);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Get the result set
                $result = mysqli_stmt_get_result($stmt);

                // Fetch all rows into an associative array
                $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

                // Close the result set
                mysqli_free_result($result);

                // Close the statement
                mysqli_stmt_close($stmt);

                return $users;
            } else {
                // Return false or handle the error as needed
                return false;
            }
        }
        else{
            $sql = "SELECT * FROM users ORDER BY username ASC";
            return mysqli_query($conn,$sql);
        }
        return false;
    }

    function printUsers ($users)
    {
        foreach ($users as $user)
        {
            $username = $user['username'];
            $postCount = $user['postCount'];
            $timeStamp = $user['timeStamp'];

            echo '<p>';
                echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';
                $suffix = ' Posts';
                if ($postCount == 1) $suffix = ' Post';
                echo $postCount.$suffix;
                echo '<br>Created '.$timeStamp;
            echo '</p>';
        }
    }

    function searchUsers ($query)
    {
        $users = getUsers($query);

        if (!empty($users))
        {
            printUsers($users);
        }
        else
        {
            echo 'No users found...';
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
            <input type="text" name ='query' placeholder = 'Username'>
            <input type="submit" value = "Search">
        </form>

        <?php
            if (isset($_POST['query']))
            {
                $query = $_POST['query'];

                searchUsers($query);
            }
            else
            {
                searchUsers('');
            }
        ?>
    </body>
</html>
