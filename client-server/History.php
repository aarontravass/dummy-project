<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html" charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/History.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <title>History</title>
        <script>
          var urlParams;
          (window.onpopstate = function () {
              var match,
              pl     = /\+/g,  
              search = /([^&=]+)=?([^&]*)/g,
              decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
              query  = window.location.search.substring(1);

              urlParams = {};
              while (match = search.exec(query))
              urlParams[decode(match[1])] = decode(match[2]);
          })();
          
          

          $("button").each(function(i) {
            $(this).find('button').attr('name', urlParams['page'] + 10);
          });
          $("button").each(function(i) {
            $(this).find('button').attr('name', urlParams['page']<=10?0:urlParams['page'] - 10);
          });


        </script>

        <style>
          .btn1{
              border-color: #F7C19A;
              font-family: 'Roboto', sans-serif;
              background-color: white;
              
              border-width: 5px;
              text-shadow: x-offset y-offset blur color;
              box-shadow: 0px 6px 0px #F7C19A;
          }

          .btn1:hover{
              background-color: #F7C19A;
          }

          .pre{
            display: flex;
            justify-content: left;
          }
          .next{
            display: flex;
            justify-content: flex-end;
          }
        </style>
    </head>
    <body>
    <?php
              session_start();

              include 'config-acc.php';
              include 'config-list.php';

              function getdata($page,$conn_a,$conn_l){
                  try{
                      
                      $sql="select * from accidentdb where id ='".$page."';";
                      $result=mysqli_query($conn_a,$sql);
                      
                      
                      
                      
                      
                      if(mysqli_num_rows($result)>0)
                      {
                          $arr=array();
                          $row = $result->fetch_assoc();
                          //var_dump($row);
                          array_push($arr,$row['longitude'],$row['latitude'],$row['hospital_id'],$row['policestation_id'],$row['firestation_id']);
                          
                          $sql="select * from listdb where user ='".$row['hospital_id']."';";
                          $result=mysqli_query($conn_l,$sql);
                          $hos = mysqli_fetch_assoc($result);

                          $sql="select * from listdb where user ='".$row['firestation_id']."';";
                          $result=mysqli_query($conn_l,$sql);
                          $fire = mysqli_fetch_assoc($result);
                          $fire=$fire['name'];
                          

                          $sql="select * from listdb where user ='".$row['policestation_id']."';";
                          $result=mysqli_query($conn_l,$sql);
                          $pol = mysqli_fetch_assoc($result);

                          $arr[2]=$hos['name'];
                          $arr[4]=$pol['name'];
                          $arr[3]=$fire;

                          return $arr;


                          
                          
                      }
                      else{
                          return 0;
                      }
                      
                  }
                  catch(Exception $e){
                      echo $e;
                  }
              }

              if(isset($_SESSION['id']) and isset($_SESSION['user']) and isset($_SESSION['user_token']) and isset($_SESSION['email'])){
                  $email=$_SESSION['email'];
                  $user=$_SESSION['user'];
                  $id=$_SESSION['id'];
                  echo "<div class='row row1'>
                  <div class='col'>
                      <img src='images/logo.PNG' alt='LOGO' style='width: 200px; height: 100px;'>
                  </div>
                  <div class='col'>
                      <nav class='navbar navbar-expand-lg navbar-light'>
                             
                          <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                            <span class='navbar-toggler-icon'></span>
                          </button>
                          <div class='collapse navbar-collapse' id='navbarNav'>
                            <ul class='nav navbar-nav ml-auto'>
                              <li class='nav-item'>
                                <a class='nav-link' href='#'>Home <span class='sr-only'>(current)</span></a>
                               </li>
                              <li class='nav-item'>
                                <a class='nav-link' href='#'>About</a>
                              </li>
                              <li class='nav-item active'>
                                <a class='nav-link' href='History.php'>History</a>
                              </li>
                              <button class='btn btn-danger'><a href='logout.php' style='border: 0px; color: white;'>Log Out</a></button>
                            </ul>
                  </div>
              </div>
              </div>
                  <div class='container' style='margin-top: 50px; margin-bottom: 0px;'>
                    <form action='' method='GET'>
                      <div class='row'>
                        <div class='col-md-6 prev'>
                          <button class='btn btn1' name='0'>Previous</button>
                        </div>
                        <div class='col-md-6 next'>
                          <button class='btn btn1' name='0'>Next</button>
                        </div>
                      </div>
                    </form>
                  </div>
                
                            
                            
                          
                      
                  </div>
          </div> ";
                  $result=password_verify($email,$id);
                  if($result){
                      $page=0;
                      if(isset($_GET['page'])){
                        $page=$_GET['page'];
                      }
                      echo "<div class='container db'><div class='row headrow'><div class='col-md-12 td_col' style='text-align: left;'><span class='pageTitle'>History</span>";
                      echo "<hr></div></div><div class='row'><div class='col-md-12 cardcol'><table class='table table-striped w-auto'><!--Table head--><thead><tr><th>#</th><th>Location</th><th>Hospital</th><th>Fire Station</th><th>Police Station</th></tr></thead>";
                      echo "<tbody>";
                      for($i=$page;$i<$page+10;$i++){
                        $arr=getdata($i+1,$conn_a,$conn_l);
                        if($arr==0){
                          break;
                        }
                        if($i%2){
                          echo "<tr class='table-info'><th scope='row'>".($i+1)."</th><td>".$arr[0].", ".$arr[1]."</td>";
                          echo "<td>".$arr[2]."</td><td>".$arr[3]."</td><td>".$arr[4]."</td>";
                          echo "</tr>";
                        }
                        else{
                          echo "<tr><th scope='row'>".($i+1)."</th><td>".$arr[0].", ".$arr[1]."</td>";
                          echo "<td>".$arr[2]."</td><td>".$arr[3]."</td><td>".$arr[4]."</td>";
                          echo "</tr>";
                        }
                      }
                      echo "</tbody></table></div>";
                          
                    }
                }
                  

      ?>`
        
                    
        
          
    <div class="footer">
      Copyright © 2020 Govt. of India.
All rights reserved. Website Owned & Maintained By : Govt. of India.
    </div>
        <script src="https://kit.fontawesome.com/6e44f9d614.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>




