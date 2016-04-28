<!DOCTYPE html>
<html>
	<head>
	<title>astrum register</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
	</head>

	<body style = "background: url('../images/backgroundplanet.png');background-size:cover;background-attachment:fixed";>
<?php

include("../php/Session.class.php");
$sess = new Session();
$sess->Init();

if(isset($_POST['submit'])){
	$sess->CreateAccount();
}

echo '<div id="loginpanel">';
echo '<div class="logintext resize">register</div>';

echo '<form id="login" method="post">';
echo '<input class="logininput resize" name="username" id="username" placeholder="username"></input>';
echo '<input class="logininput resize" name="password" id="password" placeholder="password" type="password"></input>';
echo '<input class="button resize login" name="submit" type="submit" value="create account"></input>';
echo '</form>';

echo '</div>';
?>
</body>
</html>