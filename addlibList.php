<?php

    include('passwordCheck.php'); redirect();
    include('database_check.php');

    if (isset($_GET['id']))
    {
        $id = mysqli_real_escape_string($conn,$_GET['id']);
        $sql = "DELETE FROM `shemytilli` WHERE `shemytilli`.`id` = $id";
        mysqli_query($conn,$sql);
        header("Location: addlibList.php"); exit();
    }

    $sql = 'SELECT id, she, my, I FROM shemytilli';

    $result = mysqli_query($conn, $sql);

    $adlibs = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Funny Add Lib</title>
        <link rel="stylesheet" href="https://classless.de/classless.css">
    </head>

    <h2>
        She _ My _ Till I _
    </h2>

    <ul>
        <?php foreach ($adlibs as $adlib) { ?>
            <li>
                She
                <?php echo htmlspecialchars($adlib['she']) ?>
                 my
                <?php echo htmlspecialchars($adlib['my']) ?>
                 till I
                <?php echo htmlspecialchars($adlib['I']) ?>
                | <a href="shemitilliForm.php?id=<?php echo $adlib['id']?>">Edit</a>

                | <a href="addlibList.php?id=<?php echo $adlib['id']?>">Delete</a>
            </li>
        <?php } ?>
    </ul>

    <form action="shemitilliForm.php" method = "post">
        <input type="submit" value = "Add New">
    </form>
</html>
