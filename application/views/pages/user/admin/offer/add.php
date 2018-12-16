
<form action="#" class="horizontal-form" id="addOfferForm" method="post" enctype="multipart/form-data">
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-plus font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase"><?=$title;?></span>
			<span class="caption-helper"> нового оффера</span>
		</div>
		<div class="tools">
			<span class="btn btn-sm grey fileinput-button">
				<input type="file" name="logo" multiple="">
			</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
			<div class="form-body">

				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label class="control-label">Название</label>
							<input type="text" class="form-control" name="name" required />
							<div class="errorBlock name"></div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-5">
						<div class="form-group">
							<label class="control-label">Источник</label>
							<select name="traffics[]" multiple="multiple" class="form-control bs-select" id="traffics" required >
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

					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">ID в CRM</label>
							<input type="text" class="form-control" name="id_in_crm"  />
						</div>
					</div>
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">


							<label class="control-label">Рекламодатель</label>
							<select name="user_id" class="form-control bs-select">
								<option>Ничего не выбрано</option>
								<?php foreach ($users->result() as $row): ?>
									<option value="<?=$row->id;?>"><?=$row->email;?></option>
								<?php endforeach; ?>
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Категория</label>
							<select name="cat" class="form-control bs-select" required>
								<?php foreach(config_item("cats") AS $key=>$value):?>
									<option value="<?=$key;?>"><?=$value;?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Приватный для </label>
							<select name="offers_private[]" multiple="multiple" class="form-control bs-select">
								<?php
								foreach ($users2->result() as $row) {

									$o_id = $row->id;
									$u_email = $row->email;

									if( in_array($o_id, $offers_private) ) $selected = " selected";
									else $selected = "";

									echo '<option value="'.$o_id.'"'.$selected.'>'.$u_email.'</option>';
								}
								?>


							</select>
						</div>
					</div>
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Пол</label><br>
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default btn-sm active">
									<input type="radio" class="toggle" name="sex" value="0" checked="checked"> Все </label>
								<label class="btn btn-default btn-sm">
									<input type="radio" class="toggle" name="sex" value="1"> Мужчины </label>
								<label class="btn btn-default btn-sm">
									<input type="radio" class="toggle" name="sex" value="2"> Женщины </label>
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Возраст: <span id="slider-range-amount">
								</span>
								<input type="hidden" id="ageMin" name="ageMin">
								<input type="hidden" id="ageMax" name="ageMax">
							</label>
							<div id="slider-range" class="slider bg-grey">
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Постклик:
								<span id="slider-postclick-amount"></span>
								<input type="hidden" id="postClick" name="postclick">
							</label>
							<div id="slider-postclick" class="slider bg-grey">
							</div>
						</div>
					</div>
					<!--/span-->
				</div>


				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Описание</label>
							<textarea name="text" data-provide="markdown" required="" rows="10" data-error-container="#editor_error" class="md-input" style="resize: none;" aria-required="true" name="small_descr"></textarea>



							<div class="errorBlock small_descr"></div>
						</div>
					</div>
				</div>

				<div class="portlet-body  row">
					<div class="col-md-4">
						<legend>Цели
							<a id="goals_editable_1_new" class="pull-right">
								<span class="icon-plus"></span>
							</a>
							</legend>
						<table class="table table-hover table-bordered edit" id="goals_editable_1">
							<thead>
							<tr>
								<th class="col-md-2">
									#
								</th>
								<th class="col-md-7">
									Название
								</th>
								<th class="col-md-3">
								</th>
							</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class="col-md-8">
						<legend>Прокладки
							<a id="gaskets_editable_new" class="pull-right">
								<span class="icon-plus"></span>
							</a>

							</legend>
						<table class="table table-hover table-bordered" id="gaskets_editable">
							<thead>
							<tr>
								<th class="col-md-4">
									Название
								</th>
								<th class="col-md-7">
									Ссылка
								</th>
								<th class="col-md-1">
								</th>
							</tr>
							</thead>
							<tbody>


							</tbody>
						</table>
					</div>
				</div>


				<div class="portlet-body row">
					<div class="col-md-12">
						<legend>Связки цель-гео<a id="bunches_editable_new" class="pull-right">
								<input type="hidden" id="lastGoal" value="<?=$lastGoal;?>" />
								<span class="icon-plus"></span>
							</a></legend>
						<table class="table table-hover table-bordered edit" id="bunches_editable">
							<thead>
							<tr>
								<th class="col-md-3">
									Цель
								</th>
								<th class="col-md-5">
									Гео
								</th>
								<th class="col-md-1">
									Рекламодателю
								</th>
								<th class="col-md-1">
									Вебмастеру
								</th>
								<th class="col-md-1">
									Лидов
								</th>
								<th class="col-md-1">
								</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>




				<div class="portlet-body row">
					<div class="col-md-12">
						<legend>Страницы<a id="pages_editable_new" class="pull-right">
								<span class="icon-plus"></span>
							</a></legend>
						<table class="table table-hover table-bordered edit" id="pages_editable">
							<thead>
							<tr>
								<th class="col-md-4">
									Название
								</th>
								<th class="col-md-5">
									Ссылка
								</th>
								<th class="col-md-2">
									Мобильный лендинг
								</th>
								<th class="col-md-1">
								</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>


			</div>
			<div class="row text-center">
				<a href="/admin/offer/list"><button type="button" class="btn default">Отмена</button></a>
				<button type="submit" class="btn blue" id="add_btn"><i class="fa fa-check"></i> Добавить</button>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>



<span class="hide" id="countries_select">
<select class="select_country">
</select>
</span>


<input type="hidden" id="countries" value='<?php echo json_encode( $countries ); ?>'>
<script type="text/javascript" src="/app/admin/pages/scripts/offer.js"></script>
