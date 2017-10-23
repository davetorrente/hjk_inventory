<?php 
require_once('../includes/load.php');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>
    
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css">

   

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/form-elements.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/main.css">
  </head>

  <body>
    <!-- Top content -->
    <div class="top-content">
      <div class="inner-bg">
        <div class="container">
          <div class="row">
              <div class="col-sm-8 col-sm-offset-2 text">
                  <div style="font-size:100px">
                      <h1><img src="/assets/images/logo_white.png" alt="1410-logo" height="150px"></h1>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <div class="bg-primary text-center">
                <span id="errMsg"><?php echo display_msg($msg); ?></span>
              </div>
              <div class="form-bottom">
                <form id="loginForm" method="post" action="/auth/auth/"> 
                  <div class="form-group">
                      <label class="sr-only" for="username">Username</label>
                      <input type="text" placeholder="Username" name="username" class="form-control checkField" id="username">
                  </div>
                  <div class="form-group">
                      <label class="sr-only" for="password">Password</label>
                      <input type="password" name="password" placeholder="Password" class="form-control checkField" id="password" >
                  </div>
                  <button type="submit" class="btn">Log in!</button>
                </form>
              </div>
            </div>
          </div>    
        </div>
      </div>
    </div>
    <!-- Javascript -->
     <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/jquery.backstretch.min.js"></script>
    <script src="/assets/js/access.js"></script>
    <!--Javascript-->
  </body>
</html>