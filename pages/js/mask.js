//function to mask inputs
(function($) {
  $(document).ready(function(){
    $.mask.definitions['~']='[+-]';
    $("#zip1").mask("99999" , {placeholder:" "});
    $("#zip2").mask("99999" , {placeholder:" "});
    $("#ain1").mask("9999-999-999", {placeholder:" "});
    $("#ain2").mask("9999-999-999", {placeholder:" "});
    $("#Comp1SaleDate").mask("99/99/9999",{placeholder:"  /  /    "});
    $("#Comp2SaleDate").mask("99/99/9999",{placeholder:"  /  /    "});
    $("#phone").mask("(999) 999-9999", {placeholder:" "});
  });
}(jQuery));

//fuction to ensure user only types in numbers
function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}