  <script src="<?=base_url();?>app/vendor/slider/js/bootstrap-slider.js"></script>
<script src="<?=base_url();?>app/vendor/chosen/chosen.jquery.min.js"></script>
<script src="<?=base_url();?>app/vendor/filestyle/bootstrap-filestyle.min.js"></script>
<script src="<?=base_url();?>app/vendor/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?=base_url();?>app/vendor/wizard/js/bwizard.min.js"></script>
<!--<script src="<?=base_url();?>app/vendor/parsley/parsley.min.js"></script>-->
<link rel="stylesheet" href="<?=base_url();?>app/vendor/slider/css/slider.css" />
<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css" />
<link rel="stylesheet" href="<?=base_url();?>app/vendor/codemirror/lib/codemirror.css">

<!--CodeMirrot JS-->
<script src="<?=base_url();?>app/vendor/codemirror/lib/codemirror.js"></script>
<script src="<?=base_url();?>app/vendor/codemirror/addon/mode/overlay.js"></script>
<script src="<?=base_url();?>app/vendor/codemirror/mode/gfm/gfm.js"></script>
<script src="<?=base_url();?>app/vendor/marked/marked.js"></script>



<style>
.errorBlock {
color: #f05050;
    font-size: 12px;
    list-style: outside none none;
}
</style>


<h3>Добавление нового оффера</h3>

<script>
$(document).ready(function() {
	var goals = [];
	var pages = [];
	var gaskets = [];



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
		pages.push([$("#pageName").val(), $("#pageUrl").val()]);
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

	$("#newGoal").click(function(){
		$("#newGoalBlock").show();
		$(this).parent().parent().before($("#newGoalBlock"));
		$(this).parent().parent().hide();
	});
	$("#newGoalSave").click(function(){
		//if(false === $('#formAddGoal').parsley().validate('block1'))
		//	return;
		$("#newGoalBlock").hide();
		$("#newGoal").closest(".form-group").show();
        var goalPrices = new Array();
        $(".goalPrices").each(function(){
            goalPrices.push($(this).val());
        });
        var goalPricesWeb = new Array();
        $(".goalPricesWeb").each(function(){
            goalPricesWeb.push($(this).val());
        });
//		goals.push([$("#goalName").val(), $("#goalPrice").val(), $("#goalPriceWeb").val()]);
		goals.push([$("#goalName").val(), goalPrices, goalPricesWeb]);
		$("#goalBlock").find(".goalBlock").addClass("forRemove");
		$("#goalBlock").find("label").html($("#goalName").val());
		$("#goalBlock").find("p").html($("#goalPrice").val() + "&nbsp;<i class='fa fa-rub'></i>");
		$("#newGoal").closest(".form-group").before($("#goalBlock").html());
		$("#goalBlock").find(".goalBlock").removeClass("forRemove");
		$("#newGoalBlock input").val("");
		$("#delGoal").removeClass("hide");
		$("#inputGoals").val(JSON.stringify(goals));
	});
	$("#delGoal").click(function(){
		goals.pop();
		$("#inputGoals").val(JSON.stringify(goals));
		$(".goalBlock.forRemove").last().remove();
		if($(".goalBlock.forRemove").size() == 0)
			$("#delGoal").addClass("hide");
	});

        $("#cities").hide();
        $("[name='countries']").change(function(){
            $.post("/admin/countries/cities", {c_id: $(this).val()}, function(data){
                var ar = $.parseJSON(data);
                $("#cities").show();

                if($('.price_city').length == 0){
                    $('#newGoalBlock fieldset')
                        .eq(0)
                        .after(
                        '<fieldset>'+
                        '<div class="form-group">'+
                        '<label class="col-sm-2 control-label">Город</label>'+
                        '<div class="col-sm-3">'+
                        '<select class="form-control price_city" name="hjhjh"></select>'+
                        '</div>'+
                        '</div>'+
                        '</fieldset>'
                    );
                }

                ar.forEach(function(item, i, arr){
                    $("#select_cities")
                        .append($("<option></option>")
                        .attr("value",item.id)
                        .text(item.name));
                });

                $('#select_cities option').off();
                $('#select_cities option').click(function(){
                    $('.price_city').empty();
                    $('.price_city').append('<option value="0">Выберите город</option>');
                    $('#select_cities option:selected').each(function(){
                        $('.price_city')
                            .append($("<option></option>")
                            .attr("value",$(this).val())
                            .text($(this).text()));
                    });
                    $('.price_city').parents('fieldset').show();

                });
                $('.price_city').change(function(){
                    $('#goalPrice').val('');
                    $('#goalPriceWeb').val('');
                    if($(this).val() != 0){
                        $('#newGoalBlock fieldset').eq(2).show();
                        if($('#goalPrices_'+$(this).val()).length == 0)
                            $('#newGoalBlock fieldset').eq(2).append('<input type="hidden" class="goalPrices" id="goalPrices_'+$(this).val()+'" value="">');
                        $('#newGoalBlock fieldset').eq(3).show();
                        if($('#goalPricesWeb_'+$(this).val()).length == 0)
                            $('#newGoalBlock fieldset').eq(3).append('<input type="hidden" class="goalPricesWeb" id="goalPricesWeb_'+$(this).val()+'" value="">');

                    }else{
                        $('#newGoalBlock fieldset').eq(2).hide();
                        $('#newGoalBlock fieldset').eq(3).hide();
                    }
                });
                $('#goalPrice').keyup(function(){
                    $('#goalPrices_'+$('.price_city option:selected').val()).val($(this).val());
                });
                $('#goalPriceWeb').keyup(function(){
                    $('#goalPricesWeb_'+$('.price_city option:selected').val()).val($(this).val());
                });

            });
        });
});
</script>

