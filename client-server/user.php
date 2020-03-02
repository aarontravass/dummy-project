<?php
              

              

              if(isset($_SESSION['id']) and isset($_SESSION['user']) and isset($_SESSION['user_token']) and isset($_SESSION['email'])){
                  $email=$_SESSION['email'];
                  $user=$_SESSION['user'];
                  $id=$_SESSION['id'];
                  $result=password_verify($email,$id);
                  
                }
                else{
                  $url = "http://$_SERVER[HTTP_HOST]/login.php";
                  
        
                  header('Location: ' . $url);
                }
                  

      ?>` 