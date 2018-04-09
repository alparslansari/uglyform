<!DOCTYPE html>
<?php
session_start();
$msg = "";

if(!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}
//print_r($_POST);
print_r($_POST);
if (isset($_POST['addTitle']) && $_POST['addMessage'] && $_POST['tida']) {
    $title = $_POST['addTitle'];
    $message = $_POST['addMessage'];
    $topicid = $_POST['tida'];
    $user = $_SESSION['user'];
    $rank = $_SESSION['rank'];
    echo $rank;
    $dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);

    // Check if table is locked / do not do insert
    $query = "INSERT INTO message_tbl (tp_id, msg_owner, usr_rank, msg_title, msg_content, msg_version, msg_date) VALUES(:tip,:user,:rank,:title,:msg,0,datetime('now'));";
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':tip', $topicid, PDO::PARAM_INT);
    $statement->bindParam(':user', $user, PDO::PARAM_STR);
    $statement->bindParam(':rank', $rank, PDO::PARAM_INT);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':msg', $message, PDO::PARAM_STR);
    $statement->execute();
    //echo "<br>a<br>";
    header("Location: /view.php?id=".$_POST['tida']);
    exit;
}
else {
    header("Location: /index.php");
    exit;
}


exit;
?>