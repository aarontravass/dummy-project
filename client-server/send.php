<?php

session_start();
include 'config-list.php';
include 'config-acc.php';

$servername = "";
$username = "";
$password = "";
$dbname="temp";
$conn_t = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if($conn_t === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if(isset($_SESSION['id']) and isset($_SESSION['user']) and isset($_SESSION['user_token']) and isset($_SESSION['email'])){
    $val=$_SESSION['user_id'];
    //$val='teh';
    //var_dump($val);



    $sql="select accident_id from temptable where emergency_id='".$val."';";
    $result = mysqli_query($conn_t, $sql);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        //var_dump($row);



        $acc_id=$row['accident_id'];
        $sql="select * from accidentdb where accident_id='".$acc_id."';";
        $result = mysqli_query($conn_a, $sql);
        $row = mysqli_fetch_assoc($result);


        $arr=array();

        array_push($arr,$row['latitude'],$row['longitude']);


        $sql="SET SQL_SAFE_UPDATES = 0;";
        $result = mysqli_query($conn_a, $sql);


        $sql="update accidentdb set policestation_id='".$val."' where accident_id='".$acc_id."';";
        $result = mysqli_query($conn_a, $sql);


        $sql="delete from temptable where accident_id='".$acc_id."';";
        $result = mysqli_query($conn_t, $sql);


        
        
        print json_encode($arr);
    }
}

?>