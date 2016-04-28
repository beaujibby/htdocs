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
	}

	public function CreateAccount()
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
		
		$create = "INSERT INTO sqlserver.accounts (`id`, `username`, `password`, `cookie`) VALUES (".$id.",'".$username."','".$password."','".$cookie."')";
		$sql->query($create);
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
	}

	public function Logout()
	{
		setcookie("session","",time()-1,"/");
		header("Refresh:0");
	}

	public function EnterMessage($author)
	{
		$content = $_POST['messagebox'];
		$content = str_replace("'","\\'",$content);
		$content = str_replace('"','\\"',$content);
		$query = "INSERT INTO `messages`(`content`, `author`) VALUES ('".$content."','".$author."')";
		$sql = new mysqli("localhost","username","password","sqlserver");
		$sql->query($query);
		$sql->close();
	}
}

?>
