<?php
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

if(isset($_POST['id']))
{
    $rank = $_SESSION['rank'];
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
    $query = "SELECT * FROM topic_tbl WHERE usr_rank >= :rank";
    //echo $query;
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->bindParam(':rank', $rank, PDO::PARAM_INT);
    $statement->execute();
    //$arr = $statement->errorInfo();
    //print_r($arr);
    
    //$myObj[] = new stdClass();
    //$myObj->rack = $myrack;
    //$myObj->subRacks = $finalWords;
    
    while($results = $statement->fetch())
    {
        $myStr = new stdClass();
        $myStr->id = $results['tp_id'];
        $myStr->title = $results['tp_title'];
        $myStr->rank = $results['usr_rank'];
        $myObj[] = $myStr;
    }
    
    //this part is perhaps overkill but I wanted to set the HTTP headers and status code
    //making to this line means everything was great with this request
    header('HTTP/1.1 200 OK');
    //this lets the browser know to expect json
    header('Content-Type: application/json');
    //this creates json and gives it 
    echo json_encode($myObj);
    
    
    



?>