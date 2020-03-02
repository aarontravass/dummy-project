<?php

$servername = "";
$username = "";
$password = "";
$dbname="means";
$conn_m = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if($conn_m === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>