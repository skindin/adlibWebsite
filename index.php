<?php
    include('passwordCheck.php');
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

    <form action="addlibList.php" method = "post">
        <label for="password">Watts the password?</label>
        <input type="password" name="password">
        <input type="submit" value = "Log In">
        <div style="color:red;"><?php passwordMsg();?></div>
    </form>
</html>
