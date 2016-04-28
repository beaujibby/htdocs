$(document).ready(function(){    
    loadstation();
});

function loadstation(){
    $("#messagebox").load("../php/livemessages.php");
    setTimeout(loadstation, 250);
}