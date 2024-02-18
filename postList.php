<?php
// I assume that $conn is a valid mysqli connection object, and it's included in the global scope.

$showCount = 20;

function getPosts($sortType, $sortOrder, $userId = -1)
{
    global $showCount, $conn;

    $where = '';
    if ($userId >= 0) {
        $where = "WHERE userId = ?";
    }

    $sql = "SELECT * FROM posts ".$where." ORDER BY ".$sortType." ".$sortOrder;//." LIMIT ".$showCount;

    if ($userId >= 0)
    {
        $stmt = mysqli_prepare($conn, $sql);

        // Bind the string parameter
        mysqli_stmt_bind_param($stmt, "s", $userId);

        mysqli_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows into an associative array
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Close the statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        return $posts;
    }
    else
    {
        return mysqli_query($conn,$sql);
    }
}

function printPost($post)
{
    $username = htmlspecialchars($post['username']); // Sanitize against potential HTML/JS injection
    $content = htmlspecialchars($post['content']); // Sanitize against potential HTML/JS injection
    $timeStamp = $post['timeStamp'];

    echo '<p>';
        echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';
        echo $content.'<br>';
        echo 'Posted '.$timeStamp;
    echo '</p>';
}

function printPosts($posts)
{
    foreach ($posts as $post)
    {
        printPost($post);
    }
}

function printRecent($userId = -1)
{
    $posts = getPosts('postId', 'DESC', $userId);
    printPosts($posts);
}

function printPopular($userId = -1)
{
    $posts = getPosts('goodness', 'DESC', $userId);
    printPosts($posts);
}
?>
