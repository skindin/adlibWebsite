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

    $sql = "SELECT * FROM posts ".$where." ORDER BY ".$sortType." ".$sortOrder." LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        // Handle error
        return false;
    }

    // Ensure $params is not empty
    if (!empty($params)) {
        // Create bind types string
        $bindTypes = str_repeat('s', count($params) - 1) . 'i'; // 's' for string, 'i' for integer

        // Bind parameters
        mysqli_stmt_bind_param($stmt, $bindTypes, ...$params);
    } else {
        // If $params is empty, bind only the integer parameter
        mysqli_stmt_bind_param($stmt, 'i', $showCount);
    }


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
            echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';
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
