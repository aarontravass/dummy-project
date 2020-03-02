<?php
    
    
    if(!empty($_POST['x']) && !empty($_POST['y']) && !empty($_POST['id']))
    {
        $arr=array();
        array_push($arr, $_POST['x'], $_POST['y'],$_POST['id']);
        $fp = fopen("/media/json/".$_POST['id'].'.json', 'w');
        
        fwrite($fp, json_encode($arr));
        fclose($fp);

    
        
    }
    
        
    


?>
    
