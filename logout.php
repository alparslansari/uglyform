<?php
session_start();
session_unset();
session_destroy(); // Destroys the session.
session_start();
$_SESSION['logged'] = 0;
header("Location: index.php"); // Goes back to login.
?>
