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

<!-- Registration -->
<?php if(!isset($_SESSION['user'])) {?>
  <div class="jumbotron">
    <h1>Welcome to UgLy Forum</h1>
    <p class="lead">This forum is so uGlY!.</p>
    <div class="col-lg-6">
      Sign in
      <form class="form-signin" name='signinFrm' action="index.php" method="post">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon" id="usrname" name="usrname">@</span>
            <input type="text" class="form-control" placeholder="Username" aria-describedby="usrname" id="username" name="username">
          </div>
          
          <div class="input-group">
            <span class="input-group-addon" id="psscode" name="psscode">P</span>
            <input type="password" class="form-control" placeholder="Password" aria-describedby="psscode" id="passcode" name="passcode">
          </div>
          <button class="btn btn-sm btn-success pull-right" id="signin" name="signin" value="signin" type="submit">Sign-in</button>
        </div>
      </form>
    </div>
    <div class="col-lg-6">
      Register
      <form class="form-signin" name='signupFrm' id='signupFrm' action="index.php" method="post">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">@</span>
        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" id="username1" name="username1">
      </div>
          
      <div class="input-group">
        <span class="input-group-addon" id="passcode1" name="psscode1">P</span>
        <input type="password" class="form-control" placeholder="Password" aria-describedby="psscode1" id="passcode1" name="passcode1">
      </div>
    
      <div class="input-group">
        <span class="input-group-addon" id="passcode2" name="psscode2">P</span>
        <input type="password" class="form-control" placeholder="Password - retype" aria-describedby="psscode2" id="passcode2" name="passcode2">
      </div>
      <button class="btn btn-sm btn-primary pull-right" id="signup" name="signup" value="signup" type="submit">Sign-up</button>
      
      </form>
    
    </div>
    <div class="col-lg-6 pull-right" id ="signuperr" style="display:none;">
    </div>
    
    <div class="col-lg-12"><br></div>
    <div class="col-lg-12" id="signerr" style="display:none;">        
      <div class="alert alert-danger" role="alert" >
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        <h4><strong>Incorrect</strong> username or password!</h4>
      </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br>
  </div>
      
      <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>
      
      
      
      
      
      
      
      
      

      <?php } else {
      // This is where user in SESSION -- DISPLAY TOPICS
      
      ?>
      <div class="jumbotron">
        <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
        <p class="lead">You rank is <?php echo $_SESSION['rank']; ?></p>
        <!-- <h3>Message to be:</h3> -->
        <?php
        if($_SESSION['rank']==0)
        {
          echo '<span class="pull-left"><i class="glyphicon glyphicon-cog"></i> <a href="manage.php">Manage</a></span>';
        }
        
        ?>
        <button class="pull-right add" data-target="#add" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Create new Topic</button>
      </div>
      
      <div class="row marketing">
        <div class="col-lg-12">
          
          <table id="topics">
            <thead>
              <th>Rank</th>
              <th style="text-align: center;">Forum Topics</th>
              <th style="text-align: center;">Manage</th>
            </thead>
            <tbody>
              
            </tbody>
          </table>
             
  
        </div>
        





      </div>
            <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>
      
              <!-- Modal -->
<div id="lock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="tplock.php" method="post" id="flock" name="flock">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lock Confirmation:</h4>
      </div>
      <div class="modal-body">
        <p id="lmsg">Are you sure to lock this topic?</p>
        <input type="hidden" id="tid" name="tid">
        <input type="hidden" id="tlock" name="tlock">
      </div>
      <div class="modal-footer">
        <button type="submit" id="mlock" name="mlock" class="btn btn-primary" data-dismiss="modal">OK <i class="glyphicon glyphicon-lock"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>
      
        <!-- Modal -->
<div id="delete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="tpdelete.php" method="post" id="fdelete" name="fdelete">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Confirmation:</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure to delete this topic?</p>
        <input type="hidden" id="tid" name="tid">
        
      </div>
      <div class="modal-footer">
        <button type="submit" id="mdelete" name="mdelete" class="btn btn-danger" data-dismiss="modal">Delete <i class="glyphicon glyphicon-trash"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>

  <!-- EDIT Modal -->
<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="tpedit.php" method="post" id="fedit" name="fedit">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Confirmation:</h4>
      </div>
      <div class="modal-body">
        <p>Make your changes and click 'Save' if you wish the save the changes!</p>
        <div><b>Topic Title: </b><input type="text" id="editTitle" name="editTitle" maxlength="100" size="50"></div>
        <input type="hidden" id="tid" name="tid" value="<?=$tp_id?>">
        
      </div>
      <div class="modal-footer">
        <button type="submit" id="medit" name="medit" class="btn btn-primary" data-dismiss="modal">Save <i class="glyphicon glyphicon-pencil"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>

  <!-- ADD Modal -->
<div id="add" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="tpadd.php" method="post" id="madd" name="madd">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create a new message:</h4>
      </div>
      <div class="modal-body">
        <p>Make your changes and click 'Save' if you wish the save the changes!</p>
         <div>
           <b>Topic Title: </b><input type="text" id="toptit" name="toptit" maxlength="200" size="50">
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" id="badd" name="badd" class="btn btn-primary" data-dismiss="modal">Save <i class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>


      
      <?php } ?>
      


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
  
    <?php if(isset($_SESSION['user'])) {?>
    <script>
    <?php
        $rank = $_SESSION['rank'];
        $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    
        if (!$dbhandle) die ($error);
        $query = "SELECT * FROM topic_tbl WHERE usr_rank >= :rank AND tp_delete is null";
        //echo $query;
        //this next line could actually be used to provide user_given input to the query to 
        //avoid SQL injection attacks
        $statement = $dbhandle->prepare($query);
        $statement->bindParam(':rank', $rank, PDO::PARAM_INT);
        $statement->execute();

        
        while($results = $statement->fetch())
        {
            $myStr = new stdClass();
            $myStr->id = $results['tp_id'];
            $myStr->title = $results['tp_title'];
            $myStr->rank = $results['usr_rank'];
            $myStr->lock = $results['tp_lock'];
            $myObj[] = $myStr;
        }
        
        //echo json_encode($myObj);
            
        
        ?>
        var data = <?=json_encode($myObj)?>;
        
        if (typeof data[0].title === 'undefined' || !data[0].title) {
            $('#topics tr:last').after('<tr><td>*</td><td>Say Nothing!</td><td>-</td></tr>');
          }
          else
          {
            /* do things */ 
            for (i = 0; i < data.length; i++) {
              var lockinf = "";
              if(data[i].lock=="0") lockinf = "[Open]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              if(data[i].lock=="1") lockinf = "[Locked]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              
              var edit = '<span class="pull-right"><button class="bdel" data-target="#delete" data-toggle="modal" data-id="'+data[i].id+'"><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;&nbsp;<button class="bedt" data-target="#edit" data-toggle="modal" data-id="'+data[i].id+'"><i class="glyphicon glyphicon-pencil"></i></button>';
              edit = edit + '&nbsp;&nbsp;&nbsp;<button class="block" data-target="#lock" data-toggle="modal" data-id="'+data[i].id+'" data-lock="'+ data[i].lock +'"><i class="glyphicon glyphicon-lock"></i></button></span>';
              var td1 = '<td>'+lockinf+'</td>';
              var td2 = '<td><a href="view.php?id='+data[i].id+'&topic='+data[i].title+'"><span id="toptit'+data[i].id+'">'+data[i].title+'</span></a></td>';
              var td3 = '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+edit+'</td>';
              // '<i class="glyphicon glyphicon-trash"></i><i class="glyphicon glyphicon-pencil"></i>'
              $('#topics tr:last').after('<tr>'+td1+td2+td3+ '</tr>');
            }
          }
    
    
    
    
      $(document).ready(function() {
        
        //
        
      $(".block").click(function() {
       var id = $(this).attr('data-id');
       $(".modal-body #tid").val(id);
       var lock = $(this).attr('data-lock')
       $(".modal-body #tlock").val(lock);
       if(lock == 0)
          $(".modal-body #lmsg").text("Are you sure to lock this topic?");
       if(lock == 1)
          $(".modal-body #lmsg").text("Are you sure to unlock this topic?");  
       
      });
        
      
      $(".bdel").click(function() {
       var id = $(this).attr('data-id');
       $(".modal-body #tid").val(id);
       //alert("aaa");
      });  
        
         $( ".bedt" ).click(function() {
            var id = $(this).attr('data-id');
            $(".modal-body #tid").val(id);
            var title = $("#toptit"+id).text();
            $(".modal-body #editTitle").val(title);

         });
   
    $( "#medit" ).click(function() {
        $("#fedit" ).submit();
     });
     
     $( "#mlock" ).click(function() {
        $("#flock" ).submit();
     });
        
      $( "#mdelete" ).click(function() {
        $("#fdelete" ).submit();
      });
      
         $( "#badd" ).click(function() {
        $("#madd" ).submit();
   });
        
      });
    </script>
    
    
    <?php } else {?>
    
    
  <script>
    function signin()
    {
        document.getElementById("signerr").style.display="block";
        document.getElementById("usrname").focus();
    }
    function signup(incele)
    {
    	document.getElementById("signuperr").innerHTML= incele;
      document.getElementById("signuperr").style.display="block";
      document.getElementById("username1").focus();
    }
    
  $(document).ready(function( )
  {
    // initialize table load
       jQuery(function ($) {
       
          $("#signupFrm").validate({
           rules: {
               passcode1: { 
                 required: true,
                    minlength: 8,
                    maxlength: 90,

               }, 
               passcode2: {
                    required: true,
                    //equalTo: "#passcode1",
                    minlength: 8,
                    maxlength: 90
               }


           },
     messages:{
         passcode1: { 
                 required:"the password is required"

               },
        passcode2: { 
                 required:"the password 2 is required"
                 //,equalTo: "Passwords does not match!"
               }
     }

  });
  
       });
     


    });
  

  </script>
  
  <?php }?>
  
  <?php


