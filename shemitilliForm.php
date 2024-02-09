<?php
    include('passwordCheck.php'); redirect();
    include('database_check.php');

    $she = '';
    $my = '';
    $i = '';

    if (isset($_GET['id']))
    {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        if (isset($_POST['submit']))
        {
            $she = mysqli_real_escape_string($conn, $_POST['she']);
            $my = mysqli_real_escape_string($conn, $_POST['my']);
            $i = mysqli_real_escape_string($conn, $_POST['I']);

            $sql = "UPDATE `shemytilli`
            SET `she` = '$she', `my` = '$my', `I` = '$i'
            WHERE `shemytilli`.`id` = $id";

            if (mysqli_query($conn,$sql))
            {
                header("Location: addlibList.php"); exit();
            }
            else
            {
                echo 'failed';
            }
        }
        else
        {
            $sql = "SELECT * FROM shemytilli WHERE id = $id";

            $result = mysqli_query($conn,$sql);

            $adlib = mysqli_fetch_assoc($result);

            $she = $adlib['she'];
            $my = $adlib['my'];
            $i = $adlib['I'];

            mysqli_free_result($result);
        }
    }
    else if (isset($_POST['submit']))
    {
        $sql = 'SELECT * FROM shemytilli';

        $she = mysqli_real_escape_string($conn, $_POST['she']);
        $my = mysqli_real_escape_string($conn, $_POST['my']);
        $i = mysqli_real_escape_string($conn, $_POST['I']);

        $sql = "INSERT INTO shemytilli(she,my,i)
        VALUES('$she', '$my', '$i')";

        if (mysqli_query($conn, $sql))
        {
            echo 'added successfully';
        }
        else
        {
            echo 'query error: ' . mysqli_error($conn);
        }
        header("Location: addlibList.php"); exit();
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="https://classless.de/classless.css">
        <title>
            <?php
                if (isset($_GET['id']))
                {
                    echo "She ".htmlspecialchars($adlib['she']).
                    " my ".htmlspecialchars($adlib['my']).
                    " till I ".htmlspecialchars($adlib['I']);
                }
                else
                {
                    echo "New Add Lib";
                }
            ?>
        </title>
    </head>
    <form action="" method = "post">
        She
        <input type="text" name="she" value = <?php echo $she?>>
        my
        <input type="text" name = "my" value = <?php echo $my?>>
        till I
        <input type="text" name = "I" value = <?php echo $i?>>
        <br>
        <input type="submit" name = "submit" value = "Save">
        <a href="addlibList.php">
            Back
        </a>
    </form>
</html>
