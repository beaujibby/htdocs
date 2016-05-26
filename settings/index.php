<!DOCTYPE html>
<html>
	<head>
	<title>Astrum</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
		
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/changePass2.js"></script>
	<script type="text/javascript" src="../js/changeBlurb.js"></script>
    <script type="text/javascript" src="../js/imgupload.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
    <script type='text/javascript' src='../js/home.js'></script>
	</head>
<body style='background:#53e3a6'> 
<?php
session_start();
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
$dbh = new PDO("mysql:host=localhost;dbname=sqlserver", 'username', 'password');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
$sql = "SELECT image, image_type FROM imageblob WHERE user_id=".$account['id']; //select most recent image where user id equals id in accounts using DESC and stores in $sql
   
/*** prepare the sql ***/
$stmt = $dbh->prepare($sql);
/*** exceute the query ***/
$stmt->execute(); 
/*** set the fetch mode to associative array ***/
$stmt->setFetchMode(PDO::FETCH_ASSOC);
/*** set the header for the image ***/
$array = $stmt->fetch();
 /*** check we have a single image and type ***/
 if(sizeof($array) == 2)
 {
     //To Display Image File from Database
     $imgdata = $array['image']; //store img src
	 $src = 'data:image/jpeg;base64,'.$imgdata;
 }
 else
 {
	 echo 'need images';
	 $src = '../images/backgroundplanet.png';

 }
    
//---------------------------------------------------------------------   
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
echo '<div class="wrapper">';
echo '<h1>settings</h1>';
    
//----------------------------------------------

echo '<img class = "userimg" src="'.$src.'"/>';

echo '<form id="uploadimage" action="" method="post" enctype="multipart/form-data">'; 

echo '<div class="upload-button">Edit</div>';
echo '<input type="file" name="file" id="file" required />';
echo '<input type="submit" value="Upload" class="submit" enctype="multipart/form-data" />';
    
echo '<div class="save">Save</div>';
echo '<div class="saveBtn" method="post"></div>';
echo '</form>';
	
echo '<form class="changePassForm" action="" method="post" enctype="multipart/form-data">';
echo '<input class = "passwordText" type="password" placeholder="Change Password" name="passwordText">';
echo '<input class = "oldPass" type="password" placeholder="Enter Old Password" name="oldPass">';
echo '</form>';

//blurb

echo '<form class="blurbForm" action="" method="post" enctype="multipart/form-data">';
echo '<div class="changeBlurb">Change Your Blurb</div>';
echo '<div class="blurbBtn" method="post"></div>';
echo '<input class = "blurbText" type="blurb" placeholder="Blurb" name="blurbText">';
echo '</form>';
	
	
echo '</div>';
//----------------------------------------------------  
    
//echo '<div class="changeUser">Edit Username</div>';
//echo '<form class="changeUserBtn" method="post"><input class="changeuser" type="submit" name="edituser" value="changeuser"></input></form>';
    
}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}
?>
    
    
</body>
</html>

