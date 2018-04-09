<!DOCTYPE html>
<?php
session_start();
$msg = "";

if(!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

// DELETE
if (isset($_POST['tid']) && $_POST['delMsg'] ) {
$tp_id =  $_POST['tid']; // topic id load form with this
$delmsg = $_POST['delMsg'];
$dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
if (!$dbhandle) die ($error);

$query = "select msg_owner, usr_rank from message_tbl where msg_id = :mid;";
    //echo $query;
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':mid', $delmsg, PDO::PARAM_INT);
    $statement->execute();
    $results = $statement->fetch();
    
    if(isset($results['msg_owner']))
    {
        if($_SESSION['user'] == $results['msg_owner'])
        {
            // do delete op
            $op = true;
        }
        elseif($_SESSION['rank']==0)
        {
            $op = true;
        }
        
        else {
            $op = false;
        }
        
        //elseif($_SESSION['rank']==10)
        //{
         //   $msg = "You do not have permission for delete!";
        //}
        //elseif($results['msg_owner']-$_SESSION['rank']>=0)
        //{
            
        //}
        if($op)
        {
            $query = "UPDATE message_tbl set msg_delete=0 where msg_id = :mid;";
            $statement = $dbhandle->prepare($query);
            $statement->bindParam(':mid', $delmsg, PDO::PARAM_INT);
            $statement->execute();
        }
    }
    else {
        $msg = "Delete operation is failed!";
    }
    
}

elseif(isset($_GET['id']))
{
    $rank = $_SESSION['rank'];
    $tp_id = $_GET['id'];
    if(isset($_GET['topic']))
    {
        $mtopic = $_GET['topic'];
    }
    else
    {
        $mtopic = "Grats, you hack this shit!!!";
    }
    
    
    //echo $_SESSION['rank'];
    //exit;
}
else {
 header("Location: /index.php");
 exit;
}





// Continue loading view topics
    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    //$dbhandle = new PDO("sqlite:texttile.db") or die("Failed to open DB");
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    
        if (!$dbhandle) die ($error);
    $query = "SELECT * FROM message_tbl WHERE tp_id = :tp_id and msg_delete is null";
    //echo $query;
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':tp_id', $tp_id, PDO::PARAM_INT);
    $statement->execute();
    //$arr = $statement->errorInfo();
    //print_r($arr);
    
    //$myObj[] = new stdClass();
    //$myObj->rack = $myrack;
    //$myObj->subRacks = $finalWords;
    
    while($results = $statement->fetch())
    {
        $myStr = new stdClass();
        $myStr->id = $results['msg_id'];
        $myStr->title = $results['msg_title'];
        $myStr->message = $results['msg_content'];
        $myStr->rank = $results['usr_rank'];
        $myStr->mdate = $results['msg_date'];
        $myStr->user = $results['msg_owner'];
        $myStr->edit = $results['msg_edit_user'];
        $myStr->edate = $results['msg_edit_date'];
        $myObj[] = $myStr;
    }
    
 $query = "SELECT tp_title FROM topic_tbl WHERE tp_id = :tp_id and tp_delete is null";
 $statement = $dbhandle->prepare($query);
    $statement->bindParam(':tp_id', $tp_id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch();
    $mtopic = $result['tp_title'];
    //echo $mtopic;
    //print_r($result);
    //exit;



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
        <h3><?=$mtopic?></h3>
        <p class="lead">You rank is <?php echo $_SESSION['rank']; ?></p>
        <?php if(strlen($msg)>0)
        echo "<h3>ERROR: ".$msg."</h3>";
        ?>
        <!-- <h3>Message to be:</h3> -->
        <button class="pull-right add" data-target="#add" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Create new message</button>
      </div>
      
      <div class="row marketing">
        <div class="col-lg-12" id="messages"> </div>
        





      </div>
            <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>
      
      
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    var msgData = <?=json_encode($myObj)?>;
    for (i = 0; i < msgData.length; i++) {
        var mid = msgData[i].id;
        var edit = '<span class="pull-right"><button class="bdel" data-target="#delete" data-toggle="modal" data-id="'+msgData[i].id+'"><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;&nbsp;<button class="bedt" data-target="#edit" data-toggle="modal" data-id="'+msgData[i].id+'"><i class="glyphicon glyphicon-pencil"></i></button></span>';
        var title = '<div>'+'<b id="msgTitle'+mid+'">'+msgData[i].title+'</b>'+edit+'</div><hr>';
        var content = '<div id="divMsgid'+mid+'">'+msgData[i].message+'</div><hr>';
        if(msgData[i].edit == null)
        {
            var time = '<div> <i><b>Posted by: </b>'+msgData[i].user+ '   <b>when: </b>'+msgData[i].mdate+'</i></div>';
        }
        else
        {
            var time = '<div> <i><b>Posted by: </b>'+msgData[i].user+ '   <b>when: </b>'+msgData[i].mdate+ ' <b>Edited by: </b>' +msgData[i].edit+'   <b>when: </b>'+msgData[i].edate+'</i></div>';
        }
        
        var msg = '<div class="well">'+title+content+time+'</div>';
    $("#messages").append(msg);
        
    }
    </script>
  </body>
  
  <!-- Modal -->
<div id="delete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="view.php" method="post" id="fdelete" name="fdelete">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Confirmation:</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure to delete this message?</p>
        <input type="hidden" id="delMsg" name="delMsg">
        <input type="hidden" id="tid" name="tid" value="<?=$tp_id?>">
        
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
    <form action="edit.php" method="post" id="fedit" name="fedit">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Confirmation:</h4>
      </div>
      <div class="modal-body">
        <p>Make your changes and click 'Save' if you wish the save the changes!</p>
        <div>
           <b>Message Title: </b><input type="text" id="editTitle" name="editTitle">
        </div>
        <div><b>Message:</b></div>
         <textarea rows="4" cols="50" id="editMessage" name="editMessage"></textarea> 
        <input type="hidden" id="editMsg" name="editMsg">
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
    <form action="add.php" method="post" id="madd" name="madd">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create a new message:</h4>
      </div>
      <div class="modal-body">
        <p>Make your changes and click 'Save' if you wish the save the changes!</p>
         <div>
           <b>Message Title: </b><input type="text" id="addTitle" name="addTitle">
        </div>
        <div><b>Message:</b></div>
         <textarea rows="4" cols="50" id="addMessage" name="addMessage"></textarea> 
        <input type="hidden" id="tida" name="tida" value="<?=$tp_id?>">
        
      </div>
      <div class="modal-footer">
        <button type="submit" id="badd" name="badd" class="btn btn-primary" data-dismiss="modal">Save <i class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>
  
<script>
$(document).ready(function() {
   $( ".bdel" ).click(function() {
      var id = $(this).attr('data-id');
      $(".modal-body #delMsg").val(id);
   });
        
   $( "#mdelete" ).click(function() {
        $("#fdelete" ).submit();
   });
   
   $( ".bedt" ).click(function() {
      var id = $(this).attr('data-id');
      $(".modal-body #editMsg").val(id);
      var title = $("#msgTitle"+id).text();
      var msg = $("#divMsgid"+id).text();
      $("#editTitle").val(title);
      $("#editMessage").val(msg);
   });
   
   $( "#medit" ).click(function() {
        $("#fedit" ).submit();
   });
   
   $( "#badd" ).click(function() {
        $("#madd" ).submit();
   });
   
        
      
});
</script>
  
  
</html>