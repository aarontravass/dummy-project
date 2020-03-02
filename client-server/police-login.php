<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html" charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/police-login.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/6.6.0/math.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <title>Request Page</title>
        
        
    </head>
    <body>
    <?php
              session_start();

              

              if(isset($_SESSION['id']) and isset($_SESSION['user']) and isset($_SESSION['user_token']) and isset($_SESSION['email']) and $_SESSION['user']==2){
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
                        <li class="nav-item">
                          <a class="nav-link" href="History.php">History</a>
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
    <script>
        /*$(document).ready(function(){
            setInterval(function(){
                $("#requests").html("<div>1. <a class='accreq' href='#'>19°52 34.3N 75°20 35.9E</a> <button class='btn btn-danger' style='padding: 8px; height: 40px; text-align:center; padding-top: 2px;'><a style='color: white; border: 0px;' href='http://www.google.com/maps/place/lat,lng'>Accept</a></button></div>");
            }, 2000);  
        });*/
        setInterval(function()
        {
            //var session ='teh';
            //var ul="send.php?id=".concat(session);
            var ul="send.php";
            $.ajax({
            type: "get",
            url: ul,
            success:function(data)
                {
                    //console.log(data);
                    data=JSON.parse(data);
                    console.log(data);
                    var final="<div>1. <a class='accreq' href='#'>"+data[0]+","+data[1]+"</a> <button class='btn btn-danger' style='padding: 8px; height: 40px; text-align:center; padding-top: 2px;'><a style='color: white; border: 0px;' href='http://www.google.com/maps/place/"+data[0]+","+data[1]+"'>Accept</a></button></div>";
                    $("#requests").html(final);

                }
            });
        }, 900);
        
               

                

    
  </script>
        
       
    </body>
</html>