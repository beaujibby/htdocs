<?php
class Session
{

	private $OpenID;
	private $OnLoginCallback;
	private $OnLoginFailedCallback;
	private $OnLogoutCallback;

	public $SteamID;

	public function __construct($Server = 'DEFAULT')
	{
	}

	public function __call($closure, $args)
	{
	}

	public function Init()
	{
	}

	function generateRandomString($length) {
		$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function Login()
	{
		$username=$_POST['username'];
		$password=$_POST['password'];
		$sql = new mysqli("localhost","username","password","sqlserver");
		$checklogin = "SELECT * FROM sqlserver.accounts WHERE username='".$username."'";
		$checklogin = $sql->query($checklogin);
		$checklogin = $checklogin->fetch_assoc();
		$sql->close();

		$correctpassword = $checklogin['password'];
		if($password==$correctpassword)
		{
			setcookie("session",$checklogin['cookie'],time()+3600*24,"/");
			
            header("Refresh:0");
			
		}
				
//Set status
		$sql2 = new mysqli("localhost","username","password","sqlserver");
		$stat = "UPDATE sqlserver.accounts SET status = 'online' WHERE username='".$username."'";
		$stat = $sql2->query($stat);
		
		$t = "UPDATE sqlserver.accounts SET lastOnline = now() WHERE username='".$username."'";
		$t = $sql2->query($t);
		$sql2->close();
			
	}

	public function CreateAccount($ip)
	{
		$username=$_POST['username'];
		$password=$_POST['password'];

		$sql = new mysqli("localhost","username","password","sqlserver");

		$checkusername = "SELECT id FROM sqlserver.accounts WHERE username='".$username."'";
		$checkusername = $sql->query($checkusername);
		$checkusername = $checkusername->fetch_assoc();
		$checkusername = $checkusername['id'];
		if($checkusername=="") //username is not taken, create account
		{
		$id = "SELECT MAX(ID) FROM sqlserver.accounts";
		$id = $sql->query($id);
		$id = $id->fetch_assoc()["MAX(ID)"];
		$id+=1;

		$cookie=$this->generateRandomString(30);
		
		$create = "INSERT INTO sqlserver.accounts (`id`, `username`, `password`, `cookie`,`ip`) VALUES (".$id.",'".$username."','".$password."','".$cookie."','".$ip."')";
		
		/*$create = "INSERT INTO sqlserver.accounts (`id`, `username`, `password`, `cookie`,`ip`, `status`) VALUES (".$id.",'".$username."','".$password."','".$cookie."','".$ip.", '".$status."')";*/
		$sql->query($create);
			
		//insert background planet img
		/*$filename = "../images/backgroundplanet.png"	
		$imgfile = file_get_contents($filename);	
			
		$size = getimagesize($imgfile);
$type = $size['mime'];
$imgfp = fopen($imgfile, 'rb');
$size = $size[3];
$name = $imgfile;

$sql = new mysqli("localhost","username","password","sqlserver");
$imgfp64 = base64_encode(stream_get_contents($imgfp));
$update = "UPDATE sqlserver.imageblob set image='".$imgfp64."', image_type='".$type."', image_name='".$name."', image_size='".$size."' where user_id=".$account['id'];
$sql->query($update);*/
			
			
		
		
		$imgquery = "INSERT INTO sqlserver.imageblob (`user_id`) VALUES (".$id.")";
		$sql->query($imgquery);
		
		$sql->close();
        
        $oldmask = umask(0);
        mkdir('../users/'.$username,0777);
        copy('../php/index.php','../users/'.$username.'/index.php');
        umask($oldmask);
        
        header('Location: ../');
		}
		else
		{
		echo '<div class="error">error: username taken</div>';
		}
	}

	public function Verify($cookie)
	{
		$sql = new mysqli("localhost","username","password","sqlserver");
		$user = "SELECT * FROM sqlserver.accounts WHERE cookie='".$cookie."'";
		$user = $sql->query($user);
		$user = $user->fetch_assoc();
		if($user['username']=="")
		{
		return 0;
		}
		return $user;
        $sql->close();
	}

	public function Logout($username)
	{
		setcookie("session","",time()-1,"/");

		//echo $username;
		
		//Set status
		$sql2 = new mysqli("localhost","username","password","sqlserver");
		$stat = "UPDATE sqlserver.accounts SET status = 'offline' WHERE username='".$username."'";
		$stat = $sql2->query($stat);
		$sql2->close();
		
		header("Refresh:0");
	}
    
    public function getUsers()
    {
        echo '<div class="results">';
        $query = $_POST['searchbar'];
        $sql = new mysqli("localhost","username","password","sqlserver");
        $query = "SELECT * FROM sqlserver.accounts WHERE username LIKE '%".$query."%'";
        $query = $sql->query($query);
		$sql->close();
        while($user = $query->fetch_assoc())
        {
            echo '<div class="result">';
			echo '<img class="imageresult" src="data:image/jpeg;base64,'.$this->getChatImage($user['id'])['chatimage'].'"></img>';
			//echo '<div class="usernameresult">'.$user['username'].'</div>';
			echo '<a href ="'.$user['username'].'" class="usernameresult">'.$user['username'].'</a>';
			echo '</div>';
			//echo '<a class = "result" href = "../profile">'.$user['username'].' '.$user['blurb'].'</a><br>';
			
			//echo '<a class = "result" href = "http://www.astrum.xyz/profile/">'.$user['username'].' '.$user['blurb'].'</a><br>'; //fix css
        }
        echo '</div>';
    }

	public function EnterMessage($author)
	{
		$content = $_POST['messagebox'];
		$content = str_replace("'","\\'",$content);
		$content = str_replace('"','\\"',$content);
		$query = "INSERT INTO `messages`(`content`, `author_id`, `author`) VALUES ('".$content."','".$author['id']."','".$author['username']."')";
		$sql = new mysqli("localhost","username","password","sqlserver");
		$sql->query($query);
		$sql->close();
	}
	
	public function UploadImage()
	{
		$validextensions = array("jpeg", "jpg", "png", 'JPEG','PNG','JPG');
		$maxsize = 99999999;
		$temporary = explode(".", $_FILES["file"]["name"]);
		$file_extension = end($temporary);
		if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] =="image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
		) && ($_FILES["file"]["size"] < $maxsize)//Approx. 100kb files can beuploaded.
		&& in_array($file_extension, $validextensions)) {

			$size = getimagesize($_FILES['file']['tmp_name']);
			$type = $size['mime'];
			$imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
			$size = $size[3];
			$name = $_FILES['file']['name'];

			$sql = new mysqli("localhost","username","password","sqlserver");
			$imgfp = base64_encode(stream_get_contents($imgfp));
			$update = "UPDATE sqlserver.imageblob set image='".$imgfp."',image_type='".$type."', image_name='".$name."', image_size='".$size."' whereuser_id=".$account['id'];
			
			$sql->query($update);
			$sql->close();
		}
	}
	
	
	public function getImage($id)
	{
		
		$sql = new mysqli("localhost","username","password","sqlserver");
		$img = "SELECT image, image_type FROM sqlserver.imageblob WHERE user_id=".$id;
		$img=$sql->query($img);
		$sql->close();
		$img=$img->fetch_assoc();
		return $img;
	}
	
	
	public function getChatImage($id)
	{
		$sql = new mysqli("localhost","username","password","sqlserver");
		$img = "SELECT chatimage, image_type FROM sqlserver.imageblob WHERE user_id=".$id;
		$img=$sql->query($img);
		$sql->close();
		$img=$img->fetch_assoc();
		return $img;
	}
		
}
?>