<!-- START panel-->
<div class="panel panel-default">
   <div class="panel-body">
      <form id="formAddOffer111" enctype="multipart/form-data" action="" method="POST">
         <div class="form-horizontal">
		<fieldset>
			<legend>Описание</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">Название</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="name" required />
					<div class="errorBlock name"></div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Категория</label>
				<div class="col-sm-3">
					<select name="cat" class="form-control">
						<?php foreach(config_item("cats") AS $key=>$value):?>
						<option value="<?=$key;?>"><?=$value;?></option>
						<?php endforeach;?>
					</select>
				</div>
				<label class="col-sm-1 control-label">Логотип</label>
				<div class="col-sm-4">
					<input name="logotip" type="file" class="filestyle input-append">
					<div class="errorBlock logotip"></div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Куда отправлять</label>
				<div class="col-sm-4">
					<div class="radio c-radio inline">
					   <label>
					      <input type="radio" name="send_to" value="leadvertex">
					      <span class="fa fa-circle"></span>Leadvertex</label>
					</div>
					<div class="radio c-radio inline">
					   <label>
					      <input type="radio" name="send_to" value="crm" checked>
					      <span class="fa fa-circle"></span>CRM</label>
					</div>
					<div class="errorBlock sex"></div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Краткое описание</label>
				<div class="col-sm-8">
					<textarea required class="form-control" name="small_descr" rows="5" class="col-md-12"></textarea>
					<div class="errorBlock small_descr"></div>
				</div>
			</div>
		</fieldset>
		 <!--
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Описание</label>
				<div class="col-sm-8">
					<input type="hidden" name="descr_dop" />
					<textarea id="descr" required data-parsley-errors-container=".errorBlock.descr" data-uk-markdownarea="{mode:'tab', htmlMode: true}" name="descr"></textarea>
					<div class="errorBlock descr"
				</div>
			</div>
		</fieldset>-->

		 <!--Начало Условия-->

		<fieldset>
			<legend>Условия</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">География</label>
				<div class="col-sm-4">
					<select name="countries" class="form-control chosen-select">
                                                <option value="-1">Выберите</option>
                                                <?php foreach(config_item("countries") AS $key=>$value):?>
						<option value="<?=$key;?>"><?=$value;?></option>
						<?php endforeach;?>
					</select>
					<div class="errorBlock countries"></div>
				</div>
			</div>
		</fieldset>
		<fieldset id="cities">
			<div class="form-group">
				<label class="col-sm-2 control-label">Города</label>
				<div class="col-sm-4">
                                    <select name="cities[]" multiple="" id="select_cities" class="form-control" >
                                                <option value="-1">Выберите</option>

					</select>
					<div class="errorBlock cities"></div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Источники трафика</label>
				<div class="col-sm-4">
					<select name="traffics[]" multiple="multiple" class="form-control chosen-select" id="traffics" required >
					   <option value="Веб-сайты">Веб-сайты</option>
					   <option value="Дорвеи">Дорвеи</option>
					   <option value="Контекстная реклама">Контекстная реклама</option>
					   <option value="Контекстная реклама на бренд">Контекстная реклама на бренд</option>
					   <option value="Тизерная реклама">Тизерная реклама</option>
					   <option value="Таргетированная реклама">Таргетированная реклама</option>
					   <option value="Социальные сети">Социальные сети</option>
					   <option value="Email рассылка">Email рассылка</option>
					   <option value="CashBack">CashBack</option>
					   <option value="ClickUnderPopUnder">ClickUnder/PopUnder</option>
					   <option value="Брокеры">Брокеры</option>
					</select>
					<div class="errorBlock traffics"></div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Постклик</label>
				<div class="col-sm-4">
					<input name="postclick" type="text" value="30" data-slider-min="5" data-slider-max="60" data-slider-step="1" data-slider-value="30" data-slider-orientation="horizontal" class="slider slider-horizontal form-control">
				</div>
			</div>
		</fieldset>

		 <!--Конец Условия-->
		 <!--Начало целевая аудитория-->
		<fieldset>
			<legend>Целевая аудитория</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">Пол</label>
				<div class="col-sm-4">
					<div class="radio c-radio inline">
					   <label>
					      <input type="radio" name="sex" value="1">
					      <span class="fa fa-circle"></span>Мужчины</label>
					</div>
					<div class="radio c-radio inline">
					   <label>
					      <input type="radio" name="sex" value="2">
					      <span class="fa fa-circle"></span>Женщины</label>
					</div>
					<div class="radio c-radio inline">
					   <label>
					      <input type="radio" name="sex" value="0" checked>
					      <span class="fa fa-circle"></span>Все</label>
					</div>
					<div class="errorBlock sex"></div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Возраст</label>
				<div class="col-sm-4">
					<input name="age" type="text" value="[16, 40]" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="[16, 40]" class="slider form-control">
				</div>
			</div>
		</fieldset>
		 <!--Конец целевая аудитория-->
		 <!--Начало страницы-->
		<fieldset>
			<legend>Страницы</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<input type="hidden" name="pages" id="inputPages" value="" />
					<button id="newPage" class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-plus-circle"></i></span>Новая страница</button>
					<button id="delPage" class="btn btn-default btn-labeled btn-sm hide" type="button"><span class="btn-label"><i class="fa fa-times"></i></span>Удалить последнюю</button>
					<div class="errorBlock pages"></div>
				</div>
			</div>
		</fieldset>
		 <!-- Конец страницы -->
		 <!--Начало прокладки-->
		<fieldset>
			<legend>Прокладки</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-6">
					<input type="hidden" name="gaskets" id="inputGaskets" value="" />
					<button id="newGasket" class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-plus-circle"></i></span>Новая прокладка</button>
					<button id="delGasket" class="btn btn-default btn-labeled btn-sm hide" type="button"><span class="btn-label"><i class="fa fa-times"></i></span>Удалить последнюю</button>
				</div>
			</div>
		</fieldset>
		 <!-- Конец прокладки -->
		 <!--Начало цели-->
		<fieldset>
			<legend>Цели</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<input type="hidden" name="goals" id="inputGoals" value="" />
					<button id="newGoal" class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-plus-circle"></i></span>Новая цель</button>
					<button id="delGoal" class="btn btn-default btn-labeled btn-sm hide" type="button"><span class="btn-label"><i class="fa fa-times"></i></span>Удалить последнюю</button>
					<div class="errorBlock goals"></div>
				</div>
			</div>
		</fieldset>
		 <!-- Конец цели -->

         </div>

	<div class="panel-footer text-center">
		<button type="submit" class="btn btn-info" id="buttonAddOffer">Добавить</button>
		<!--<input type="submit" value="Добавить" />-->
	</div>

      </form>
   </div>
