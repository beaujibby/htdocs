$(document).ready(function() {
    console.log("home.js");
    var left=true
    $('#menutoggle').click(function(){
        if(left)
        {
        $('.menubar').stop().animate({left: "0px"},500);
        left=!left;
        }
        else
        {
        $('.menubar').stop().animate({left: "-140px"},500);
        left=!left;
        }
    });
});