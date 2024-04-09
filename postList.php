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
        // mysqli_close($conn);

        return $posts;
    }
    else
    {
        return mysqli_query($conn,$sql);
    }
}

function printPost($post)
{
    global $conn;

    $username = $post['username'];
    $content = $post['content'];
    $goodness = $post['goodness'];
    $postId = $post['postId'];
    $timeStamp = $post['timeStamp'];

    $sql = "SELECT * FROM goodVotes WHERE postId = ? AND userId = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $postId, $_SESSION['user']['userId']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $voteValue = 0;
    if (mysqli_num_rows($result) > 0)
    {
        $voteValue = mysqli_fetch_assoc($result)['voteValue'];
    }

    echo '<p id = post'.$postId.'>';
        echo "<a href = 'userPage.php?user=".$username."'>".$username.'</a><br>';

        echo $content.'<br>';

        echo '<button class = "voteButton goodVote';
        if ($voteValue > 0) echo ' selected';
        echo '" onclick="sendVote('.$postId.', 1)">Good</button>';

        echo '<span class = "voteCount">'. $goodness .'</span>';

        echo '<button class = "voteButton badVote';
        if ($voteValue < 0) echo ' selected';
        echo '" onclick="sendVote('.$postId.', -1)">Bad</button>';

        echo '<br>Posted '.$timeStamp;
    echo '</p>';
}

function printPosts($posts)
{
    echo '<style> .selected {
        background-color: rgb(34, 189, 255);
        color: white; /* Optional: Change text color for better contrast */
    }</style>';

    foreach ($posts as $post)
    {
        printPost($post);
    }
}

function printOrder ($userId = -1)
{
    if (isset($_GET['popular']))
        printPopular($userId);
    else
        printRecent($userId);
}

function printRecent($userId = -1)
{
    echo 'Sorting Recent';
    echo '<button><a href = "userPage.php?';
    if (isset($_GET['user'])) 'user="'.$_GET['user']."&";
    echo "popular=Sort+Popular'>Order Popular</a></button>";

    $posts = getPosts('postId', 'DESC', $userId);
    printPosts($posts);
}

function printPopular($userId = -1)
{
    echo 'Sorting Popular';
    echo '<button><a href = "userPage.php?';
    if (isset($_GET['user'])) 'user="'.$_GET['user']."&";
    echo "popular=Sort+Recent'>Order Recent</a></button>";

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

        var voteCoeff = 1;

        // Add click event listener to each button
        buttons.forEach(function(button) {
            var goodButton = button.classList.contains('goodVote');
            var goodVote = voteValue > 0;
            var clicking = goodButton == goodVote;

            if (clicking)
            {
                if (button.classList.contains('selected'))
                    voteCoeff = -1;

                button.classList.toggle('selected');
            }
            else if(button.classList.contains('selected'))
            {
                button.classList.remove('selected');
                voteCoeff = 2;
            }
        });

        var voteCounter = container.querySelector('.voteCount');

        var currentVotes = parseInt(voteCounter.textContent);

        voteCounter.textContent = currentVotes + (voteValue * voteCoeff);
    }
</script>
