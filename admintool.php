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

if(!isset($_POST['topicid']) || !isset($_POST['operation']) || !isset($_POST['dtype']))
{
    header("Location: /index.php");
    exit;
}

$tid = $_POST['topicid'];
$op  = $_POST['operation'];
$dtype = $_POST['dtype'];

$dbhandle = new PDO("sqlite:auth.db") or die("Failed to open DB");
if (!$dbhandle) die ($error);
if($dtype=="t")
{
    if($op == 0)
    {
        // DELETE
        $query1 = "DELETE FROM topic_tbl WHERE tp_id = :tid";
        $statement = $dbhandle->prepare($query1);
        $statement->bindParam(':tid', $tid, PDO::PARAM_INT);
        $statement->execute();
        
        $query2 = "DELETE FROM message_tbl WHERE tp_id = :tid";
        $statement = $dbhandle->prepare($query2);
        $statement->bindParam(':tid', $tid, PDO::PARAM_INT);
        $statement->execute();
        
    }
    elseif($op == 1)
    {
        // RESTORE
        $query = "UPDATE topic_tbl SET tp_delete=null WHERE tp_id = :tid";
        $statement = $dbhandle->prepare($query);
        $statement->bindParam(':tid', $tid, PDO::PARAM_INT);
        $statement->execute();
    }
}
elseif($dtype=="msg")
{
    if($op == 0)
    {
        // DELETE
        $query2 = "DELETE FROM message_tbl WHERE msg_id = :tid";
        $statement = $dbhandle->prepare($query2);
        $statement->bindParam(':tid', $tid, PDO::PARAM_INT);
        $statement->execute();
    }
    elseif($op == 1)
    {
        // RESTORE
        $query = "UPDATE message_tbl SET msg_delete=null WHERE msg_id = :tid";
        $statement = $dbhandle->prepare($query);
        $statement->bindParam(':tid', $tid, PDO::PARAM_INT);
        $statement->execute();
    }
}
header("Location: /manage.php");
    exit;

?>