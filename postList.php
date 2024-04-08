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
    $username = $post['username'];
    $content = $post['content'];
    $goodness = $post['goodness'];
    $postId = $post['postId'];
    $timeStamp = $post['timeStamp'];

    echo '<p id = post'.$postId.'>';
        echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';

        echo $content.'<br>';

        echo '<button class = "voteButton" onclick="sendVote('.$postId.', 1)">Good</button>';

        echo '<span class = voteCount>'. $goodness .'</span>';

        echo '<button class = "voteButton" onclick="sendVote('.$postId.', -1)">Bad</button>';

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

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="customStyle.css">
    </head>
</html>

<script>

    function sendVote(postId, voteValue)
    {
        // Create an XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the PHP file you want to send the data to
        var url = "vote.php";

        // Specify the data you want to send to the PHP file
        var params = "postId=" + postId + "&voteValue=" + voteValue;

        // Open a connection to the server
        xhr.open("POST", url, true);

        // Set the content type header
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Define what happens on successful data submission
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                // Code to execute on successful response from server
                console.log(xhr.responseText);
            }
        }

        // Send the request with the data
        xhr.send(params);


        var container = document.getElementById('post' + postId);

        // Get all the buttons inside the container
        var buttons = container.querySelectorAll('.voteButton');

        // Add click event listener to each button
        buttons.forEach(function(button) {
            this.classList.toggle('active');
        });
    }
</script>
