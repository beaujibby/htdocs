<!DOCTYPE html>
<html>
	<head>
	<title>Astrum Profile</title>
	<link rel='stylesheet' type='text/css' href='../../css/stylesheet.css'/>
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type='text/javascript' src='../../js/script.js'></script>
    <script type='text/javascript' src='../../js/home.js'></script>
	
	</head>

	<body style = "background: url('images/backgroundplanet.png');background-size:cover;background-attachment:fixed";>
<?php

include("../../php/Session.class.php");
$sess = new Session();
$sess->Init();

//Get profile username		
$path = dirname($_SERVER['PHP_SELF']);
$position = strrpos($path,'/') + 1;
$username=substr($path,$position);
//echo "User is ".$username;		

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
echo '<div class="header">';
echo '<img id="menutoggle" src="../../images/menuiconwhite.png"></img>';
echo '<img class="backbtn" src="../../images/chevron-left.png"></img>';
echo '</div>';
echo '<div class="menubar">';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/home">'.$account['username'].'</a></div>';
    
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/chat">chat</a></div>';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/settings">settings</a></div>';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/users">users</a></div>';
    
echo '<form class="logoutframe" method="post" id="logout"><input class="logout" type="submit" name="logout" value="logout"></input></form>';
echo'</div>';
echo '<div class="wrapper">';
echo '<h1 class = "profileh">'.$username.'</h1>';

}

}


//Get user id for image		
$sql = new mysqli("localhost","username","password","sqlserver");
		$id = "SELECT id, time, blurb FROM sqlserver.accounts WHERE username ='".$username."'";
		//echo $id;
		//$id = "SELECT id FROM sqlserver.accounts WHERE username =";
		$id=$sql->query($id);
		$sql->close();
		$id=$id->fetch_assoc();
		//echo $id['id'];
		
		//echo $id['time']."\n";
		//echo $id['blurb'];
		
		$yr = (string) $id['time'];
		$yr = substr($yr,0,4);
		
		$mnth = (string) $id['time'];
		$mnth = substr($mnth,5,2);
		
		$day = (string) $id['time'];
		$day = substr($day,8,2);
		//echo $day;
		
		$blurb = $id['blurb'];
		if($blurb == "")
		{
			$blurb = "They haven't told us anything yet!";
		}
		
//Image		
		
$dbh = new PDO("mysql:host=localhost;dbname=sqlserver", 'username', 'password');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
//Get user image
$sql = "SELECT image, image_type FROM imageblob WHERE user_id= ".$id['id'];//test
//$sql = "SELECT image, image_type FROM imageblob WHERE user_id=".$id;		
   
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
	 echo 'no images';
	 $src = '../images/backgroundplanet.png';

 }

echo '<img class = "profileimage" src="'.$src.'"/>';
echo '<h3>Date Joined</h3>';
echo '<p class = profiletxt>'.$mnth." ".$day." ".$yr.'</p>';
echo '<h3 class = profileHeader>Who is '.$username.'?</h3>';
echo '<p class = profiletxt>'.$blurb.'</p>';
		
echo '</div>';
		
?>
</body>
</html>