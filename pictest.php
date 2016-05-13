<?php

function getSizeFile($url) { 
if (substr($url,0,4)=='http') { 
$x = array_change_key_case(get_headers($url, 1),CASE_LOWER); 
if ( strcasecmp($x[0], 'HTTP/1.1 200 OK') != 0 ) { $x = $x['content-length'][1]; } 
else { $x = $x['content-length']; } 
} 
else { $x = @filesize($url); } 

return $x; 
} 

$f = fopen('http://50.131.2.138/blogo.png','r');
$data = addslashes(fread($f, getSizeFile("http://50.131.2.138/blogo.png")));
fclose($f);
echo $data;

$sql = new mysqli("localhost","username","password","sqlserver");
$sql->close();
?>