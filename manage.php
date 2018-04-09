<!DOCTYPE html>
<?php
session_start();
$msg = "";

if(!isset($_SESSION['user']) || !isset($_SESSION['rank'])) {
    header("Location: /index.php");
    exit;
}

if($_SESSION['rank']!=0)
{
    header("Location: /index.php");
    exit;
}

$dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
if (!$dbhandle) die ($error);
$query = "SELECT * FROM topic_tbl WHERE tp_delete is not null";
$statement = $dbhandle->prepare($query);
$statement->execute();

        
while($results = $statement->fetch())
{
    $myStr = new stdClass();
    $myStr->id = $results['tp_id'];
    $myStr->title = $results['tp_title'];
    //$myStr->rank = $results['usr_rank'];
    //$myStr->lock = $results['tp_lock'];
    $myObj[] = $myStr;
}

$query = "SELECT * FROM message_tbl WHERE msg_delete is not null";
$statement = $dbhandle->prepare($query);
$statement->execute();

        
while($results = $statement->fetch())
{
    $myStr = new stdClass();
    $myStr->id = $results['msg_id'];
    $myStr->title = $results['msg_title'];
    //$myStr->rank = $results['usr_rank'];
    //$myStr->lock = $results['tp_lock'];
    $myObj2[] = $myStr;
}

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
      
      
      
      
      
      
      <div class="jumbotron">
        <h3>Manage</h3>
        <p class="lead">Delete permanently or Restore!</p>
        <?php if(strlen($msg)>0)
        echo "<h3>ERROR: ".$msg."</h3>";
        ?>
        <!-- <h3>Message to be:</h3> -->
      </div>
      
      <div class="row marketing">
        <div class="col-lg-12" id="messages">
          <p> Temporarily Deleted Topics </p>
          <form id="fdel" name="fdel" action="admintool.php" method="post">
          <table id="topics">
            <thead>
              <th style="text-align: center;">Forum Topics</th>
              <th style="text-align: center;">Manage</th>
            </thead>
            <tbody>
              
            </tbody>
          </table>

          
          <br><br>
          <p> Temporarily Deleted Messages </p>
          <table id="messagestbl">
            <thead>
              <th style="text-align: center;">Forum Topics</th>
              <th style="text-align: center;">Manage</th>
            </thead>
            <tbody>
              
            </tbody>
          </table>
          
          <input type="hidden" id="topicid" name="topicid">
          <input type="hidden" id="operation" name="operation">
          <input type="hidden" id="dtype" name="dtype">
          
          </form>
          
            
        </div>
        




      </div>
            <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>
      
      
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
  
        <script>
          var data = <?=json_encode($myObj)?>;
          var msgdata = <?=json_encode($myObj2)?>;
          
          if (data==null) {
            $('#topics tr:last').after('<tr><td>No Entry</td><td>-</td></tr>');
          }
          else
          {
            /* do things */ 
            for (i = 0; i < data.length; i++) {
              
              var edit = '<span class="pull-right"><button type="submit" class="manage" data-type="t" data-op="0" data-id="'+data[i].id+'"><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;&nbsp;<button type="submit" class="manage" data-type="t" data-op="1" data-id="'+data[i].id+'"><i class="glyphicon glyphicon-pencil"></i></button>';
              edit = edit + '</span>';
              var td2 = '<td><span id="toptit'+data[i].id+'">'+data[i].title+'</span></td>';
              var td3 = '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+edit+'</td>';
              // '<i class="glyphicon glyphicon-trash"></i><i class="glyphicon glyphicon-pencil"></i>'
              $('#topics tr:last').after('<tr>'+td2+td3+ '</tr>');
            }
          }
          
          
        if (msgdata ==null) {
            $('#messagestbl tr:last').after('<tr><td>No Entry</td><td>-</td></tr>');
          }
          else
          {
            /* do things */ 
            for (i = 0; i < msgdata.length; i++) {
              
              var edit = '<span class="pull-right"><button type="submit" class="manage" data-type="msg" data-op="0" data-id="'+msgdata[i].id+'"><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;&nbsp;<button type="submit" class="manage" data-type="msg" data-op="1" data-id="'+msgdata[i].id+'"><i class="glyphicon glyphicon-pencil"></i></button>';
              edit = edit + '</span>';
              var td2 = '<td><span id="toptit'+msgdata[i].id+'">'+msgdata[i].title+'</span></td>';
              var td3 = '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+edit+'</td>';
              // '<i class="glyphicon glyphicon-trash"></i><i class="glyphicon glyphicon-pencil"></i>'
              $('#messagestbl tr:last').after('<tr>'+td2+td3+ '</tr>');
            }
          }
          
          
         $(document).ready(function() {
             /*
            $(".manage").click(function() {
            var id = $(this).attr('data-id');
            var op = $(this).attr('data-op');
            $("#topicid").val(id);
            $("#operation").val(op);
            //$("#fdel").submit();
            });  */
            
            $( ".manage" ).mouseover(function() {
              var id = $(this).attr('data-id');
              var op = $(this).attr('data-op');
              var ty = $(this).attr('data-type');
            $("#topicid").val(id);
            $("#operation").val(op);
            $("#dtype").val(ty);
            });
              
          
         }); 
          
      </script>
      
  </html>