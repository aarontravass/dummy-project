<?php

$servername = "";
$username = "";
$password = "";
$dbname="logindb";
$conn_lo = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if($conn_lo === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>