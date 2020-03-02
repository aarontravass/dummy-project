<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html" charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/hospital-login.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <title>Request Page</title>
        <script>
          var arr = [];
          var x = document.getElementById("requests");
          function Queue() {
              this.arr = [];
          }

          function add(item){
              arr.push(item);
          }

          function get(){
              return arr.splice(0,1);
          }

            add(x);

            console.log(arr);
        </script>
        <script>
          $(document).ready(function(){
            setInterval(function(){
              $("#requests").html("<div>1. <a class='accreq' href='https://www.google.com/maps/search/?api=1&query=19.8776,75.3423'>27.2038° N, 77.5011° E</a> <button class='btn btn-danger' style='padding: 8px; height: 40px; text-align:center; padding-top: 2px;'>Accept</button></div>");
            }, 2000);  
          });
        </script>
    </head>
    <body>
    <?php
              session_start();

              

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
        <div class="row row1">
            <div class="col">
                <img src="images/logo.PNG" alt="LOGO" style="width: 200px; height: 100px;">
            </div>
            <div class="col">
                <nav class="navbar navbar-expand-lg navbar-light">
                       
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                      <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                         </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">About</a>
                        </li>
                        <button class="btn btn-danger" onclick="location.href='logout.php'">Log Out</button>
                      </ul>
            </div>
        </div>
        </div>

        <div class="container">
            <div class="row headrow">
                <div class="col-md-12 td_col" style="text-align: left;">
                    <span class="pageTitle">Upcoming Requests...</span> 
                    <hr>
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-md-12 cardcol">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            Accident Requests are displayed below!
                        </div>
                        <div class="card-body" id="requests" style="text-align: center;">
                          Currently, No requests are pending!
                        </div>
                      </div>
                </div>
                
            </div>
    </div>     
    
    <div class="footer">
      Copyright © 2020 Govt. of India.
All rights reserved. Website Owned & Maintained By : Govt. of India.
    </div>
    <script type="text/javascript" src="js/script.js"></script>
        <script src="https://kit.fontawesome.com/6e44f9d614.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>