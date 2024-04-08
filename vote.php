<?php
    include('database_check.php');
    include('passwordCheck.php');

    if (isset($_POST['postId']) && isset($_POST['voteValue'])) {
        // Retrieve the data sent from JavaScript
        $postId = $_POST['postId'];
        $voteValue = $_POST['voteValue'];

        if (isset($_SESSION['user']))
        {
            $userId = $_SESSION['user']['userId'];

            computeVote($postId, $userId, $voteValue);
        }
    }

    function computeVote($postId, $userId, $voteValue)
    {
        global $conn;

        // Check if the user has already voted for this post
        $sql = "SELECT * FROM goodVotes WHERE postId = ? AND userId = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        //probably will have to make some changes in the case that a vote is recorded with a voteValue of 0

        // foreach ($result as $vote)
        // {
        //     echo $vote['voteId'].' ';
        // }

        if (mysqli_num_rows($result) > 0) {

            $vote = mysqli_fetch_assoc($result);

            echo 'Record already existed.';

            if ($vote['voteValue'] != $voteValue)
            {
                $sql = "UPDATE goodVotes SET voteValue = ? WHERE voteId = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $voteValue, $vote['voteId']);
                mysqli_stmt_execute($stmt);
                // $result = mysqli_stmt_store_result($stmt);

                echo 'Set vote value to '.$voteValue;
            }
            else
            {
                echo 'Vote was already set to '.$voteValue;
            }
        } else {
            // Insert the vote into the database
            $sql = "INSERT INTO goodVotes (postId, userId, voteValue) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iii", $postId, $userId, $voteValue);

            if (mysqli_stmt_execute($stmt)) {
                echo 'Vote sent successfully';
                return true;
            } else {
                echo 'Error: ' . mysqli_error($conn);
            }
        }

        return false;
    }

    // if (isset($_POST['postId']) && isset($_POST['userId']) && isset($_POST['voteValue']))
    // {
    //     $postId = $_POST['postId'];
    //     $userId = $_POST['userId'];
    //     $voteValue = $_POST['voteValue'];

    //     $success = vote($postId, $userId, $voteValue);

    //     if ($success )
    //     {
    //         echo json_encode(array("success" => true, "message" => "Vote sent successfully"));
    //     }
    //     else
    //     {
    //         echo json_encode(array("success" => false, "message" => "Failed to send vote"));
    //     }
    // }
?>
