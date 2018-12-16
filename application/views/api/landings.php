$(document).ready(function(){
<? /*
        * Микс по городам, выводим массив актуальных для потока городов
        *  а также список всех остальных городов, аналогично поступаем со странами
        */

$cityValidation = '';

if( ((count( $transit )>0 AND $transit->flow_type == "mix") OR $without_hash) AND $goals['geo_type'] == "by_cities" ): ?>
    var mainCities = $.parseJSON('<?php echo json_encode( $mainCities ); ?>');
    var allCities = '<?php echo json_encode( $allCities ); ?>';
    $('.citySelect').append($("<option></option>").attr("value",''));
    $('.citySelect').append($("<optgroup></optgroup>")
    .attr("class","mainC")
    .attr("label","Выберите город"));

    $('.citySelect').append($("<optgroup></optgroup>")
    .attr("class","otherC")
    .attr("label","Другой город"));

    $.each( $.parseJSON(allCities), function( i, item ) {
    if( mainCities[item.id] === undefined )
    var sClass = "otherC";
    else var sClass = "mainC";

    $('.'+sClass).append($("<option></option>").attr("value", item.id).text(item.name));
    });


    $(".citySelect").chosen();
    $('.countrySelect').hide();
    <?
    $cityValidation = '
            "Order[city_id]": {
                required: true
            },';
elseif( ((count( $transit )>0 AND $transit->flow_type == "mix") OR $without_hash) AND $goals['geo_type'] == "by_countries" ): ?>
    var allCountries = '<?= json_encode( $allCountries ); ?>';
    var mainCountries = $.parseJSON('<?= json_encode( $mainCountries ); ?>');

    $('.countrySelect').append($("<option></option>").attr("value",''));
    $('.countrySelect').append($("<optgroup></optgroup>")
    .attr("class","mainC")
    .attr("label","Выберите страну"));

    $('.countrySelect').append($("<optgroup></optgroup>")
    .attr("class","otherC")
    .attr("label","Другие страны"));


    $.each( $.parseJSON(allCountries), function( i, item ) {
    if( mainCountries[item.country_id] === undefined )
    var sClass = "otherC";
    else var sClass = "mainC";

    $('.'+sClass).append($("<option></option>").attr("value", item.country_id).text(item.country_name));
    });


    $(".countrySelect").chosen();
    $('.citySelect').hide();
<? else: ?>

    $('.citySelect').hide();
    $('.countrySelect').hide();

<? endif; ?>

    $(".sform").validate({
        focusInvalid: false,
        errorClass: 'help-block help-block-error',
        errorElement: 'span',
        ignore: ":hidden:not(select)",
        rules: {
            "Order[fio]": {
            required: true
            },

            <?=$cityValidation;?>


            "Order[phone]": {
                required: true
            },
            "Order[param1]": {
                required: false
            }
        },
    });

});
