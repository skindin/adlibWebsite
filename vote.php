<?php
    function vote($postId, $voteValue)
    {
        global $conn;
        $userId = $_SESSION['user']['userId'];

        // Check if the user has already voted for this post
        $sql = "SELECT * FROM goodVotes WHERE postId = ? AND userId = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

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

        return false;
    }
?>
