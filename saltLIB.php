<?php
//a password, a salt, and a number of iterations.
function generateSaltedPass($password, $salt, $number)
{
    $temp = hash("sha256", "0".$password.$salt);
    for ($i = 1; $i <= $number; $i++) {
          $temp = hash("sha256", $temp.$password.$salt);
    }
    return $temp;
}

//$usr_name = "admin";
//$password = "cookies are great";

//$hash = generateSaltedPass($password, $salt,$stretch);
?>