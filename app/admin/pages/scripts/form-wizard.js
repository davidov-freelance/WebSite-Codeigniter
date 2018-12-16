var LandingFormWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //account
                    promo_type: {
                        required: true
                    },
                    promo_name: {
                        required: true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    'langing_variant': {
                        required: "Выберите вариант лэндинга"
                    },
                    'promo_name':{
                        required: "Введите название для нового материала"
                    }
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("name") == "langing_variant") {
                        error.insertAfter("#langing_variants");
                    }
                    else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit
                    success.hide();
                    error.show();
                    Metronic.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                            .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    success.show();
                    error.hide();
                }

            });

            var displayConfirm = function() {
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'payment[]') {
                        var payment = [];
                        $('[name="payment[]"]:checked', form).each(function(){
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Шаг ' + (index + 1) + ' из ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }
                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                    $('#form_wizard_1').find('.button-next').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                    $('#form_wizard_1').find('.button-next').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    if (current != 1) {
                        $('#form_wizard_1').find('.button-next').show();
                    }
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                Metronic.scrollTo($('.page-title'));
            }

            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    var promo_types = $("#promo_types");
                    var selected_promo = promo_types.find(".checked > input");
                    switch(index) {
                        case 1:
                            promo_types.find("label").removeClass("btn-success");
                            promo_types.find(".checked").parents("label").addClass('btn-success');
                            $(".material_list").hide();
                            break;
                        case 2:
                            break;
                        case 3:


                    }




                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();
                    handleTitle(tab, navigation, index);

                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1').find('.button-next').hide();


            var banners_list = $('.promo_banner_item');
            banners_list.click(function(){
                banners_list.removeClass("btn-success");
                banners_list.find("input").attr("checked", false );
                banners_list.removeClass("red");
                $(this).addClass("btn-success");
                $(this).find("input").attr("checked", true );
            });

            $('#form_wizard_1 .button-submit').click(function () {
                var promo_name = $("#promo_name");
                var form_wizard = $('#form_wizard_1');
                if (form.valid() == false) {
                    return false;
                } else{
                    var submit_form = $( "#submit_form" ).serialize();
                    $.post( "/webmaster/promo/save_promo", submit_form ).done(function( data ) {
                        $("#promo_link").attr("href", "/webmaster/promo/download/"+data );
                    });
                    form_wizard.find('li').addClass('done');
                    form_wizard.find(".tab-pane").removeClass("active");
                    form_wizard.find("#tab4").addClass("active");
                    $(".form-actions").remove();
                }
            }).hide();

        }

    };

}();