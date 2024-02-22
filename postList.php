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
    $postId = $post['postId'];
    $timeStamp = $post['timeStamp'];

    echo '<p id = post'.$postId.'>';
        echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';
        echo $content.'<br>';
        echo '<button onclick="sendVote('.$postId.', 1)">Good</button>';
        echo $goodness;
        echo '<button onclick="sendVote('.$postId.', -1)">Bad</button>';
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
    // Establish WebSocket connection
    var ws = new WebSocket('wss://sheblankmyblanktilliblank.com');

    // Event handler for WebSocket connection establishment
    ws.onopen = function(event)
    {
        console.log('WebSocket connection established.');
    };

    // Event handler for receiving messages from the server
    ws.onmessage = function(event)
    {
        // Process messages received from the server
        console.log('Message received from server:', event.data);
        // Update UI based on received message (e.g., update vote counts)
    };

    // Event handler for WebSocket connection closure
    ws.onclose = function(event)
    {
        console.log('WebSocket connection closed.');
    };

    // Event handler for WebSocket errors
    ws.onerror = function(event)
    {
        console.error('WebSocket error:', event);
    };

    // Function to send vote to server
    function sendVote(postId, voteValue)
    {
        // Construct vote message
        var voteMessage = {
            postId: postId,
            voteValue: voteValue
        };

        // Send vote message to server
        ws.send(JSON.stringify(voteMessage));
    }
</script>
