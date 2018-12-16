
var ComponentsjQueryUISliders = function () {

    return {
        //main function to initiate the module
        init: function () {
            // basic
            $(".slider-basic").slider(); // basic sliders

             // vertical range sliders
            $("#slider-range").slider({
                isRTL: Metronic.isRTL(),
                range: true,
                values: [17, 67],
                slide: function (event, ui) {
                    $("#slider-range-amount").text("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            
            // snap inc
            $("#slider-postclick").slider({
                isRTL: Metronic.isRTL(),
                value: $("#postClick").val(),
                min: 5,
                range: "min",
                max: 60,
                slide: function (event, ui) {
                    $("#slider-postclick-amount").text( ui.value);
                    $("#postClick").val( ui.values );
                }
            });

            $("#slider-postclick-amount").text( $("#slider-postclick").slider("value"));
            $("#postClick").val( $("#slider-postclick").slider("value") );

            // range slider
            $("#slider-range").slider({
                isRTL: Metronic.isRTL(),
                range: true,
                min: 16,
                max: 100,
                values: [ $("#ageMin").val(),  $("#ageMax").val()],
                slide: function (event, ui) {
                    $("#slider-range-amount").text( ui.values[0] + " - " + ui.values[1]);
                    $("#ageMin").val( ui.values[0] );
                    $("#ageMax").val( ui.values[1] );
                }
            });

            $("#slider-range-amount").text( $("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider("values", 1) );

            $("#ageMin").val( $("#slider-range").slider("values", 0) );
            $("#ageMax").val( $("#slider-range").slider("values", 1) );

            //range max

            $("#slider-range-max").slider({
                isRTL: Metronic.isRTL(),
                range: "max",
                min: 1,
                max: 10,
                value: 2,
                slide: function (event, ui) {
                    $("#slider-range-max-amount").text(ui.value);
                }
            });

            $("#slider-range-max-amount").text($("#slider-range-max").slider("value"));

            // range min
            $("#slider-range-min").slider({
                isRTL: Metronic.isRTL(),
                range: "min",
                value: 37,
                min: 1,
                max: 700,
                slide: function (event, ui) {
                    $("#slider-range-min-amount").text("$" + ui.value);
                }
            });

            $("#slider-range-min-amount").text("$" + $("#slider-range-min").slider("value"));

            // vertical slider
            $("#slider-vertical").slider({
                isRTL: Metronic.isRTL(),
                orientation: "vertical",
                range: "min",
                min: 0,
                max: 100,
                value: 60,
                slide: function (event, ui) {
                    $("#slider-vertical-amount").text(ui.value);
                }
            });
            $("#slider-vertical-amount").text($("#slider-vertical").slider("value"));

            // vertical range sliders
            $("#slider-range-vertical").slider({
                isRTL: Metronic.isRTL(),
                orientation: "vertical",
                range: true,
                values: [17, 67],
                slide: function (event, ui) {
                    $("#slider-range-vertical-amount").text("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });

            $("#slider-range-vertical-amount").text("$" + $("#slider-range-vertical").slider("values", 0) + " - $" + $("#slider-range-vertical").slider("values", 1));

        }

    };

}();