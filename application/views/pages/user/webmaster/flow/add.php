


<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-shuffle font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase"><?=$title;?></span>
		</div>

	</div>
	<div class="portlet-body form">
		<?if(isset($info->offer_id)):?>
		<div class="note note-success" id="info_block">
				<?=$title;?> для оффера <a href="/offer/view/id/<?=$info->offer_id;?>"><?=$info->offer_name;?></a>
		</div>
		<?endif;?>
		<?php echo validation_errors("<div class='note note-danger'>", "</div>"); ?>
      <form enctype="multipart/form-data" id="flowForm" method="POST" class="form-horizontal form-row-seperated " >
         <div class="form-horizontal">
			 <div class="row">

			<div class="col-md-6">
				<div class="form-group">
					<label class="col-sm-5 control-label">Название потока</label>
					<div class="col-sm-6">
						<input<?=($type == "edit" ? ' value="'.$info->name.'"' : '');?> placeholder="Введите название потока" type="text" class="form-control" name="name" required />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				 <div class="form-group">
					 <label class="col-sm-5 control-label">Источник трафика</label>
					 <div class="col-sm-6">

						 <div class="input-group">
							 <select class="form-control" name="place_id" required>
								 <option value="">Выберите</option>
								 <?php foreach($places AS $p):?>
									 <option<?=($type == "edit" && $info->place_id == $p->id ? ' selected' : '');?> value="<?=$p->id;?>"><?=$p->name;?></option>
								 <?php endforeach;?>
							 </select>
							 <span class="input-group-btn">
								 <a href="/webmaster/places/index">
								 <button class="btn default" type="button"><i class="fa fa-plus"></i> </button>
								 </a>

							 </span>

						 </div>

					 </div>
				 </div>
			</div>
			<div class="col-md-6">
				 <div class="form-group">
					 <label class="col-sm-5 control-label">Тип потока <a href="http://blog.overads.net/miks-trafik-ili-konkretnyj-gorod-tipy-trafika/" target="_blank"><i class=" icon-question"></i></a></label>
					 <div class="col-sm-7">
						 <select class="form-control" name="flow_type" id="flow_type" required>
							 <option value="">Выберите</option>
							 <option value="city"<?php if( $type == "edit" && $info->flow_type == "city") echo 'selected';?>>По конкретному городу</option>
							 <option value="mix"<?php if( $type == "edit" && $info->flow_type == "mix") echo 'selected';?>>По всем регионам для MIX трафика</option>
						 </select>
					 </div>
				 </div>
			</div>
				 <div class="col-md-6">
					 <div class="form-group">
						 <label class="col-sm-5 control-label">Выбор ссылки</label>
						 <div class="col-sm-6">
							 <select class="form-control" name="url_str" required>
								 <option value="overads.ru"<?=($type == "edit" && $info->url_str == 'overads.ru' ? ' selected' : '');?>>Обычная ссылка</option>
								 <option value="vk.overads.ru"<?=($type == "edit" && $info->url_str == 'vk.overads.ru' ? ' selected' : '');?>>Ссылка для ВКонтакте</option>
								 <option value="mytrg.overads.ru"<?=($type == "edit" && $info->url_str == 'mytrg.overads.ru' ? ' selected' : '');?>>Ссылка для MyTarget</option>
							 </select>
						 </div>
					 </div>
				 </div>
			 <div class="col-md-6 hide <?php if( $type == "edit" && $info->flow_type == "city") echo 'show';?>" id="flow_countries" >
				 <div class="form-group">
					 <label class="col-sm-5 control-label">Страна</label>
					 <div class="col-sm-6">
						 <select id="offer_countries" name="country_id" class="form-control" name="country_id">
							 <option value="<?=($type == "edit" && $info->flow_type == "city")?'':'0'?>">выберите страну</option>
							 <?php foreach($countries AS $k => $c):?>
								 <option<?=($type == "edit" && $c->country_id == $info->country_id ? ' selected' : '');?> value="<?=$c->country_id;?>"><?=$c->country_name;?></option>
							 <?php endforeach;?>
						 </select>
						 <div id="countryGoalError"></div>
					 </div>
				 </div>
			 </div>

			 <div class="col-md-6 hide <?php if( $type == "edit" && $info->flow_type == "city") echo 'show';?>" id="flow_cities">
				<div class="form-group">
					<label class="col-sm-5 control-label">Выберите город</label>
					<div class="col-sm-6">
						<select class="form-control" name="city_id" id="select_flow_city">
							<option value="<?=($type == "edit" && $info->flow_type == "city")?'':'0'?>">выберите город</option>
							<?php foreach($offer_cities[$info->country_id] AS $k => $c):?>
								<option<?=($type == "edit" && $k == $info->city_id ? ' selected' : '');?> value="<?=$k;?>"><?=$c;?></option>
							<?php endforeach;?>



						</select>
					</div>
				</div>
			</div>

			 <div class="col-md-12 hide <?php  if( $type == "edit" && $info->flow_type == "city") echo 'show';?>" id="geo_price_block">
				 <table class="table table-striped">
					 <thead>
					 <tr>
						 <th>Страна</th>
						 <th>Город</th>
						 <th>Цена</th>
						 <th>Лидов</th>
					 </tr>
					 </thead>
					 <tbody id="offer_price_data">
					 <?
					 	if( isset($info->country_id) AND $info->flow_type=="city" ){
							foreach( $prices_data[$info->country_id] as $key=>$price ) {
						 		echo '<tr id="city'.$key.'">
							 		<td>'.$countries[$info->country_id]->country_name.'</td>
							 		<td>'.$offer_cities[$info->country_id][$key].'</td>
							 		<td>'.$price[0].' ₽</td>
							 		<td>'.$price[1].'</td></tr>';
					 		}
					 	}
					 ?>

					 <?php
					 if(  isset($info->country_id) AND $info->flow_type=="mix" AND count($prices_data) ) {
						 foreach ($prices_data as $c_id => $price) {
							 if (isset($price[0])) {
								 echo '<tr id="city'.$c_id.'">
								 		  <td>'.$countries[$c_id]->country_name.'</td>
								 		  <td>-------</td>
								 		  <td>'.$price[0][0].' ₽</td>
								 		  <td>'.$price[0][1].'</td>
							 			 </tr>';
							 }
						 }
					 }
					 if( !count($prices_data) ){
						 echo '<tr><td colspan="4" class="text-center">Нет стран для выбора</td></tr>';
					 }
					 ?>
					 </tbody>
				 </table>
			 </div>


	</div>
				 <div class="row">
				 <div id="pages">

					 <div class="col-md-6">
						 <!-- BEGIN PORTLET-->
						 <div class="portlet light">
							 <div class="portlet-title">
								 <div class="caption font-red-intense">
									 <a class="expand"></a>
									 <span class=" caption-subject bold " class="">Страницы</span>
								 </div>
								 <div class="tools">
									 <a href="" class="collapse" data-original-title="показать/скрыть" title=""></a>

								 </div>
							 </div>
							 <div class="portlet-body" style="display: block;">
								 <table class="table table-hover">
									 <thead>
									 <tr>
										 <th>Название</th>
										 <th>Ссылка</th>
										 <th class="text-center">CR</th>
									 </tr>
									 </thead>
									 <tbody>

									 <?php
									 $checked = false;
									 foreach($pages AS $page):?>
										 <?php if ($page->type == 1): ?>

											 <tr class="va-middle">
												 <td>
													 <div class="radio-list">
														 <label class="radio-inline">
															 <input <?php if ($type != 'edit' && $checked === false) { echo 'checked'; $checked = true; } ?> <?=($type == "edit" && $info->page_id == $page->id ? ' checked' : '');?> type="radio" name="page" value="<?=$page->id;?>" /> <?=$page->name;?></label>
													 </div>
												 </td>

												 <td><a href="<?=$page->url;?>" target="_blank"><?=$page->url;?></a></td>
												 <td align="center"><?php echo getConversion($page->requests_count, $page->transits_count, false);?></td>
											 </tr>
										 <?php endif; ?>

										 <?php if ($page->type == 2) { $mobile_landings = true; } ?>

									 <?php endforeach; ?>

									 </tbody>
								 </table>
								 <div class="errorBlock pages"></div>

							 </div>

						 </div>
						 <!-- END PORTLET-->

					 </div>





						 <?php
						 $m_radio_checked = false;
						 if (isset($mobile_landings)):
							 ?>
							 <div class="col-md-6">
								 <!-- BEGIN PORTLET-->
								 <div class="portlet light">
									 <div class="portlet-title">
										 <div class="caption font-red-intense">
											 <a class="expand"></a>
											 <span class=" caption-subject bold " class="">Мобильные лендинги</span>
										 </div>
										 <div class="tools">
											 <a href="" class="collapse" data-original-title="показать/скрыть" title=""></a>

										 </div>
									 </div>
									 <div class="portlet-body" style="display: block;">
										 <div class="table-responsive">
											 <table class="table table-hover">
												 <thead>
												 <tr>
													 <th>Название</th>
													 <th>Ссылка</th>
													 <th class="text-center">CR</th>
												 </tr>
												 </thead>
												 <tbody>
												 <?php foreach($pages AS $page):?>
													 <?php if ($page->type == 2): ?>
														 <tr class="va-middle">
															 <td>
																 <div class="radio-list">
																	 <label class="radio-inline">
																		 <input required type="radio" name="page" value="<?=$page->id;?>"> <?=$page->name;?></label>
																 </div></td>
															 <td><a href="<?=$page->url;?>" target="_blank"><?=$page->url;?></a></td>
															 <td align="center"><?php echo getConversion($page->requests_count, $page->transits_count, false);?></td>
														 </tr>
													 <?php endif; ?>
												 <?php endforeach; ?>
												 </tbody>
											 </table>
											 <div class="errorBlock pages"></div>
										 </div>

									 </div>

								 </div>
								 <!-- END PORTLET-->

							 </div>

						 <?php endif; ?>

				 </div>

					 <div class="row">
				 <?php if(count($gaskets) > 0):?>
					 <div class="col-md-6">
						 <div class="form-group">
							 <label class="col-sm-3 control-label">Прокладки</label>
							 <div class="col-sm-6">
								 <div class="table-responsive">
									 <table class="table table-striped">
										 <thead>
										 <tr>
											 <th>Название</th>
											 <th>Ссылка</th>
											 <th class="text-center">CR</th>
										 </tr>
										 </thead>
										 <tbody>
										 <?php foreach($gaskets AS $page):?>
											 <tr>
												 <td>
													 <div class="radio-list">
														 <label class="radio-inline">
															 <input <?=($type == "edit" && $info->gasket_id == $page->id ? ' checked' : '');?> type="radio" name="gasket" value="<?=$page->id;?>" /> <?=$page->name;?></label>
													 </div></td>


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
					 </div>
				 <?php endif;?>
					 </div>
					 <div class="row">
					 <div class="col-md-6">
						 <div class="portlet light">
							 <div class="portlet-title">
								 <div class="caption font-red-intense">
									 <a class="expand"></a>
									 <span class=" caption-subject bold " class="">Мобильный трафик</span>
								 </div>
								 <div class="tools">
									 <a href="" class="expand" data-original-title="показать/скрыть" title="">
									 </a>
								 </div>
							 </div>
							 <div class="portlet-body">
								 <label>
									 <input  <?php if ($type != 'edit') { echo 'checked'; } ?> <?=($type == "edit" && $info->m_page_id > 0 ? ' checked' : '');?> type="checkbox" name="mobile_opt" value="1" id="m_check" /> Автоматически редиректить мобильный трафик на мобильный оффер
									 <a href="http://blog.overads.net/avtomaticheskij-redirekt-na-mobilnyj-offer/" target="_blank"><i class=" icon-question"></i></a>
								 </label>
								 <br><br>
								 <div id="mobile_select" style="display: <?=(($type == "edit" && $info->m_page_id > 0) OR ($type != 'edit') ? ' block' : 'none');?>">
									 <select class="form-control" name="m_page_id">
										 <?php foreach($pages AS $page):?>
											 <?php if ($page->type == 2): ?>
												 <option value="<?php echo $page->id; ?>"<?=($type == "edit" && $info->m_page_id == $page->id ? ' selected' : '');?>><?php echo $page->name; ?> (<?php echo $page->url; ?>)</option>
											 <?php endif; ?>
										 <?php endforeach; ?>
									 </select>
								 </div>


							 </div>
						 </div>
					 </div>
					 <div class="col-md-6">
						 <div class="portlet light">
							 <div class="portlet-title">
								 <div class="caption font-red-intense">
									 <span class=" caption-subject bold " class="">POSTBACK</span>
								 </div>
								 <div class="tools">

									 <a href="" class="collapse" data-original-title="показать/скрыть" title=""></a>
									 <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="Информация">
									 </a>
								 </div>
							 </div>
							 <div class="portlet-body">
								 <div class="form-group">
									 <label class="col-md-3 control-label"> URL
										 <a href="#portlet-config" data-toggle="modal" class="config font-lsgreen" data-original-title="" title=""> <i class=" icon-question"></i> </a>
									 </label>
									 <div class="col-md-6">
										 <input<?=($type == "edit" ? ' value="'.$info->postback_url.'"' : '');?> placeholder="" type="text" class="form-control"  name="postback_url"/>

									 </div>
									 <div class="col-md-3">
										 <select class="form-control"  name="postback_method">

											 <option value="post"<?=(( $type == "edit" AND $info->postback_method == "post") ? ' selected' : '');?>>POST</option>
											 <option value="get"<?=(( $type == "edit" AND $info->postback_method == "get") ? ' selected' : '');?>>GET</option>

										 </select>
									 </div>
								 </div>
								 <div class="form-group">
									 <label class="col-md-3 control-label"> Оповещать:
									 </label>
									<div class="col-md-6">
										 <div class="checkbox-list">
											 <label>
												 <input type="checkbox"<?=(( $type == "edit" AND $info->postback_gen) ? ' checked' : '');?> name="postback_gen" value="1"> Генерация
											 </label>
											 <label>
												 <input type="checkbox"<?=(( $type == "edit" AND $info->postback_success) ? ' checked' : '');?> name="postback_success" value="1"> Подтверждение
											 </label>
											 <label>
												 <input type="checkbox"<?=(( $type == "edit" AND $info->postback_fail) ? ' checked' : '');?> name="postback_fail" value="1"> Отклонение
											 </label>
										 </div>

									 </div>
								 </div>


							 </div>
						 </div>
					 </div>

					 </div>
					 <div class="row">
				 <div class="col-md-12">
					 <!-- BEGIN PORTLET-->
					 <div class="portlet light">
						 <div class="portlet-title">
							 <div class="caption font-red-intense">
								</a>
								 <span class=" caption-subject bold " class=""> Cплит тест</span>

								 <a href="http://blog.overads.net/split-test-testiruem-neskolko-lendingov/" target="_blank"><i class=" icon-question"></i></a>
							 </div>
							 <div class="tools split-test">
								 <a href="" class="expand red" data-original-title="показать/скрыть" title="">
								 Активировать </a>
							 </div>
						 </div>
						 <div class="portlet-body" style="display: <?=($type == "edit" && !empty($info->split_test) ? ' block' : 'none');?>;">

							 <div id="context2" data-toggle="context" data-target="#context-menu">
								 <table class="table table-striped">
									 <thead>
									 <tr>
										 <th>Страница</th>
										 <th>Ссылка</th>
										 <th class="text-center">CR</th>
									 </tr>
									 </thead>
									 <tbody>

									 <?php foreach($pages AS $page):?>
										 <tr>
											 <td width="40px" class="col-md-4">
												 <label>
													 <input <?=($type == "edit" && in_array($page->id, $info->split_test) ? ' checked' : '');?> type="checkbox" name="split_test[]" value="<?=$page->id;?>" id="pid<?=$page->id;?>"/>
													 <?=$page->name;?>
												 </label>
											 </td>
											 <td><a href="<?=$page->url;?>" target="_blank"><?=$page->url;?></a></td>
											 <td align="center"><?php echo getConversion($page->requests_count, $page->transits_count, false);?></td>
										 </tr>
									 <?php endforeach;?>
									 </tbody>
								 </table>
							 </div>

						 </div>
					 </div>
					 <!-- END PORTLET-->
				 </div>


					 </div>
					 <div class="row">



				 <div class="col-md-6">
					 <!-- BEGIN PORTLET-->
					 <div class="portlet light">
						 <div class="portlet-title">
							 <div class="caption font-red-intense">
								 <a class="expand"></a>
								 <span class=" caption-subject bold " class="">Отслеживание и счетчики</span>
							 </div>
							 <div class="tools">
								 <a href="" class="collapse" data-original-title="показать/скрыть" title="">
								 </a>
							 </div>
						 </div>
						 <div class="portlet-body" style="display: block;">
							 <div class="form-group">
								 <label class="col-sm-6 control-label">№ Счетчика Метрики</label>
								 <div class="col-sm-5">
									 <input<?=($type == "edit" ? ' value="'.$info->metrika.'"' : '');?> placeholder="8 чисел" type="text" class="form-control" name="metrika" />
								 </div>
							 </div>
							 <div class="form-group">
								 <label class="col-sm-6 control-label">№ Счетчика Google</label>
								 <div class="col-sm-5">
									 <input<?=($type == "edit" ? ' value="'.$info->google.'"' : '');?> placeholder="" type="text" class="form-control" name="google" />
								 </div>
							 </div>



						 </div>
					 </div>
					 <!-- END PORTLET-->
				 </div>

				 <div class="col-md-6">
					 <!-- BEGIN PORTLET-->
					 <div class="portlet light">
						 <div class="portlet-title">
							 <div class="caption font-red-intense">
								 <a class="expand"></a>
								 <span class=" caption-subject bold " class="">Настройки</span>
							 </div>
							 <div class="tools">
								 <a href="" class="collapse" data-original-title="показать/скрыть" title="">
								 </a>

							 </div>
						 </div>
						 <div class="portlet-body" style="display: block;">
							 <div class="form-group">
								 <label class="col-md-5 control-label">TrafficBack URL</label>
								 <div class="col-md-6">
									 <input<?=($type == "edit" ? ' value="'.$info->trafficback_url.'"' : '');?> placeholder="" type="text" class="form-control" name="trafficback_url" />
								 </div>
							 </div>
							 <div class="form-group">
								 <label class="col-md-5 control-label">Номер телефона <a href="http://blog.overads.net/ukazanie-svoego-nomera-telefona-na-lendinge/" target="_blank"><i class=" icon-question"></i></a> </label>
								 <div class="col-md-6">
									 <input<?=($type == "edit" ? ' value="'.$info->phone.'"' : '');?> placeholder="" type="text" class="form-control" name="phone" />
								 </div>
							 </div>

							 <div class="form-group">
								 <div class="checkbox c-checkbox">
									 <label>
										 <input <?=($type == "edit" && $info->comebacker == "1" ? ' checked' : '');?> type="checkbox" name="comebacker" /> Включить ComeBacker для транзитных страниц
									 </label>
								 </div>
								 <div class="checkbox c-checkbox">
									 <label>
										 <input <?=($type == "edit" && $info->newwindow == "1" ? ' checked' : '');?> type="checkbox" name="newwindow" />
										 Открывать лендинги в новой вкладке
									 </label>
								 </div>
							 </div>
						 </div>
					 </div>
					 <!-- END PORTLET-->
				 </div>


					 </div>



					 <div class="col-md-12">
					 <!-- BEGIN PORTLET-->
					 <div class="portlet light">
						 <div class="portlet-title">
							 <div class="caption font-red-intense">
								 <a class="expand"></a>
								 <span class=" caption-subject bold " class="">Информация</span>
							 </div>
							 <div class="tools">
								 <a href="" class="collapse" data-original-title="показать/скрыть" title="">
								 </a>
							 </div>
						 </div>
						 <div class="portlet-body" style="display: block;">
							 <div>
								 <p>
									 <b>Субаккаунты</b>
									 <br/>
									 Чтобы воспользоваться субаккаунтами, нужно к вашей ссылке после слеша вставить
									 <u>sub1=</u>sub1&<u>sub2=</u>sub2.
									 <br/>
									 Пример: http://overads.ru/id_потока/?<b>sub1=</b>company1&<b>sub2=</b>creative1
								 </p>
								 <br>
								 <p>
									 <b>Utm метки</b>
									 <br/>
									 К ссылкам можно добавлять не только суб аккаунты, но и utm метки. Данные по переходам по ссылке с utm метками вы сможете увидеть в системе статистики, с которой вы работаете.
									 <br/>
									 Пример: http://overads.ru/id_потока/?<b>utm_source=</b>direct.yandex.ru&<b>utm_term=</b>{keyword}<br />
									 <a href="http://blog.overads.net/multilending-uvelichivaem-konversiyu-cherez-utm_term/" target="_blank">Подробнее</a>
								 </p>

							 </div>
						 </div>
					 </div>
					 <!-- END PORTLET-->
				 </div>

		<div class="col-md-12 text-center">
			<br>
			<button type="submit" class="btn btn-success" id="send_button"><?=($type == "edit" ? 'Редактировать' : 'Добавить');?></button>
		</div>
				 </div>
			 </div>
      </form>
	</div>
