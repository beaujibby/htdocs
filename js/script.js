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

$(document).ready(function() {
    console.log("LOADED SCRIPT.JS");
	
	//expand creds
	$(".about").mouseover(function () {
        $(this).text("Zac Hardy & Skylar Thomas");

    });
    $(".about").mouseout(function () {
        $(this).text("Z&S");

    });
    
});

$(window).resize(function() {
autoSizeText();
});