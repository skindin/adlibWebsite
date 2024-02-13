<?php
// I assume that $conn is a valid mysqli connection object, and it's included in the global scope.

$showCount = 20;

function getPosts($sortType, $sortOrder, $userId = -1)
{
    global $showCount, $conn;

    $where = '';
    $params = [];
    if ($userId >= 0) {
        $where = "WHERE userId = ?";
        $params[] = $userId;
    }

    $sql = "SELECT * FROM posts $where ORDER BY $sortType $sortOrder LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        // Handle error
        return false;
    }

    // Bind parameters
    $bindTypes = str_repeat('s', count($params)) . 'i'; // 's' for string, 'i' for integer
    mysqli_stmt_bind_param($stmt, $bindTypes, ...$params, $showCount);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch all rows
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Free result and close statement
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);

    return $posts;
}

function printPosts($posts)
{
    foreach ($posts as $post)
    {
        $username = htmlspecialchars($post['username']); // Sanitize against potential HTML/JS injection
        $content = htmlspecialchars($post['content']); // Sanitize against potential HTML/JS injection
        $timeStamp = $post['timeStamp'];

        echo '<p>';
            echo $username.'<br>';
            echo $content.'<br>';
            echo 'Posted '.$timeStamp;
        echo '</p>';
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
