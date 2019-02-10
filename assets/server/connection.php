

<?php
//Establishes a connection with the server
$con = mysqli_connect("localhost","root","","users");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
    echo'Could not connect';
}

?> 