<!DOCTYPE html>
<?php
session_start();
include "saltLIB.php";
$salt = "boktan";
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
    <script src="https://apis.google.com/js/platform.js" async defer></script>

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
            <li role="presentation"><a href="index.php">Home</a></li>
            <li role="presentation"><a href="#">About</a></li>
            <?php if(isset($_SESSION['user'])) {?>
            <li role="presentation" class="active"><a href="passw.php">Password</a></li>
            <?php } ?>
            <li role="presentation"><a href="logout.php" onclick="signOut();">Logout</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Text twist<?php //echo ":".$_SESSION['user']; ?></h3>
      </div>
      
<?php if(isset($_SESSION['user'])) {?>
  <div class="jumbotron">
    <h1>Change your password!</h1>
    <p class="lead">Super secure!</p>
    <div class="col-lg-6">
    </div>
    <div class="col-lg-6">
      Register
      <form class="form-signin" name='signupFrm' action="passw.php" method="post">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">@</span>
        <input type="password" class="form-control" placeholder="Current Password" aria-describedby="basic-addon1" id="cpassword" name="cpassword">
      </div>
          
      <div class="input-group">
        <span class="input-group-addon" id="passcode1" name="psscode1">P</span>
        <input type="password" class="form-control" placeholder="New Password" aria-describedby="psscode1" id="npasscode1" name="npasscode1">
      </div>
    
      <div class="input-group">
        <span class="input-group-addon" id="passcode2" name="psscode2">P</span>
        <input type="password" class="form-control" placeholder="New Password - retype" aria-describedby="psscode2" id="npasscode2" name="npasscode2">
      </div>
      <button class="btn btn-sm btn-primary pull-right" id="pchange" name="pchange" value="pchange" type="submit">Change</button>
      </form>
    
    </div>
    <div class="col-lg-6 pull-right" id ="signuperr" style="display:none;">
    </div>
    
    <div class="col-lg-12"><br></div>
    <div class="col-lg-12" id="signerr" style="display:none;">        
      <div class="alert alert-danger" role="alert" >
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        <h4><strong>Incorrect</strong> password!</h4>
      </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br>
  </div>
      
      <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>

      <?php } else {
           //header("Location: /textTwist/textGame.php");
      }
      
      
      
      ?>
      


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <?php if(isset($_SESSION['user'])) {?>
    <script src="js/textLIB.js"></script>
    <?php } ?>
  </body>
  
  <script>
    function signin()
    {
        document.getElementById("signerr").style.display="block";
        document.getElementById("usrname").focus()   
    }
    function signup(incele)
    {
    	document.getElementById("signuperr").innerHTML= incele;
      document.getElementById("signuperr").style.display="block";
      document.getElementById("username1").focus();
    }
    
    function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
}

  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }

  </script>
  
  
  <?php



if (isset($_POST['pchange'])) {
  $cpassword = $_POST['cpassword'];
  $password1 = $_POST['npasscode1'];
  $password2 = $_POST['npasscode2'];
  $username = $_SESSION['user'];
  $errmsg = "<ul>";
  
  if ($username == "") 
  { // Checks for blanks.
    //$errmsg = $errmsg."<li class='red'><strong>Username</strong> is missing!</li>";
    //header("Location: /textTwist/textGame.php");
    exit;
  }
    
  //password1 and password2 needs to be same! Do validation!
	if ($password1 != $password2) 
  { // Checks for pass consistency
        $errmsg = $errmsg."<li class='red'><strong>Passwords</strong> does not match!</li>";
  }
  
  
  if(strlen($errmsg) < 5)
  {
    // Should be no error until here
    //$password = md5($password1);
    $cpass = generateSaltedPass($cpassword, $salt,$stretch);
    echo "cpass:".$cpass."<br>";
    //$dbhandle = new PDO("sqlite:texttile.db") or die("Failed to open DB");
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    
    if (!$dbhandle) die ($error);
    
    // Check if the current password matches in DB
    //$query = "SELECT * FROM users WHERE username = :username AND password = :password";
    $query = "SELECT * FROM users_pass WHERE usr_name = :username AND hash = :password";
     
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR, 100);
    $statement->bindParam(':password', $cpass, PDO::PARAM_STR, 100);
    $statement->execute();
    //$arr = $statement->errorInfo();
    //print_r($arr);
    $results = $statement->fetch();
    //print_r($results);
    //echo $results['username'];
    if(isset($results['usr_name'])){
      // There is something in the db. The username/password match up.
       // DO password change
       echo "DONE!";
    
    $npassword = generateSaltedPass($password1, $salt,$stretch);
    
    $query = "UPDATE users_pass SET salt=:salt,stretch=:stretch,hash=:password WHERE usr_name = :username";
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':salt',     $salt, PDO::PARAM_STR);
    $statement->bindParam(':stretch', $stretch, PDO::PARAM_STR);
    $statement->bindParam(':password', $npassword, PDO::PARAM_STR);
    $statement->execute();
    // $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    // $count = $statement->rowCount();
    echo $npassword;
    exit;
    }
    else
    {
      // PASSWORD IS NOT MATCHED WITH USER
      echo "<script type=\"text/javascript\">signin();</script>";
			exit; // Stops the script with an error message.
    }
    
  }
  else
  {
    $errmsg = $errmsg."</ul>";
    echo "<script type=\"text/javascript\">signup(\"$errmsg\");</script>";
    exit();
  }

  

  
}



?>
    
</html>