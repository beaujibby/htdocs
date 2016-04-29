<!DOCTYPE html>
<html>
	<head>
	<title>astrum</title>
	<link rel='stylesheet' type='text/css' href='css/loginstyle.css'/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type='text/javascript' src='js/script.js'></script>
    <script src="js/login.js"></script>
	</head>

<?php

include("php/Session.class.php");
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
}

else //user is signed in with valid cookie
{
header('Location: /chat');
}
}
else { //user is not logged in, display login screen

if(isset($_POST['login'])){
	$sess->Login();
}

echo '<div class="wrapper">';
echo '<div class="container">';
echo '<h1>Welcome</h1>';
echo '<form class="form" id="login" method="post">';
echo '<input type="text" placeholder="Username" name="username">';
echo '<input type="password" placeholder="Password" name="password">';
echo '<button type="submit" id="login-button" name="login">Login</button>';
echo '</form>';
echo '<a href="/register" style="text-decoration: none;color: white;z-index:3;position:relative">dont have an account? sign up today.</a>';
echo '</div>';
echo '<ul class="bg-bubbles">';
echo '<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>';
echo '</ul>';
echo '</div>';
//echo '</form>';

//echo '</div>';

} //end of login screen

?>
</body>
</html>