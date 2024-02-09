<?php
    $conn = mysqli_connect('localhost', 'root', 'pizzaRoll7', 'addLibDatabase');

    if (!$conn)
    {
        echo 'connection error: ' . mysqli_connect_error();
    }
?>
