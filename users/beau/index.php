<!DOCTYPE html>
<html>
	<head>
	<title>beau - astrum</title>
	</head>

	<body>
<?php

include("../../php/Session.class.php");
$sess = new Session();
$sess->Init();

$cookie = isset($_COOKIE["session"]);

if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is singed in with invalid cookie
{
setcookie("session","",time()-1);
}

else //user is signed in with valid cookie
{
$img = $sess->getChatImage(1);
print_r($img);
echo '<img src="data:image/jpeg;base64,'.$img['chatimage'].'"'.'></img';
}

}


$path = dirname($_SERVER['PHP_SELF']);
$position = strrpos($path,'/') + 1;
$username=substr($path,$position);
//echo $username;

?>
</body>
</html>