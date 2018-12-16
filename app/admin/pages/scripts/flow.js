/*  Переменные, содержающие всю неоходимую информацию об оффере
 **  parsCities - список городов, доступных для этого оффера
 **  parsCountries - список доступных стра
 **  parsPrices - список цен для городов
 **  parsPricesForCountries - список цен для стран, если они есть в связках
 */

parsCities = $.parseJSON(cities);
parsCountries = $.parseJSON(countries);
parsPrices = $.parseJSON(geo_prices);
parsPricesForCountries = $.parseJSON(pricesForCountries);




/*  меняем тип потока
 **  при этом мы производим формирование цен для стран, если выбран микс
 **  если выбран тип по городу показываем список стран для выбора
 */
$("#flow_type").change(function () {

    if ($(this).val() == "city") {
        $("#flow_countries").removeClass("hide");
        $("#geo_price_block").removeClass("hide");
        $("#select_flow_city").val($("#select_flow_city option:first").val());
        $("#offer_countries").find('option:first').val('');
        $("#select_flow_city").find('option:first').val('');
    }
    else {
        $("#flow_countries").removeClass("show").addClass("hide");

        $("#offer_countries").find('option:first').val('0');
        $("#select_flow_city").find('option:first').val('0');
        $("#flow_cities").removeClass("show").addClass("hide");
        $('#offer_countries').prop('selectedIndex', 0);
        $("#offer_price_data tr").remove();
        $("#geo_price_block").addClass("hide");
        if( parsPricesForCountries ){
            $.each(parsPricesForCountries, function (key, price) {
                $("#offer_price_data")
                    .append("<tr><td>" + parsCountries[key].country_name + "</td><td>---</td><td>" +
                    + price[0] + " <i class=\"fa fa-rub\"></i></td>" +
                    "<td>" + price[1] + "</td></tr>");
            });
        } else{
            $("#offer_price_data").append('<tr><td colspan="4" class="text-center">Нет стран для выбора</td></tr>');
        }

    }


});



// показать список городов для выбранной страны
$("#offer_countries").change(function(){
    $("#offer_price_data tr").remove();
    // нет городов для выбранной страны
    if( typeof parsCities[$(this).val()] == "undefined") {
        $("#flow_cities").removeClass("show").addClass("hide");
        $("#offer_price_data").append('<tr><td colspan="4" class="text-center">Для этой страны доступных городов нет</td></tr>');
    } else{

        $("#flow_cities").removeClass("hide").addClass("show");
        $("#select_flow_city").empty().append($("<option></option>").attr("value", "").text('выберите город'));

        // формируем список городов
        $.each(parsCities[$(this).val()], function (key, value) {
            if (value)
                $("#select_flow_city").append($("<option></option>").attr("value", key).text(value));
        });
        // формируем таблицу цен
        if( parsPrices ){
            var select_c = $(this).val();
            var country_name = $("#offer_countries option:selected" ).text();
            $.each(parsPrices[$(this).val()], function (key, data) {
                $("#offer_price_data")
                    .append("<tr id='city"+key+"'><td>" + country_name + "</td><td>" + parsCities[select_c][key] + "</td><td>" +
                    + data[0] + " <i class=\"fa fa-rub\"></i></td>" +
                    "<td>" + data[1] + "</td></tr>");
            });
        }
    }

});


// показать цены для выбранного города
$("#select_flow_city").change(function () {
    if ($(this).val() > 0) {
        $("#offer_price_data tr").hide();
        $("#city" + $(this).val()).show();
    } else{
        $("#offer_price_data tr").show();
    }
});




$('#m_check').click(function() {
    if (!$(this).parents().hasClass('checked')) {
        $('#mobile_select').show();
    } else {
        $('#mobile_select').hide();
    }
});





