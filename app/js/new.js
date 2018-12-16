  function deleteGoal( goal ){
    var goals = JSON.parse($("#inputGoals").val() );
    goal = parseInt(goal.replace( "goal-", "" ) );
    goals.splice( goal, 1 );
    $("#goal-"+goal).parent().parent().parent().html('');
    $("#inputGoals").val(JSON.stringify(goals));
  }
  function deleteGeoGoal(elmn){
	  alert( elmn.parent().attr('id') );
  }
    

$(document).ready(function() {
	if( $("#inputGoals").val() )
    var goals = JSON.parse( $("#inputGoals").val() );
    else var goals = [];
    var geoGoals = [];
    var pages = [];
    var gaskets = [];
    // проверяем и обновляем список целей для select при создании гео-связки
    function checkGoalsForCities(){
        $("#goal_for_city").html('<option>выберите цель</option>');
        goals.forEach(function(item, i, arr){
            $("#goal_for_city")
                .append($("<option></option>")
                    .attr("value",i)
                    .text(item[0]));
        });
    }


    // получаем список городов для выбранной страны и формируем select
    $("#select_country").change(function(){

    });

    $("#buttonAddOffer").click(function(){
        error=0;
        if($('input[name="name"]').val() == '') {
            $('.name').text("Поле обязательно для заполнения.");
            $('input[name="name"]').css("border-color", "#f05050");
            error=1;
        }
        if($('[name="small_descr"]').val() == '') {
            $('.small_descr').text("Поле обязательно для заполнения.");
            $('[name="small_descr"]').css("border-color", "#f05050");
            error=1;
        }
        if($("[name='countries']").val() == '-1') {
            $('.countries').text("Поле обязательно для заполнения.");
            $("[name='countries']").css("border-color", "#f05050");
            error=1;
        }
        if($("#traffics").val() == null) {
            $('.traffics').text("Поле обязательно для заполнения.");
            $("#traffics").css("border-color", "#f05050");
            error=1;
        }
        if(error == 0) {
            $('#formAddOffer').submit();
        }

    });

    $('input, select, textarea').bind('change click keyup', function(){
        $(this).css('border-color', '#dbd9d9');
        //$(this).next().text('');
        $('.errorBlock').text('');
    });

    /*
     * Pages
     */

    $("#newPage").click(function(){
        $("#newPageBlock").show();
        $(this).parent().parent().before($("#newPageBlock"));
        $(this).parent().parent().hide();
    });
    $("#newPageSave").click(function(){
        //if(false === $('#formAddGoal').parsley().validate('block1'))
        //	return;
        $("#newPageBlock").hide();
        $("#newPage").closest(".form-group").show();
        pages.push([$("#pageName").val(), $("#pageUrl").val(), $("#pageType").val()]);
        $("#pageBlock").find(".pageBlock").addClass("forRemove");
        $("#pageBlock").find("label").html($("#pageName").val());
        $("#pageBlock").find("p").html($("#pageUrl").val());
        $("#newPage").closest(".form-group").before($("#pageBlock").html());
        $("#pageBlock").find(".pageBlock").removeClass("forRemove");
        $("#newPageBlock input").val("");
        $("#delPage").removeClass("hide");
        $("#inputPages").val(JSON.stringify(pages));
    });
    $("#delPage").click(function(){
        pages.pop();
        $("#inputPages").val(JSON.stringify(pages));
        $(".pageBlock.forRemove").last().remove();
        if($(".pageBlock.forRemove").size() == 0)
            $("#delPage").addClass("hide");
    });





    /*
     * Gaskets
     */

    $("#newGasket").click(function(){
        $("#newGasketBlock").show();
        $(this).parent().parent().before($("#newGasketBlock"));
        $(this).parent().parent().hide();
    });
    $("#newGasketSave").click(function(){
        //if(false === $('#formAddGoal').parsley().validate('block1'))
        //	return;
        $("#newGasketBlock").hide();
        $("#newGasket").closest(".form-group").show();
        gaskets.push([$("#gasketName").val(), $("#gasketUrl").val()]);
        $("#gasketBlock").find(".gasketBlock").addClass("forRemove");
        $("#gasketBlock").find("label").html($("#gasketName").val());
        $("#gasketBlock").find("p").html($("#gasketUrl").val());
        $("#newGasket").closest(".form-group").before($("#gasketBlock").html());
        $("#gasketBlock").find(".gasketBlock").removeClass("forRemove");
        $("#newGasketBlock input").val("");
        $("#delGasket").removeClass("hide");
        $("#inputGaskets").val(JSON.stringify(gaskets));
    });
    $("#delGasket").click(function(){
        gaskets.pop();
        $("#inputGaskets").val(JSON.stringify(gaskets));
        $(".gasketBlock.forRemove").last().remove();
        if($(".gasketBlock.forRemove").size() == 0)
            $("#delGasket").addClass("hide");
    });

    /*
     * Goals
     */

/////////////// variant 1
    /*
     $('#select_cities').click(function(){
     $('#goal_city').empty();
     $('#goal_city').append('<option value="0">Выберите город</option>');
     $('#select_cities option:selected').each(function(){
     $('#goal_city')
     .append($("<option></option>")
     .attr("value",$(this).val())
     .text($(this).text()));
     });
     });
     */
///////////////	

    $("#newGoal").click(function(){
        $("#newGoalBlock").show();
        $(this).parent().parent().before($("#newGoalBlock"));
        $(this).parent().parent().hide();
    });

    $("#newCity").click(function(){
		goals = JSON.parse( $("#inputGoals").val() );
        if( goals.length === 0 ){
            alert( 'Создайте хотя бы одну цель' );
            return;
        }
        $("#newCityBlock").show();
        $("#newCity").addClass("hide");
        $(this).parent().parent().before($("#newCityBlock"));
        checkGoalsForCities();
    });

    $("#newGoalSave").click(function(){
         if(false === $('#formAddGoal').parsley().validate())
        	return false;
        
        	
        	
        $("#newGoalBlock").hide();
        $("#newGoal").closest(".form-group").show();
        goals.push([$("#goalName").val(), 0]);
        $("#goalBlock").find("a").attr("id", 'goal-'+(goals.length-1));
        $("#goalBlock").find(".goalBlock").addClass("forRemove");
        $("#goalBlock").find("label").html($("#goalName").val());
        $("#goalBlock").find("p").html($("#goalPrice").val());
        $("#goalBlock").find(".deleteBtn").html('test');
        $("#newGoal").closest(".form-group").before($("#goalBlock").html());
        $("#goalBlock").find(".goalBlock").removeClass("forRemove");
        $("#newGoalBlock input").val("");
        $("#delGoal").removeClass("hide");
        $("#inputGoals").val(JSON.stringify(goals));
        checkGoalsForCities();
    });



    $("#newCitySave").click(function() {
        if(false === $('#formAddCity').parsley().validate())
        	return false;


        $("#newCityBlock").hide();
        $("#newCity").closest(".form-group").show();
        geoGoals.push([$("#goal_for_city").val(), $("#select_country").val(), $("#select_goal_cities").val(), $("#goalPrice").val(), $("#goalPriceWeb").val(), $("#lidCount").val()]);

        $("#cityBlock").find(".cityBlock").addClass("forRemove");

		 $("#cityBlock").find("a").parent().attr("id", 'goalEdit-'+(goals.length-1));
		 
		 
        $("#cityBlock").find("label").html(goals[$("#goal_for_city").val()][0]);
        $("#cityBlock").find("p").html($("#goalPrice").val() + "&nbsp;<i class='fa fa-rub'></i>&nbsp;"+$("#goalPriceWeb").val() + "&nbsp;<i class='fa fa-rub'></i>&nbsp;"+$("#goal_city option:selected").text());
        $("#newCity").closest(".form-group").before($("#cityBlock").html());
        $("#cityBlock").find(".cityBlock").removeClass("forRemove");
        $("#newGoalBlock input").val("");
        $("#delCity").removeClass("hide");
        $("#inputGeo").val(JSON.stringify(geoGoals));
        $("#newCity").removeClass("hide");


    });


    $("#delGoal").click(function(){
        goals.pop();
        $("#geo-data-block").find("div").first().hide();
        $("#goal_for_city").html('');
        $("#inputGoals").val(JSON.stringify(goals));
        $(".goalBlock.forRemove").last().remove();
        if($(".goalBlock.forRemove").size() == 0)
            $("#delGoal").addClass("hide");
    });
    $("#delCity").click(function(){
        geoGoals.pop();
        $("#inputGeo").val(JSON.stringify(geoGoals));
        $(".cityBlock.forRemove").last().remove();
        if($(".cityBlock.forRemove").size() == 0)
            $("#delCity").addClass("hide");
    });




    $("#cities").hide();
    $(".select_country").change(function(){
        var cities_id = $(this).data('cities-id');
        var cities_block = $(this).data('cities-block');

        $(cities_id).empty();


        $.post("/admin/countries/cities", {c_id: $(this).val()}, function(data){
            $(cities_block).show();
            $(cities_block).removeClass("hide");
            var ar = $.parseJSON(data);
            $(cities_id)
                .append($("<option></option>")
                    .attr("value","-1")
                    .text('Выберите'));

            ar.forEach(function(item, i, arr){
                //$("#select_cities, #goal_city")
               $(cities_id)
                    .append($("<option></option>")
                        .attr("value",item.id)
                        .text(item.name));


            });
        });
    });
});