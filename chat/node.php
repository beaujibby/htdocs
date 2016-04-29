<!DOCTYPE html>
<html>
	<head>
	<title>astrum chat</title>
	<link rel='stylesheet' type='text/css' href='examples/chat/public/style.css'/>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='examples/chat/index.js'></script>
    <script src="/socket.io/socket.io.js"></script>
  <script src="/main.js"></script>
	</head>

	<body style = "background: rgb(24,24,71);background-size:cover;background-attachment:fixed";>
<?php

$ch = curl_init("127.0.0.1:3000");

$ch=curl_exec($ch);

?>
</body>
</html>