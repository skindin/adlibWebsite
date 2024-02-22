<?php
// I assume that $conn is a valid mysqli connection object, and it's included in the global scope.
include('vote.php');

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
    $username = $post['username'];
    $content = $post['content'];
    $goodness = $post['goodness'];
    $id = $post['postId'];
    $timeStamp = $post['timeStamp'];

    echo '<p id = post'.$id.'>';
        echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';
        echo $content.'<br>';
        echo '<button onclick="sendVote('.$id.', 1)">Good</button>';
        echo $goodness;
        echo '<button onclick="sendVote('.$id.', -1)">Bad</button>';
        echo '<br>Posted '.$timeStamp;
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

<script>
    function sendVote (postId, voteValue)
    {
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open('POST', 'vote.php', true);

        // Set the Content-Type header if you're sending data in the request body
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Set up a callback function to handle the response
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful
                console.log('PHP function executed successfully');
                console.log('Response:', xhr.responseText);
            } else {
                // Request failed
                console.error('Failed to execute PHP function:', xhr.status, xhr.statusText);
            }
        };

        // Optionally, you can send data in the request body
        var postData = 'postId=' + postId + '&voteValue=' + voteValue;
        xhr.send(postData);

        console.log('function ran: ' + 'postId = ' + postId + ' and vote value = ' + voteValue);
    }
</script>
