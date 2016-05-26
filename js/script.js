var autoSizeText;
autoSizeText = function() {
  var el, elements, _i, _len, _results;
  elements = $('.resize');
  if (elements.length < 0) {
    return;
  }
  _results = [];
  for (_i = 0, _len = elements.length; _i < _len; _i++) {
    el = elements[_i];
    _results.push((function(el) {
      var resizeText, _results1;
      resizeText = function() {
        var elNewFontSize;
        elNewFontSize = (parseInt($(el).css('font-size').slice(0, -2)) - 1) + 'px';
        return $(el).css('font-size', elNewFontSize);
      };
      _results1 = [];
      while (el.scrollHeight > el.offsetHeight) {
        _results1.push(resizeText());
      }
      return _results1;
    })(el));
  }
  return _results;
};

/*$(document).on("mouseover",".about", function(){
            console.log("RAN IT");
            $(this).text("This is the new html");
});*/

$(document).ready(function() {
    console.log("LOADED SCRIPT.JS");
	
	//profile back
	$('.backbtn').on('click', function(e){
		console.log("back clicked");
		history.go(-1);
	});
	
	//expand creds
	$(".about").mouseover(function () {
        $(this).text("Zac Hardy & Skylar Thomas");

    });
    $(".about").mouseout(function () {
        $(this).text("Z&S");

    });
    
    $(".about").mouseover(function () {
        $(this).text("Zac Hardy & Skylar Thomas");

    });
    $(".about").mouseout(function () {
        $(this).text("Z&S");

    });
    
    //Change creds text
   /* $(".about").hover(
        function() // on mouseover
        {
            console.log("RAN IT");
            $(this).text("This is the new html");
        }, 
        
        function() // on mouseout
        {
            $(this).text("Z&Snnn");
            
        });*/
    
});

$(window).resize(function() {
autoSizeText();
});