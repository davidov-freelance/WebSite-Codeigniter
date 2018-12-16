<script src="<?=base_url();?>app/vendor/wizard/js/bwizard.min.js"></script>
<script src="<?=base_url();?>app/vendor/parsley/parsley.min.js"></script>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/slider/css/slider.css" />
<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css" />

<script>
$(function(){
	$("#postback_inform").click(function(){
		if($(this).next("div.slide_descr").attr("data-open") != "true")
		{
			$(this).next("div.slide_descr").removeClass("hide");
			$(this).next("div.slide_descr").attr("data-open", "true");
		}
		else
		{
			$(this).next("div.slide_descr").addClass("hide");
			$(this).next("div.slide_descr").attr("data-open", "false");
		}
	});


	$('#split_test_option').click(function() {
	    if ($(this).is(':checked')) {
	        $('#pages').hide();
	        $('#pages_options').hide();
	    	$('#split_test').show();

	    	// autoselect
	    	<?php foreach($pages AS $page): ?>
	    	$('#pid<?=$page->id;?>').prop('checked', true);
	    	$('#pid<?=$page->id;?>').prop('required', true);
	    	<?php endforeach; ?>

	    } else {
	        $('#pages').show();
	        $('#pages_options').show();
	    	$('#split_test').hide();

	    	<?php foreach($pages AS $page): ?>
	    	$('#pid<?=$page->id;?>').prop('checked', false);
	    	$('#pid<?=$page->id;?>').prop('required', false);
	    	<?php endforeach; ?>

	    }
	});

});


function check_test() {
	if($('#split_test_option').attr('checked')) {
    	$('#pages').hide();
    	$('#pages_options').hide();
    	$('#split_test').show();

    	// autoselect
    	<?php foreach($pages AS $page): ?>
    	$('#pid<?=$page->id;?>').prop('checked', true);
    	$('#pid<?=$page->id;?>').prop('required', true);
    	<?php endforeach; ?>

	} else {
    	$('#pages').show();
    	$('#pages_options').show();
    	$('#split_test').hide();

    	<?php foreach($pages AS $page): ?>
    	$('#pid<?=$page->id;?>').prop('checked', false);
    	$('#pid<?=$page->id;?>').prop('required', false);
    	<?php endforeach; ?>
	}
}

</script>



<h3><?=$title;?></h3>

