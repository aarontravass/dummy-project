<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html" charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/Govt-admin.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/6.6.0/math.min.js"></script>
        <script src="https://kit.fontawesome.com/6e44f9d614.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/chart.bundle.js"></script>
        <link href="css/chart.css" rel="stylesheet">
        <script src="https://maps.googleapis.com/maps/api/js?key= &callback=initMap"
        vasync defer></script>
        <title>Admin Page</title>
    </head>
    <body>
    
        <div class="row row1">
            <div class="col">
                <img src="images/logo.PNG" alt="LOGO" style="width: 200px; height: 100px;">
            </div>
            <?php
              session_start();

              

              if(isset($_SESSION['id']) and isset($_SESSION['user']) and isset($_SESSION['user_token']) and isset($_SESSION['email']) and $_SESSION['user']==4){
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
                    <span class="pageTitle">Detect Accident Prone Zone Areas</span> 
                    <hr>
                </div>
            </div>
            
            <div class="row">
              
              <div class="col-md-6 drop">
                <input type="text" class="form-control" aria-describedby="" placeholder="Enter State">
              </div>
              <div class="col-md-6 drop">
                <input type="text" class="form-control" aria-describedby="" placeholder="Enter City">
              </div>
            </div>
            <div class="row" style="margin-top: 50px;">
              <div class="col-md-12 results">
                <button type="submit" class="btn btn1">Check Results!</button>
              </div>
            </div>
            <div class="row" style="margin-top: 10px;">
              <div class="col-md-12 maps" style="margin-top: 5px;">
              <div id="map" style="height: 400px; width: 500px;">
              </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
              <div class="col-md-12" style="margin-top: 50px; display: flex; justify-content: center;">
              <object data="sample.html" width="1120" height="600" style="border: 2px solid black;">
                <embed src="sample.html" width="1120" height="800"> </embed>
                  Error: Embedded data could not be displayed.
              </object>
              </div>
            </div>
            
            
    </div>     
    <script type="text/javascript">
    

    $(document).ready(function(){
            $.ajax({
                url: "data.php",
                method: "POST",
                success: function(data) {
                
                data=JSON.parse(data);
                var x =[];
    var y =[];
    var coords = [];
                
                
                var res   

                for(var i in data) {
                    coords.push(data[i].x);
                    
                }
                console.log(coords);

                for(var i in coords){
                  res = coords[i].split(", ");
                  x.push(parseFloat(res[0]));
                  y.push(parseFloat(res[1]));
                }
                
                var locations = [];
                for( var i=0; i<coords.length; i++ ) {
                  locations.push( [] );
                }
                for(var i=0;i<coords.length;i++){
                  locations[i].push("");
                  locations[i].push(x[i]);
                  locations[i].push(y[i]);
                  locations[i].push(Math.floor(Math.random() * 10));
                }
      
    
                var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 10,
                  center: new google.maps.LatLng(x[0], y[0]),
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var infowindow = new google.maps.InfoWindow();

                var marker, i;

                for (i = 0; i < locations.length; i++) { 
                  marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                  });

                  google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                      infowindow.setContent(locations[i][0]);
                      infowindow.open(map, marker);
                    }
                  })(marker, i));
                }

                }})})
               

                

    
  </script>

    <div class="footer" style="margin-top: 20px;"> 
      Copyright © 2020 Govt. of India.
All rights reserved. Website Owned & Maintained By : Govt. of India.
    </div>

    
      
    </body>
</html>