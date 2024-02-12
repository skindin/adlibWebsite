<?php
    //i don't want to have to include the database check here so put it somewhere before this
    $showCount = 20;

    function getPosts($sortType, $sortOrder, $userId = -1)
    {
        global $showCount, $conn;

        $where ='';
        if ($userId >= 0) //gonna have to do a lot of filtering here
        {
            $where = "WHERE userId = '".$userId."' ";
        }
        $sql = "SELECT * FROM posts ".$where." ORDER BY ".$sortType." ".$sortOrder." LIMIT ".$showCount;

        $result = mysqli_query($conn, $sql);
        return $result;
    }

    function printPosts($posts)
    {
        foreach ($posts as $post)
        {
            $username = $post['username'];
            $content = $post['content'];
            $timeStamp = $post['timeStamp'];

            echo '<p>';
                echo $username.'<br>';//gonna have to do that character filter thing here
                echo $content.'<br>';
                echo 'Posted '.$timeStamp;
            echo '</p>';
        }
    }

    function printRecent ($userId = -1)
    {
        $posts = getPosts('postId','DESC',$userId);
        printPosts($posts);
    }

    function printPopular ($userId = -1)
    {
        $posts = getPosts('goodness','DESC',$userId);
    }
?>