<!-- START panel-->
<div class="panel panel-default">
   <div class="panel-body">
      <form enctype="multipart/form-data" action="" method="POST" data-parsley-validate>
         <div class="form-horizontal">
		<?php echo validation_errors("<div class='alert alert-danger'>", "</div>"); ?>
		<fieldset>
			<legend>Основные настройки</legend>
			<div class="form-group">
				<label class="col-sm-3 control-label">Название потока</label>
				<div class="col-sm-6">
					<input<?=($type == "edit" ? ' value="'.$info->name.'"' : '');?> placeholder="Введите название потока" type="text" class="form-control" name="name" required />
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">Источник трафика (<a href="/webmaster/places/index">создать источник</a>)</label>
				<div class="col-sm-6">
                                    <select class="form-control" name="place_id">
                                        <option value="0">Выберите</option>
                                        <?php foreach($places AS $p):?>
                                            <option<?=($type == "edit" && $info->place_id == $p->id ? ' selected' : '');?> value="<?=$p->id;?>"><?=$p->name;?></option>
                                        <?php endforeach;?>
                                    </select>
				</div>
			</div>
		</fieldset>
             <?php if(count($cities) > 0):?>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">Выберите город</label>
				<div class="col-sm-6">
                                    <select class="form-control" name="city_id">
                                        <?php foreach($cities AS $c):?>
                                            <option<?=($type == "edit" && $info->city_id == $c->id ? ' selected' : '');?> value="<?=$c->id;?>"><?=$c->name;?></option>
                                        <?php endforeach;?>
                                    </select>
				</div>
			</div>
		</fieldset>
             <?php endif;?>

        <fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">Выбор ссылки</label>
				<div class="col-sm-6">
                    <select class="form-control" name="url_str">
                    	<option value="overads.ru"<?=($type == "edit" && $info->url_str == 'overads.ru' ? ' selected' : '');?>>Обычная ссылка</option>
                    	<option value="vk.overads.ru"<?=($type == "edit" && $info->url_str == 'vk.overads.ru' ? ' selected' : '');?>>Ссылка для ВКонтакте</option>
                    	<option value="mytrg.overads.ru"<?=($type == "edit" && $info->url_str == 'mytrg.overads.ru' ? ' selected' : '');?>>Ссылка для MyTarget</option>
                    </select>
				</div>
			</div>
		</fieldset>


		<fieldset id="pages">
			<div class="form-group">
				<label class="col-sm-3 control-label">Страница</label>
				<div class="col-sm-6">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th></th>
									<th>Название</th>
									<th>Ссылка</th>
									<th class="text-center">CR</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($pages AS $page):?>

								<?php
								$checked = false;
								?>
								<tr>
									<td width="40px">
										<div class="radio c-radio" style="margin: -5px 0 0 5px;">
											<label>
												<input <?php if ($type != 'edit' && $checked == false) { echo 'checked'; $checked = true; } ?> <?=($type == "edit" && $info->page_id == $page->id ? ' checked' : '');?> required data-parsley-errors-container=".errorBlock.pages" type="radio" name="page" value="<?=$page->id;?>" />
												<span class="fa fa-circle"></span>
											</label>
										</div>
									</td>
									<td><?=$page->name;?></td>
									<td><a href="<?=$page->url;?>" target="_blank"><?=$page->url;?></a></td>
									<td align="center"><?php echo getConversion($page->requests_count, $page->transits_count, false);?></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<div class="errorBlock pages"></div>
					</div>
				</div>
			</div>
		</fieldset>
		 <?php if(count($gaskets) > 0):?>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">Прокладки</label>
				<div class="col-sm-6">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th></th>
									<th>Название</th>
									<th>Ссылка</th>
									<th class="text-center">CR</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($gaskets AS $page):?>
								<tr>
									<td width="40px">
										<div class="radio c-radio" style="margin: -5px 0 0 5px;">
											<label>
												<input <?=($type == "edit" && $info->gasket_id == $page->id ? ' checked' : '');?> type="radio" name="gasket" value="<?=$page->id;?>" />
												<span class="fa fa-circle"></span>
											</label>
										</div>
									</td>
									<td><?=$page->name;?></td>
									<td><a href="<?=$page->url;?>" target="_blank"><?=$page->url;?></a></td>
									<td align="center"><?php echo getConversion($page->requests_count, $page->transits_count, false);?></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<div class="errorBlock pages"></div>
					</div>
				</div>
			</div>							
		</fieldset>		 
		 <?php endif;?>
		<fieldset id="pages_options">
			<div class="form-group">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-6">
					<div class="checkbox c-checkbox" style="margin: -5px 0 0 5px;">
						<label>
							<input <?=($type == "edit" && $info->comebacker == "1" ? ' checked' : '');?> type="checkbox" name="comebacker" />
							<span class="fa fa-check"></span> Включить ComeBacker для транзитных страниц
						</label>
					</div>
					<div class="checkbox c-checkbox" style="margin: 10px 0 0 5px;">
						<label>
							<input <?=($type == "edit" && $info->newwindow == "1" ? ' checked' : '');?> type="checkbox" name="newwindow" />
							<span class="fa fa-check"></span> Открывать лендинги в новой вкладке
						</label>
					</div>					
				</div>
			</div>							
		</fieldset>




		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">Cплит тест</label>
				<div class="col-sm-6">

					<div class="checkbox c-checkbox">
						<label>
							<input <?=($type == "edit" && !empty($info->split_test) ? ' checked' : '');?> type="checkbox" id="split_test_option" />
							<span class="fa fa-check"></span>
						</label>
					</div>

					<div class="table-responsive" id="split_test">
						<table class="table table-striped">
							<thead>
								<tr>
									<th></th>
									<th>Страница</th>
									<th>Ссылка</th>
									<th class="text-center">CR</th>
								</tr>
							</thead>
							<tbody>

								<?php foreach($pages AS $page):?>
								<tr>
									<td width="40px">
										<div class="checkbox c-checkbox" style="margin: -5px 0 0 0;">
											<label>
												<input <?=($type == "edit" && in_array($page->id, $info->split_test) ? ' checked' : '');?> type="checkbox" name="split_test[]" value="<?=$page->id;?>" id="pid<?=$page->id;?>" required data-parsley-errors-container=".errorBlock.test" />
												<span class="fa fa-check"></span>
											</label>
										</div>
									</td>
									<td><?=$page->name;?></td>
									<td><a href="<?=$page->url;?>" target="_blank"><?=$page->url;?></a></td>
									<td align="center"><?php echo getConversion($page->requests_count, $page->transits_count, false);?></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>

						<div class="errorBlock test"></div>

					</div>
				</div>
			</div>
		</fieldset>

		<script>check_test();</script>


		<fieldset>
			<legend>Отслеживание и счетчики</legend>
			<div class="form-group">
				<label class="col-sm-3 control-label">№ Счетчика Метрики</label>
				<div class="col-sm-2">
					<input<?=($type == "edit" ? ' value="'.$info->metrika.'"' : '');?> placeholder="8 чисел" type="text" class="form-control" name="metrika" />
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">№ Счетчика Mail.ru</label>
				<div class="col-sm-2">
					<input<?=($type == "edit" ? ' value="'.$info->mail.'"' : '');?> placeholder="" type="text" class="form-control" name="mail" />
				</div>
			</div>
		</fieldset>	
		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">№ Счетчика Google</label>
				<div class="col-sm-2">
					<input<?=($type == "edit" ? ' value="'.$info->google.'"' : '');?> placeholder="" type="text" class="form-control" name="google" />
				</div>
			</div>
		</fieldset>		 
		<fieldset>
			<legend>Настройки</legend>
			<div class="form-group">
				<label class="col-sm-3 control-label">TrafficBack URL</label>
				<div class="col-sm-6">
					<input<?=($type == "edit" ? ' value="'.$info->trafficback_url.'"' : '');?> placeholder="" type="text" class="form-control" name="trafficback_url" />
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label">PostBack URL</label>
				<div class="col-sm-6">
					<input<?=($type == "edit" ? ' value="'.$info->postback_url.'"' : '');?> placeholder="" type="text" class="form-control" name="postback_url" />
					<br/>
					<div>
						<a href="javascript:void(0);" id="postback_inform">Информация</a>
						<div class="slide_descr hide">
							Параметр PostBack URL будет полезен, если Вам необходимо в автоматическом режиме получать информацию о совершенной конверсии. Например в случае если Вы ведете учет конверсий в сторонней системе статистики или отслеживаете конверсии на источниках трафика.
							<br/><br/>
							PostBack запрос будет отправлен на указанный адрес методом POST. Для передачи параметров в запрос, Вы можете использовать макросы указанные ниже.
							<br/><br/>
							Пример PostBack ссылки для передачи суммы заработока и субаккаунта:
							<br/><br/>
							http://example.com/mystat.php?myprofit={profit}
							<br/><br/>
							В момент перехода макрос {profit} будут заменен на соответствующее значения.
						
							<br/><br/><b>Макросы</b><br/><br/>
							<table class="table table-bordered">
								<tr>
									<td><i>{flow_id}</i></td>
									<td>ID потока</td>
								</tr>
								<tr>
									<td><i>{ip}</i></td>
									<td>IP лида</td>
								</tr>
								<tr>
									<td><i>{lead_date}</i></td>
									<td>Дата лида</td>
								</tr>
								<tr>
									<td><i>{lead_time}</i></td>
									<td>Время лида</td>
								</tr>                                                                
								<tr>
									<td><i>{goal_id}</i></td>
									<td>ID цели</td>
								</tr>	
								<tr>
									<td><i>{goal_name}</i></td>
									<td>Название цели</td>
								</tr>	
								<tr>
									<td><i>{profit}</i></td>
									<td>Прибыль с заявки</td>
								</tr>	
								<tr>
									<td><i>{offer_id}</i></td>
									<td>ID оффера</td>
								</tr>	
								<tr>
									<td><i>{offer_name}</i></td>
									<td>Название оффера</td>
								</tr>
								<tr>
									<td><i>{sub1}, {sub2}, {sub3}, {sub4}</i></td>
									<td>Субаккаунты</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</fieldset>		 
		<fieldset>
			<legend>Информация</legend>
				<div class="col-sm-8 col-sm-offset-3">
				<b>Субаккаунты</b>
				<br/>
				Чтобы воспользоваться субаккаунтами, нужно к вашей ссылке после слеша вставить
				<u>sub1=</u>sub1&<u>sub2=</u>sub2.
				<br/>
				Пример: http://overads.ru/id_потока/?<b>sub1=</b>company1&<b>sub2=</b>creative1
			</div>
		</fieldset>	
		<fieldset>
			<div class="col-sm-8 col-sm-offset-3">
				<b>Utm метки</b>
				<br/>
				К ссылкам можно добавлять не только суб аккаунты, но и utm метки. Данные по переходам по ссылке с utm метками вы сможете увидеть в системе статистики, с которой вы работаете.
				<br/>
				Пример: http://overads.ru/id_потока/?<b>utm_source=</b>direct.yandex.ru&<b>utm_term=</b>{keyword}
			</div>
		</fieldset>		 

         </div>
	<div class="panel-footer text-center">
		<button type="submit" class="btn btn-info"><?=($type == "edit" ? 'Редактировать' : 'Добавить');?></button>
	</div>
	      
      </form>
   </div>
</div>