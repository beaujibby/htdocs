<!DOCTYPE html>
<html>
	<head>
	<title>astrum chat</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<link rel="icon" type = "image/x-icon" href="../favicon2.ico" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
	<script type='text/javascript' src='../js/livemessages.js'></script>
    <script type='text/javascript' src='../js/chat.js'></script>
	</head>

	<body style = "background: url('../images/backgroundplanet.png');background-size:cover;background-attachment:fixed";>
<?php

include("../php/Session.class.php");
$sess = new Session();
$sess->Init();

$cookie = isset($_COOKIE["session"]);

if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is singed in with invalid cookie
{
setcookie("session","",time()-1,"/");
header('Location: ../');
}

else //user is signed in with valid cookie
{

if(isset($_POST['logout'])){
	 $sess->Logout($account['username']);
}

if(isset($_POST['entermessage']) || isset($_POST['messagebox'])){
	$sess->EnterMessage($account);
}

/*echo '<div class="menu">';
echo '<div class="menutext">'.$account['username'].'</div>';
echo '<div class="menubutton">chat</div>';

echo '<form class="menubutton logoutframe" method="post"><input class="logout logoutbutton" type="submit" name="logout" value="logout"></input></form>';
echo '</div>';*/

echo '<div class="header">';
echo '<img id="menutoggle" src="../images/menuiconwhite.png"></img>';
echo '</div>';
echo '<div class="menubar">';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/home">'.$account['username'].'</a></div>';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/chat">chat</a></div>';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/settings">settings</a></div>';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/users">users</a></div>';
    
echo '<form class="logoutframe" method="post" id="logout"><input class="logout" type="submit" name="logout" value="logout"></input></form>';
echo'</div>';
    
echo '<div class="chatframe">';

echo '<div class="messages" id="messagebox">';
    
echo '</div>';

echo '<form class="submitmessage" method="post">';
echo '<textarea class="messagebox" name="messagebox"></textarea>';
echo '<input class="button entermessage" type="submit" name="entermessage"></input>';
echo '</form>';
echo '</div>';
}
}

else { //user is not logged in, return to login screen
header('Location: ../');
}

?>
</body>
</html>