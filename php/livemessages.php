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
elseif($msg['author']=='Logan'){
    echo '<div class="message" style="color:#00FF00">'.$msg['author']." : ".$msg['content'].'</div>';
}
elseif($msg['author']=='Yungvegan '){
    echo '<div class="message" style="color:#FFBB00">'.$msg['author']." : ".$msg['content'].'</div>';
}
elseif($msg['author']=='coco_in_da_crib'){
    echo '<div class="message" style="color:#FF00FF">'.$msg['author']." : ".$msg['content'].'</div>';
}
else {
echo '<div class="message">'.$msg['author']." : ".$msg['content'];
echo '</div>';
}
}
$sql->close();
?>