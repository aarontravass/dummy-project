<!DOCTYPE html>
<html>

<head>
  <meta content="text/html" charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/6e44f9d614.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <title>Login</title>
  <script>
       $.get('https://www.cloudflare.com/cdn-cgi/trace', function(data) {
          console.log(data);
          var ip=data;
        });
        
    </script>
</head>

<body>
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
            <li class="nav-item active">
              <a class="nav-link" href="#">Log In</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Register</a>
            </li>
          </ul>
        </div>
    </div>
  </div>

  <div class="container">
    <div class="row headrow">
      <div class="col-md-12 td_col" style="text-align: left;">
        <span class="pageTitle">Log In</span>
        <hr>
      </div>
    </div>

    <div class="row">

      <div class="col-md-12 cardcol">
        <div class="card" style="position: relative;">
          <div class="card-header" style="align-content: center; text-align: center;">
            Log In
          </div>
          <div class="card-body">
            <form action="" method="POST">
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name='email'>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name='passwd'>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
              </div>
              <button type="submit" class="btn"  name="submit">Log In</button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

  <?php
  session_start();

  include 'config-login.php';

  
  function checkdata($email, $passwd, $ip,$conn_lo)
  {
    try {

      $sql = "select * from login where email ='" . $email . "';";
      $result = mysqli_query($conn_lo, $sql);

      $row = mysqli_fetch_assoc($result);

      $hash = $row['passwd'];
      
      if (password_verify($passwd, $hash)) {
       
        $arr=array();
        $sql = "SET SQL_SAFE_UPDATES = 0;";
        $result = mysqli_query($conn_lo, $sql);
        $sql = "update login set ip='".$ip."' where email ='" . $email . "';";
        $result = mysqli_query($conn_lo, $sql);
        array_push($arr,$row['user'],$row['user_id']);
        return $arr;
      } else {
        return array('0');
      }
    } catch (Exception $e) {
      echo $e;
    }
  }

  if (isset($_POST['submit'])) 
  {
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
    $ip=$_SERVER['REMOTE_ADDR'];
    
    
    $result = checkdata($email, $passwd, $ip,$conn_lo);
    var_dump($result);
    
    if ($result[0]!='0') 
    {
        $_SESSION['id'] = password_hash($email, PASSWORD_DEFAULT);

        if (isset($_SESSION['id'])) {
            if($result[0]=='1'){
                $userToken = bin2hex(openssl_random_pseudo_bytes(24));
                $_SESSION['user_token'] = $userToken;
                $url = "http://$_SERVER[HTTP_HOST]/hospital-login.php";
                $_SESSION['user'] = $result[0];
                $_SESSION['email'] = $email;
                $_SESSION['user_id']=$result[1];

                header('Location: ' . $url);
            }
            else if($result[0]=='2'){
              $userToken = bin2hex(openssl_random_pseudo_bytes(24));
              $_SESSION['user_token'] = $userToken;
              $url = "http://$_SERVER[HTTP_HOST]/police-login.php";
              $_SESSION['user'] = $result[0];
              $_SESSION['email'] = $email;
              $_SESSION['user_id']=$result[1];

              header('Location: ' . $url);
            }
            else if($result[0]=='3'){
              $userToken = bin2hex(openssl_random_pseudo_bytes(24));
              $_SESSION['user_token'] = $userToken;
              $url = "http://$_SERVER[HTTP_HOST]/fire-login.php";
              $_SESSION['user'] = $result[0];
              $_SESSION['email'] = $email;
              $_SESSION['user_id']=$result[1];

              header('Location: ' . $url);
            }
            else if($result[0]=='4'){
                $userToken = bin2hex(openssl_random_pseudo_bytes(24));
                $_SESSION['user_token'] = $userToken;
                $url = "http://$_SERVER[HTTP_HOST]/Govt-admin.php";
                $_SESSION['user'] = $result[0];
                $_SESSION['email'] = $email;
                $_SESSION['user_id']=$result[1];

                header('Location: ' . $url);
            }
      }
    } 
    else 
    {
      echo "<script type='text/javascript'>alert('Password or Email is wrong');</script>";
    }
  }


  ?>
  <div class="footer">
    Copyright © 2020 Govt. of India.
    All rights reserved. Website Owned & Maintained By : Govt. of India.
  </div>


</body>

</html>