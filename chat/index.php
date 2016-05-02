<!DOCTYPE html>
<html>
	<head>
	<title>astrum chat</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
	<script type='text/javascript' src='../js/livemessages.js'></script>
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
	$sess->Logout();
}

if(isset($_POST['entermessage'])){
	$sess->EnterMessage($account['username']);
}

/*echo '<div class="menu">';
echo '<div class="menutext">'.$account['username'].'</div>';
echo '<div class="menubutton">chat</div>';

echo '<form class="menubutton logoutframe" method="post"><input class="logout logoutbutton" type="submit" name="logout" value="logout"></input></form>';
echo '</div>';*/

echo '<div class="chatframe">';

echo '<div class="messages" id="messagebox">';
    
$sql = new mysqli("localhost","username","password","sqlserver");
$messages = "SELECT * FROM (SELECT * FROM sqlserver.messages WHERE 1 ORDER BY timestamp DESC LIMIT 50) messages ORDER BY timestamp ASC";
$messages = $sql->query($messages);
while($msg = $messages->fetch_assoc())
{
echo '<div class="message">'.$msg['author']." : ".$msg['content'].'</div>';
}
$sql->close();
    
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