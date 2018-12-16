var FormValidation = function () {

    var handleValidationProfile = function(){
        $('#profileSetting').validate({
            rules: {
                login: {
                    required: true
                }
            },
            messages: {
                login: {
                    required: ""
                }
            }

        });


    };


    var handleValidationAddOffer = function() {
        $('#addOfferForm').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error hide', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                bill: {
                    required: "Обязательное поле"
                }
            },
            rules: {
                bill: {
                    minlength: 13,
                    maxlength: 14,
                    required: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                Metronic.scrollTo('', -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            }

        });
    }

    var handleValidation5 = function () {

        $('#cashout_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error hide', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                sum: {
                    min: "Минимальная сумма вывода 3000 рублей",
                    required: "Заполните сумму вывода"
                }
            },
            rules: {
                bill: {
                    minlength: 13,
                    maxlength: 14,
                    required: true
                },
                sum: {
                    required: true,
                    min: 3000,
                    digits: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                Metronic.scrollTo('', -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            }

        });
    }



    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#form_sample_1');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error hide', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                title: {
                    required: "Обязательное поле"
                }
            },
            rules: {
                title: {
                    required: true
                }

            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            }

        });


    }




    // flow validation
    var handleValidationFlow = function() {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#flowForm');
        var error1 = $('#error_block');
        var success1 = $('#info_block');

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error hide', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                name: {
                    required: "Обязательное поле"
                },
                page: {
                    required: "Выберите страницу"
                }
            },
            rules: {
                name: {
                    required: true
                },
                country_id:{
                    required: true
                },
                city_id:{
                    required: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                Metronic.scrollTo(success1, -200);
                success1.hide();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            }

        });


    }


    return {
        //main function to initiate the module
        init: function () {
            handleValidation1();
            handleValidation5();
            handleValidationAddOffer();
            handleValidationFlow();
            handleValidationProfile();

        }

    };

}();