<?php

session_start();
//if isset($_POST)
if(isset($_FILES["file"]["type"]))
{
$validextensions = array("jpeg", "jpg", "png");
$maxsize = 99999999;
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < $maxsize)//Approx. 100kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
}
else
{
if (file_exists("images/" . $_FILES["file"]["name"])) {
echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
}
else
{
$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "images/".$_FILES['file']['name']; // Target path where file is to be stored

 $size = getimagesize($_FILES['file']['tmp_name']);
 /*** assign our variables ***/
 $type = $size['mime'];
 $imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
 $size = $size[3];
 $name = $_FILES['file']['name'];



 /*** check the file is less than the maximum file size ***/
 if($_FILES['file']['size'] < $maxsize )
 {
 /*** connect to db ***/
 $dbh = new PDO("mysql:host=localhost;dbname=sqlserver", 'username', 'password');

 /*** set the error mode ***/
 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Sql query
 $stmt = $dbh->prepare("INSERT INTO imageblob (image_type ,image, image_size, image_name, user_id) VALUES (? ,?, ?, ?, ".$_SESSION['userid'].")");
     
//$stmt = $dbh->prepare("UPDATE sqlserver.accounts SET image_type = image_type, image=image, image_size = image_size, image_name = image_name WHERE username = ".$account[‘username’]."'"); //insert into row rather than column

     //$stmt = $dbh->prepare("UPDATE tablename SET columnname = '".$new_value."' WHERE columnname = '".$value."'");

 /*** bind the params ***/
 $stmt->bindParam(1, $type);
 $stmt->bindParam(2, $imgfp, PDO::PARAM_LOB);
 $stmt->bindParam(3, $size);
 $stmt->bindParam(4, $name);

 /*** execute the query ***/
 $stmt->execute();
 $lastid = $dbh->lastInsertId(); 
 //Move uploaded File
 move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
 if(isset($lastid))
 {
 /*** assign the image id ***/
 $image_id = $lastid;
	 try {
	 /*** connect to the database ***/
	 /*** set the PDO error mode to exception ***/
	 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	 //get image and type from column
	 $sql = "SELECT image, image_type FROM imageblob WHERE image_id=$image_id";
	 
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
		 echo '<img src="data:image/jpeg;base64,'.base64_encode( $array['image'] ).'"/>';

	 }
	 else
	 {
	 throw new Exception("Out of bounds Error");
	 }
	 }
	 catch(PDOException $e)
	 {
	 echo $e->getMessage();
	 }
	 catch(Exception $e)
	 {
	 echo $e->getMessage();
	 }
	 }
	 else
	 {
	 echo 'Please input correct Image ID';
	 }
 }
 else
 {
 /*** throw an exception is image is not of type ***/
 throw new Exception("File Size Error");
 }
}
}
}
else
{
echo "<span id='invalid'>***Invalid file Size or Type***<span>";
}
}
//2 methods:
echo $_SESSION['userid'];
//$userimg = "SELECT image, image_type, image_name, image_size FROM imageblob WHERE usertag=$name";
//OR
//
?>