<!DOCTYPE html>
<html>
	<head>
	<title>Astrum</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/imgupload2.js"></script>
        
        
        
	<script type='text/javascript' src='../js/script.js'></script>
    <script type='text/javascript' src='../js/home.js'></script>
	</head>
<body style='background:#53e3a6'> 
<?php
session_start();

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
<<<<<<< HEAD
$name= $account['username'];
$_SESSION['userid'] = $account['id'];

echo $name;  

/*$qry = mysql_query("SELECT * FROM imageblob");
while($row = mysql_fetch_array($qry))
  {
  echo $row['id'];
  echo "<br />";
  echo $row['image'];
  echo "<br />";
  }*/

//include("../php/pictest.php");
//include("../php/returnImg.php");
//include("../php/pictest.php");

$dbh = new PDO("mysql:host=localhost;dbname=sqlserver", 'username', 'password');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
$sql = "SELECT image, image_type FROM imageblob WHERE user_id=".$_SESSION['userid']." ORDER BY image_id DESC"; //select most recent image where user id equals id in accounts using DESC and stores in $sql
=======
	
if(isset($_POST['saveimage'])){
    $sess->UploadImage();
}

echo '<div class="wrapper">';

echo '<h1>Settings</h1>';
echo '<form method="post">';
echo '<input type="image" class="userimg" name="userimg" src="../images/backgroundplanet.png" />';
echo '<div class="upload-button">Edit Profile</div>';
echo '<input class="file-upload" type="file" accept="image/*"/>';
echo '<input type="submit" class="button saveimage" name="saveimage" value="Save"></input></form>';  
>>>>>>> origin/master
    
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
     //echo '<img src="data:image/jpeg;base64,'.base64_encode( $array['image'] ).'"/>';
     $imgdata = base64_encode( $array['image']); //store img src

 }
 else
 {
 throw new Exception("Out of bounds Error");
 }
    
//---------------------------------------------------------------------   
echo '<div class="header">';
echo '<img id="menutoggle" src="../images/menuiconwhite.png"></img>';
echo '</div>';
echo '<div class="menubar">';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/home">'.$account['username'].'</a></div>';
    
//echo $account['username'];
    
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/chat">chat</a></div>';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/settings">settings</a></div>';
echo '<div class="menubutton"><a class="menutext" href="http://astrum.xyz/users">users</a></div>';
    
echo '<form class="logoutframe" method="post" id="logout"><input class="logout" type="submit" name="logout" value="logout"></input></form>';
echo'</div>';

<<<<<<< HEAD
echo '<div class="wrapper">';
echo '<h1> Welcome, '.$name.'</h1>';
    
//----------------------------------------------
echo '<div class="img-container">';
//echo '<img class="userimg" src="'..'" />';
echo '<img class = "userimg" src="data:image/jpeg;base64,'.$imgdata.'"/>';
echo '</div>';
//img^
echo '<form id="uploadimage" action="" method="post" enctype="multipart/form-data">'; 
//    
echo '<div class="upload-button">Edit Image</div>';
echo '<input type="file" name="file" id="file" required />';
echo '<input type="submit" value="Upload" class="submit" enctype="multipart/form-data" />';
=======
>>>>>>> origin/master
echo '</div>';
    
echo '<div class="save">Save Profile</div>';
echo '<div class="saveBtn" method="post"></div>';
echo '</form>';
//----------------------------------------------------  
    
echo '<div class="changeUser">Edit Username</div>';
echo '<form class="changeUserBtn" method="post"><input class="changeuser" type="submit" name="edituser" value="changeuser"></input></form>';
    
}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}

?>
    
    
</body>
</html>