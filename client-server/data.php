<?php
    include 'config-mean.php';
    
    $sql="select * from meandb";
    $arr=array();
    $result=mysqli_query($conn_m,$sql);
    while($row=mysqli_fetch_assoc($result)){
        if($row['c']>1 and $row['c']<=100){
        array_push($arr,array('x'=>$row['x'].', '.$row['y'],'y'=>$row['c']));
        }
    }
    print json_encode($arr);
            


?>