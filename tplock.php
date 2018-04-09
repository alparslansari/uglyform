<!DOCTYPE html>
<?php
session_start();
$msg = "";

if(!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

//print_r($_POST);
if (isset( $_POST['tid']) && isset( $_POST['tlock']) ) {
    if($_POST['tid']=="")
    {
        $_SESSION['msg'] = "Operation is aborted!";
        header("Location: /index.php");
        exit;
    }
    
    $tid = $_POST['tid'];
    if($_POST['tlock']==0)
    {
        $lock = 1;
    }
    elseif($_POST['tlock']==1)
    {
        $lock = 0;
    }
    
    $user = $_SESSION['user'];
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    $query = "UPDATE topic_tbl SET tp_lock=:tlock WHERE tp_id = :tid AND (usr_rank=0 OR tp_owner=:user);";
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':tlock', $lock, PDO::PARAM_INT);
    $statement->bindParam(':tid', $tid, PDO::PARAM_INT);
    $statement->bindParam(':user', $user, PDO::PARAM_STR);
    $statement->execute();
}
else {
    header("Location: /index.php");
    exit;
}

header("Location: /index.php");
exit;



?>

