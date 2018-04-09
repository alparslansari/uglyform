<!DOCTYPE html>
<?php
session_start();
include "saltLIB.php";
$salt = "<secret>";
$stretch = 5000;
?>





<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>An awesome game ...</title>

    <!-- Bootstrap -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/jumbotron-narrow.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      <style>
      .red {
        color: #d14;
      }
      </style>
  
  </head>
  <body>

      <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Home</a></li>
            <li role="presentation"><a href="#">About</a></li>
            <?php if(isset($_SESSION['user'])) {?>
            <li role="presentation"><a href="passw.php">Password</a></li>
            <?php } ?>
            <li role="presentation"><a href="logout.php" onclick="signOut();">Logout</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">UgLy Forum</h3>
      </div>
      
      <?php if(!isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit;
      } else { 
      
      // This is where user in SESSION
      ?>
      <div class="jumbotron">
        <h1>Welcome, <?php echo $_SESSION['user']; ?></h1>
        <p class="lead">Your rank is </p>
        <!-- <h3>Message to be:</h3> -->
      </div>
      
      <div class="row marketing">
        
        

      <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>
      </div>
      <?php } ?>
      


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <?php if(isset($_SESSION['user'])) {?>
    
    <?php } ?>
  </body>
  

    
</html>