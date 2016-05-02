$(document).ready(function() {
    console.log("home.js");
    var left=true
    $('#menutoggle').click(function(){
        if(left)
        {
        $('.menubar').animate({left: "+=140px"},500);
        left=!left;
        }
        else
        {
        $('.menubar').animate({left: "-=140px"},500);
        left=!left;
        }
    });
});