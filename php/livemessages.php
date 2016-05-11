<?php
$sql = new mysqli("localhost","username","password","sqlserver");
$messages = "SELECT * FROM (SELECT * FROM sqlserver.messages WHERE 1 ORDER BY timestamp DESC LIMIT 16) messages ORDER BY timestamp ASC";
$messages = $sql->query($messages);
echo '<div class="messages" id="messagebox">';
while($msg = $messages->fetch_assoc())
{
if($msg['author']=='beau')
{
    echo '<div class="message admin">'.$msg['author']." : ".$msg['content'];
echo '</div>';
}
else {
echo '<div class="message">'.$msg['author']." : ".$msg['content'];
echo '</div>';
}
}
$sql->close();
?>