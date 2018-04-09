<!DOCTYPE html>
<?php
session_start();
$msg = "";

if(!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

//print_r($_POST);
if (isset( $_POST['toptit'])) {
    if($_POST['toptit']=="")
    {
        $_SESSION['msg'] = "Operation is aborted!";
        header("Location: /index.php");
        exit;
    }
    
    $title = $_POST['toptit'];
    $user = $_SESSION['user'];
    $rank = $_SESSION['rank'];
    // TODO: IF Form is locked no update! 
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    
    $query = "INSERT INTO topic_tbl (tp_owner, usr_rank, tp_lock, tp_title, tp_version) VALUES (:user,:rank,0,:title,0);";
    
    
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
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

tp_id INTEGER PRIMARY KEY AUTOINCREMENT,
tp_owner varchar(100),
usr_rank INTEGER,
tp_lock INTEGER,
tp_title varchar(200),
tp_version INTEGER,
tp_delete INTEGER 