if (isset($_POST['signin'])) {
    //print_r($_POST);

    $username = $_POST['username'];
	  //$password = md5($_POST['passcode']); // Encrypts the password.
	  $password = generateSaltedPass($_POST['passcode'], $salt,$stretch);
	  
    //cho "-".$password."-";
    
    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    //$dbhandle = new PDO("sqlite:texttile.db") or die("Failed to open DB");
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    
    if (!$dbhandle) die ($error);
    $query = "SELECT * FROM users_pass WHERE usr_name = :username AND hash = :password";
    //echo $query;
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR, 100);
    $statement->bindParam(':password', $password, PDO::PARAM_STR, 100);
    $statement->execute();
    //$arr = $statement->errorInfo();
    //print_r($arr);
    $results = $statement->fetch();
    //print_r($results);
    //echo $results['username'];
    if(isset($results['usr_name'])){
      // assign rank
      $query = "SELECT * FROM users_rank WHERE usr_name = :username";
      $statement = $dbhandle->prepare($query);
      $statement->bindParam(':username', $username, PDO::PARAM_STR, 100);
      $statement->execute();
      $results = $statement->fetch();
      if(isset($results['usr_rank'])){
        $_SESSION['rank']=$results['usr_rank'];
      }
      
      // There is something in the db. The username/password match up.
       $_SESSION['user']=$username;
       echo "<script>window.location.replace('index.php');</script>";
       //header("Location: /index.php");
       exit;
    }
    else
    {
      // PASSWORD IS NOT MATCHED WITH USER
      echo "<script type=\"text/javascript\">signin();</script>";
			exit; // Stops the script with an error message.
    }
    
}

