$(document).ready(function(){

$('.click_open').click(function() {
	$('.drop_form1').slideToggle(0, function() {
		if($(this).css('display') == 'block') {
			$('drop_form1').css({'display':'block'});
		}
		else {
			$('drop_form1').css({'display':'none'});
		}
	});
	return false;
});

$(document).click(function(e){
    if ($(e.target).parents().filter('.drop_form1:visible').length != 1) {
     $('.drop_form1').hide();
    }
   });





$('.click_open2').click(function() {
	$('.drop_form2').slideToggle(0, function() {
		if($(this).css('display') == 'block') {
			$('drop_form2').css({'display':'block'});
		}
		else {
			$('drop_form2').css({'display':'none'});
		}
	});
	return false;
});

$(document).click(function(e){
    if ($(e.target).parents().filter('.drop_form2:visible').length != 1) {
     $('.drop_form2').hide();
    }
   });
   
   
   
   
  $('.form_3_button').click(function() {
	$('.drop_form3').slideToggle(0, function() {
		if($(this).css('display') == 'block') {
			$('drop_form3').css({'display':'block'});
		}
		else {
			$('drop_form3').css({'display':'none'});
		}
	});
	return false;
});

$(document).click(function(e){
    if ($(e.target).parents().filter('.drop_form3:visible').length != 1) {
     $('.drop_form3').hide();
    }
   });
   
   
						
});