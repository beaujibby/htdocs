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
if(isset($_FILES["file"]["type"]))
{
$validextensions = array("jpeg", "jpg", "png");
$maxsize = 99999999;
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < $maxsize)//Approx. 100kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {

$size = getimagesize($_FILES['file']['tmp_name']);
$type = $size['mime'];
$imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
$size = $size[3];
$name = $_FILES['file']['name'];

$sql = new mysqli("localhost","username","password","sqlserver");
$imgfp = base64_encode(stream_get_contents($imgfp));
$update = "UPDATE sqlserver.imageblob set image='".$imgfp."', image_type='".$type."', image_name='".$name."', image_size='".$size."' where user_id=".$account['id'];
$sql->query($update);

$q = "SELECT image, image_type FROM sqlserver.imageblob WHERE user_id=".$account['id'];
$q=$sql->query($q);
$q=$q->fetch_assoc();
echo '<img src="data:image/jpeg;base64,'.$q['image'].'"/>';
}
}

}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}
?>