<!DOCTYPE html>
<html>
	<head>
	<title>astrum</title>
	<link rel='stylesheet' type='text/css' href='css/stylesheet.css'/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type='text/javascript' src='js/script.js'></script>
	</head>

	<body style = "background: url('images/backgroundplanet.png');background-size:cover;background-attachment:fixed";>
<?php

include("php/Session.class.php");
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

if(isset($_POST['logout'])){
	$sess->Logout();
}

echo '<div class="menu">';
echo '<div class="menutext">'.$account['username'].'</div>';
echo '<a class="menubutton" href="/chat">chat</a>';

echo '<form class="menubutton logoutframe" method="post"><input class="logout logoutbutton" type="submit" name="logout" value="logout"></input></form>';
echo '</div>';
}
}

else { //user is not logged in, display login screen

if(isset($_POST['login'])){
	$sess->Login();
}

echo '<div id="loginpanel">';
echo '<div class="logintext resize">astrum.xyz</div>';

echo '<form id="login" method="post">';
echo '<input class="logininput resize" name="username" id="username" placeholder="username"></input>';
echo '<input class="logininput resize" name="password" id="password" placeholder="password" type="password"></input>';
echo '<input class="button resize login" name="login" type="submit" value="login"></input>';
echo '<a class="button resize signup" href="/signup">sign up</a>';
echo '</form>';

echo '</div>';
    
echo '<img src="/images/astrum.png" style="left: calc(50% - 100px); position: absolute; top: calc(50% - 62px);"></img>';

} //end of login screen

?>
</body>
</html>