</div>


<div class="modal fade" id="portlet-config" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Информация</h4>
			</div>
			<div class="modal-body">
				<p>Параметр PostBack URL будет полезен, если Вам необходимо в автоматическом режиме получать информацию о совершенной конверсии. Например в случае если Вы ведете учет конверсий в сторонней системе статистики или отслеживаете конверсии на источниках трафика.</p>
				PostBack запрос будет отправлен на указанный адрес выбранным методом. Для передачи параметров в запрос, Вы можете использовать макросы указанные ниже.
				<p>
				Пример PostBack ссылки для передачи суммы заработока и субаккаунта:</p>

				http://example.com/mystat.php?myprofit={profit}
				<p>
					<p>
				В момент перехода макрос {profit} будут заменен на соответствующее значения.
					</p>
				<p><b>Макросы</b></p>
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
					</tr><tr>
						<td><i>{status}</i></td>
						<td>waiting - генерация <br>approved - подтверждено<br>declined - отклонено</td>
					</tr>
					<tr>
						<td><i>{sub1}, {sub2}, {sub3}, {sub4}</i></td>
						<td>Субаккаунты</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script type="text/javascript">
	var cities = '<?=json_encode($offer_cities);?>';
	var pricesForCountries = '<?=json_encode($prices_for_countries);?>';
	var countries = '<?=json_encode($countries);?>';
	var geo_prices = '<?=json_encode($prices_data);?>';
</script>
