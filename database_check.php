<?php
    $conn = mysqli_connect('localhost', 'u222517993_localhost', 'pizzaRoll7', 'u222517993_addLibDatabase');

    if (!$conn)
    {
        echo 'connection error: ' . mysqli_connect_error();
    }
?>