</div>
<!-- END panel -->
<div class="hide">

	<div id="goalBlock">
		<div class="goalBlock">
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<p class="form-control-static"></p>
				</div>
			</div>
			</fieldset><fieldset>
		</div>
	</div>
	<div id="newGoalBlock">
			</fieldset>
			<form id="formAddPage">
				<fieldset>
				<div class="form-group">
					<label class="col-sm-2 control-label">Название</label>
					<div class="col-sm-4">
						<input id="goalName" type="text" class="form-control" placeholder="Например: Подтвержденная заявка"  />
					</div>
				</div>
				</fieldset><fieldset>
				<div class="form-group">
					<label class="col-sm-2 control-label">Оплата за действие</label>
					<div class="col-sm-4">
						<div class="input-group m-b">
							<input id="goalPrice" type="text" class="form-control" placeholder="Например: 500" >
							<span class="input-group-addon"><i class="fa fa-rub"></i></span>
						</div>
						<div class="errorBlock goalPrice"></div>
					</div>
				</div>
				</fieldset><fieldset>
				<div class="form-group">
					<label class="col-sm-2 control-label">Оплата вебмастеру</label>
					<div class="col-sm-4">
						<div class="input-group m-b">
							<input id="goalPriceWeb" type="text" class="form-control" placeholder="Например: 500" >
							<span class="input-group-addon"><i class="fa fa-rub"></i></span>
						</div>
						<div class="errorBlock goalPrice"></div>
					</div>
				</div>
				</fieldset>
			</form>
			<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<div class="input-group m-b">
						<button id="newGoalSave" class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-check"></i></span>Сохранить цель</button>
					 </div>
				</div>
			</div>
	</div>

	<div id="pageBlock">
		<div class="pageBlock">
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<p class="form-control-static"></p>
				</div>
			</div>
			</fieldset><fieldset>
		</div>
	</div>
	<div id="newPageBlock">
			</fieldset>
			<form id="formAddPage">
				<fieldset>
				<div class="form-group">
					<label class="col-sm-2 control-label">Название</label>
					<div class="col-sm-4">
						<input id="pageName" type="text" class="form-control" placeholder="Например: Название лендинга"  />
					</div>
				</div>
				</fieldset><fieldset>
				<div class="form-group">
					<label class="col-sm-2 control-label">Ссылка</label>
					<div class="col-sm-4">
						<input id="pageUrl" type="text" class="form-control" placeholder="" data-parsley-group="block1" >
						<div class="errorBlock pageUrl"></div>
					</div>
				</div>
				</fieldset>
			</form>
			<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<div class="input-group m-b">
						<button id="newPageSave" class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-check"></i></span>Сохранить страницу</button>
					 </div>
				</div>
			</div>
	</div>

	<div id="gasketBlock">
		<div class="gasketBlock">
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<p class="form-control-static"></p>
				</div>
			</div>
			</fieldset><fieldset>
		</div>
	</div>

	<div id="newGasketBlock">
			</fieldset>
			<form id="formAddPage">
				<fieldset>
				<div class="form-group">
					<label class="col-sm-2 control-label">Название</label>
					<div class="col-sm-4">
						<input id="gasketName" type="text" class="form-control" placeholder="Например: Название прокладки" />
					</div>
				</div>
				</fieldset><fieldset>
				<div class="form-group">
					<label class="col-sm-2 control-label">Ссылка</label>
					<div class="col-sm-4">
						<input id="gasketUrl" type="text" class="form-control" placeholder="" >
					</div>
				</div>
				</fieldset>
			</form>
			<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4">
					<div class="input-group m-b">
						<button id="newGasketSave" class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-check"></i></span>Сохранить прокладку</button>
					 </div>
				</div>
			</div>
	</div>
</div>
