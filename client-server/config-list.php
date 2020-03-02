<?php

$servername = "";
$username = "";
$password = "";
$dbname="list";
$conn_l = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if($conn_l === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>