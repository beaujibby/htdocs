<!DOCTYPE html>
<html>
	<head>
	<title>Astrum</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/imgupload.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
    <script type='text/javascript' src='../js/home.js'></script>
	</head>
<body style='background:#53e3a6'> 
<?php
//;background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);"
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

if(isset($_POST['logout'])){
    $sess->Logout();
}
	
if(isset($_POST['saveimage'])){
    $sess->UploadImage();
}

echo '<div class="wrapper">';

echo '<h1>S e t t i n g s</h1>';
echo '<form method="post">';
echo '<input type="image" class="userimg" name="userimg" src="../images/backgroundplanet.png" />';
echo '<div class="upload-button">Edit Profile</div>';
echo '<input class="file-upload" type="file" accept="image/*"/>';
echo '<input type="submit" class="button saveimage" name="saveimage" value="Save"></input></form>';  
    
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

echo '</div>';
    
}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}

?>
</body>
</html>