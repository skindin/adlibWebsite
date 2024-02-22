<?php
    function vote ($postId, $voteValue)
    {
        global $conn;
        $userId = $_SESSION['user']['userId'];

        $sql = "SELECT from goodVotes WHERE postId = '".$postId."' AND userId = '".$userId;
        if (!empty(mysqli_query($conn,$sql)))
        {
            echo 'This user already liked this post';
        }
        else
        {
            $sql = "INSERT INTO goodVotes (postId, userId, voteValue) VALUES ('".$postId."', '".$userId."', '".$voteValue."')";

            if (mysqli_query($conn,$sql))
            {
                echo 'Vote sent successfully';
                return true;
            }
        }

        return false;
    }

    if (isset($_POST['postId']) && isset($_POST['voteValue']))
    {
        $postId = $_POST['postId'];
        $voteValue = $_POST['voteValue'];

        vote($postId, $voteValue);
    }
?>
