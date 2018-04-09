<!DOCTYPE html>
<?php
session_start();
$msg = "";

if(!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}
//print_r($_POST);
if (isset($_POST['editTitle']) && $_POST['editMessage'] && $_POST['editMsg'] && $_POST['tid']) {
    $title = $_POST['editTitle'];
    $message = $_POST['editMessage'];
    $msg_id = $_POST['editMsg'];
    $user = $_SESSION['user'];
    $rank = $_SESSION['rank'];
    //echo $rank;
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);

// TODO:TABLE LOCKSA UPDATE ETME
    $query = "UPDATE message_tbl SET msg_title=:mtitle, msg_content=:mcontent, msg_edit_user=:user, msg_edit_date=datetime('now')  where msg_id = :mid AND";
    $query .=" (msg_owner=:user OR usr_rank>=:rank);";
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':mtitle', $title, PDO::PARAM_STR);
    $statement->bindParam(':mcontent', $message, PDO::PARAM_STR);
    $statement->bindParam(':user', $user, PDO::PARAM_STR);
    $statement->bindParam(':mid', $msg_id, PDO::PARAM_INT);
    $statement->bindParam(':rank', $rank, PDO::PARAM_INT);
    $statement->execute();
    //echo "<br>a<br>";
    header("Location: /view.php?id=".$_POST['tid']);
    exit;
}
else {
    header("Location: /index.php");
    exit;
}

print_r($_POST);
exit;
?>