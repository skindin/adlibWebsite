<?php
    include('database_check.php');
    include('passwordCheck.php');

    if (isset($_POST['postId']) && isset($_POST['voteValue'])) {
        // Retrieve the data sent from JavaScript
        $postId = $_POST['postId'];
        $voteValue = $_POST['voteValue'];
        $userId = $_POST['userId'];
        $passHash = $_POST['passHash'];

        // Now you can use the data as needed
        computeVote($postId, $userId, $passHash, $voteValue);
    }

    function computeVote($postId, $userId, $passwordHash, $voteValue)
    {
        global $conn;

        if (testPassWithId($userId, $passwordHash))
        {
            // Check if the user has already voted for this post
            $sql = "SELECT * FROM goodVotes WHERE postId = ? AND userId = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            //probably will have to make some changes in the case that a vote is recorded with a voteValue of 0

            if (mysqli_stmt_num_rows($stmt) > 0) {
                echo 'This user already liked this post';
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
        }
        else
        {
            echo "Password doesn't match user Id";
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
