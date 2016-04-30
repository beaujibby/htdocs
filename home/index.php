<!DOCTYPE html>
<html>
	<head>
	<title>astrum</title>
	<link rel='stylesheet' type='text/css' href='css/stylesheet.css'/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type='text/javascript' src='js/script.js'></script>
    <script src="js/login.js"></script>
	</head>
<body style="background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);">
<?php

include("../php/Session.class.php");
$sess = new Session();
$sess->Init();

$cookie = isset($_COOKIE["session"]); //mmm...cookiessss...

if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is singed in with invalid cookie
{
setcookie("session","",time()-1);
header('Location: /home');
}

else //user is signed in with valid cookie
{

echo '<div class="menubar"></div>';
    
}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}

?>
</body>
</html>