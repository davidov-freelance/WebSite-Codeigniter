var Login = function() {

    var handleLogin = function() {

        $('.recover').validate({
            focusInvalid: false,
            errorClass: 'help-block help-block-error',
            rules: {
                password: {
                    required: true,
                    min: 6
                },
                password_two: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    required: "",
                    min: "Минимальная длина пароля 6 символов"
                },

                password_two: {
                    required: "",
                    equalTo: ""
                }
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                $('#error_block', $('.recover')).show();
            }
        });


        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                },
                'g-recaptcha-response': {
                    required: true
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                },
                'g-recaptcha-response':{
                    required: "Подтвердите, что вы не робот"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit
                $('#recover-error').show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
               // form.submit();
            }
        });


        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });


        jQuery('#recover-button').click(function() {
            if ($('.forget-form').validate().form()) {


                $.ajax({
                    type: "POST",
                    url: "/account/recover",
                    dataType: 'json',
                    data: "email=" + $('#recover-email').val(),
                    success: function (msg) {
                        if (msg.error) {
                            $('#recover-error').removeClass('display-hide');
                            $('#recover-email').val('').focus();
                        } else {
                            $('.recover-form').hide();
                            $('#recover-success').removeClass('display-hide');

                        }

                    }
                });
            }
            else return false;

        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }

    var handleRegister = function() {


        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                login: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                'g-recaptcha-response': {
                    required: true
                },
                answer:{
                    required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                login: {
                    required: "Введите логин"
                },
                password: {
                    required: "Введите пароль"
                },
                "g-recaptcha-response": {
                    required: "Подтвердите, что вы не робот"
                },
                email: {
                    required: "Введите корректный email",
                    email: "Введите коррекный email"
                },
                answer: {
                    required: "Введите ответ на вопрос",
                    remote: "Неверный ответ"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.register-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.register-form').validate().form()) {
                    $('.register-form').submit();
                }
                return false;
            }
        });



        jQuery('#register-submit-btn').click(function() {

            $.post( "/register/check_answer", { answer: $('#answer').val() }, function( data ) {
                if( data.error == "not_answer" ) {
                    $("#answer").parent().addClass("has-error");
                }
                else if( data.error == "incorrect" ){
                    $("#question_value").html(data.question);
                    $("#answer").parent().addClass("has-error");
                    $("#answer").after("<span class='help-block'>Неверный ответ, мы обновили вопрос!</span>");
                } else{
                    $("#answer").parent().removeClass("has-error");
                    $("#answer").find('.help-block').remove();
                }
            }, "json");



        });
        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();
            handleForgetPassword();
            handleRegister();

        }

    };

}();