if (isset($_POST['signup'])) {
  $password1 = $_POST['passcode1'];
  $password2 = $_POST['passcode2'];
  $username = $_POST['username1'];
  $errmsg = "<ul>";
  
  if ($username == "") 
  { // Checks for blanks.
    $errmsg = $errmsg."<li class='red'><strong>Username</strong> is missing!</li>";
  }
    
  //password1 and password2 needs to be same! Do validation!
	if ($password1 != $password2) 
  { // Checks for pass consistency
        $errmsg .= "<li class='red'><strong>Passwords</strong> does not match!</li>";
  }
  
  // Pass leng min check
  if( strlen($password1) < 8 || strlen($password2) < 8) {
	  $errmsg .= "<li class='red'><strong>Passwords</strong> size is less than 8!</li>";
  }
  
  // Pass leng max check
  if( strlen($password1) > 250 || strlen($password2) > 250) {
    $errmsg .= "<li class='red'><strong>Passwords</strong> size is too long! Max 250</li>";
  }
  
  // To get more random pass with a good entropy
  // Should be one number
  if( !preg_match("#[0-9]+#", $password1) ) {
	  $errmsg .= "<li class='red'><strong>Password</strong> must include at least one number! </li>";
  }
  
  // Should be one letter
  if( !preg_match("#[a-z]+#", $password1) ) {
	  $errmsg .= "<li class='red'><strong>Password</strong> must include at least one letter! </li>  ";
  }

  // Should be one capital letter
  if( !preg_match("#[A-Z]+#", $password1) ) {
	  $errmsg .= "<li class='red'><strong>Password</strong> must include at least one CAPS! </li>  ";
  }

  // Should be one symbol
  if( !preg_match("#\W+#", $password1) ) {
	  $errmsg .= "<li class='red'><strong>Password</strong> must include at least one symbol! </li>  ";
  }

  
  if(strlen($errmsg) < 5)
  {
    // Should be no error until here
    //$password = md5($password1);
    $password = generateSaltedPass($password1, $salt,$stretch);
    
    //$dbhandle = new PDO("sqlite:texttile.db") or die("Failed to open DB");
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    
    if (!$dbhandle) die ($error);
    try {
    $query = "INSERT INTO users_pass (usr_name,salt,stretch,hash) VALUES (:username,:salt,:stretch,:password)";
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':salt',     $salt, PDO::PARAM_STR);
    $statement->bindParam(':stretch', $stretch, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $count = $statement->rowCount();
    } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

    
    if($count==1){
      $query2 = "INSERT INTO users_rank (usr_name, usr_rank) VALUES (:username,0)";
      $statement = $dbhandle->prepare($query2);
      $statement->bindParam(':username', $username, PDO::PARAM_STR);
//      $statement->bindParam(':rank',     10, PDO::PARAM_INT);
      $statement->execute();
    
       $_SESSION['user']=$username;
       $_SESSION['rank']=10;
       echo "<script>window.location.replace('index.php');</script>";
       //header("Location: /index.php");
       exit;
    } else {
       $errmsg = "<li class='red'>Username is taken!</li>";
       $errmsg = $errmsg."</ul>";
       echo "<script type=\"text/javascript\">signup(\"$errmsg\");</script>";
       exit;
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