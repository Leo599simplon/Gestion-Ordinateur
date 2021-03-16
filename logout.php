<?php
// démarre la session
session_start();
 
// enleve toutes les variables de session
$_SESSION = array();
 
// detruit la session 
session_destroy();
 
// redirection page de login
header("location: login.php");
exit;
?>