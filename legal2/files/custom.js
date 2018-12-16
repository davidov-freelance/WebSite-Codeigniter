$(document).ready(function() {

	//$('input[name=phone]').inputmask({ mask: '8 (999) 999-99-99[9999]', greedy: false });

    $("input[name='Order[phone]']").inputmask({ mask: '8 (999) 999-99-99[9999]', greedy: false });    

	$('.sform').submit(function(e) {
		if (!$("input[name='Order[phone]']", $(this)).val()) {
			e.preventDefault();
		}
		return true;
	});


    $('a.modal').click(function(e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $('.mask').fadeTo("slow",1);
            var winH = $(window).height();
            var winW = $(window).width();
            $(id).css('top',  winH/2-$(id).height()/2);
            $(id).css('left', winW/2-$(id).width()/2);
            $(id).fadeIn(500);
        });
    $('.closeWindow').click(function (e) {
        e.preventDefault();
        $('.mask, .windowOpen').hide();
    });
    $('.mask').click(function () {
        $(this).hide();
        $('.windowOpen').hide();
    });


});
