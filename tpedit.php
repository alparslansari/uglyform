<!DOCTYPE html>
<?php
session_start();
$msg = "";

if(!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

//print_r($_POST);
if (isset( $_POST['tid']) && $_POST['editTitle']) {
    if($_POST['tid']=="")
    {
        $_SESSION['msg'] = "Operation is aborted!";
        header("Location: /index.php");
        exit;
    }
    
    $tid = $_POST['tid'];
    $title = $_POST['editTitle'];
    $user = $_SESSION['user'];
    
    // TODO: IF Form is locked no update! 
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    $query = "UPDATE topic_tbl SET tp_title=:title WHERE tp_id = :tid AND (usr_rank>=:rank OR tp_owner=:user);";
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':tid', $tid, PDO::PARAM_INT);
    $statement->bindParam(':rank', $_SESSION['rank'], PDO::PARAM_INT);
    $statement->bindParam(':user', $user, PDO::PARAM_STR);
    $statement->execute();
    
    //exit;
}
else {
    header("Location: /index.php");
    exit;
}

header("Location: /index.php");
exit;



?>