

<form id="addOfferForm" enctype="multipart/form-data" action="<?=base_url();?>admin/offer/edit_true/" method="POST" data-offer="<?=$main->id;?>">

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-plus font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase">Редактирование</span>
			<span class="caption-helper"> нового оффера</span>
		</div>
		<div class="tools">
			<span class="btn btn-sm grey fileinput-button">
				<input type="file" name="logo" multiple="">
			</span>
			<?php if( $main->image ):?>
				<a href="<?=base_url();?>offer/view/id/<?=$main->id;?>"><img src="<?=base_url();?>/files/images/offers/<?=$main->id;?>/<?=$main->image;?>" alt="Image" class="image-offers" style="width: 25px; height: 25px;" /></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->

		<? if( $main->private ): ?>
		<div class="alert alert-warning alert-dismissable">
			<strong>Внимание!</strong> Приватный оффер.
		</div>
		<? endif; ?>
		<?php Alert_model::alertMsg('<strong>Отлично!</strong> Оффер успешно сохранен. <a href="/admin/offer/list" class="alert-link">Перейти к списку </a>', 'success'); ?>


	<input type="hidden" name="id" value="<?=$main->id;?>">
			<div class="form-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Название</label>
							<input type="text" class="form-control" name="name" value="<?=$main->name;?>" required />
							<div class="errorBlock name"></div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Источник</label>



							<select name="traffics[]" multiple="multiple" class="form-control bs-select" id="traffics" required >
							<?php
							$placesAll = config_item("places");
							$places = explode(", ", $main->places);
							foreach($places AS $place){
								echo '<option value="'.$place.'" selected>'.$place.'</option>';
								$pos = array_search($place, $placesAll);
								unset($placesAll[$pos]);
							}
							foreach($placesAll AS $place){
								echo '<option value="'.$place.'">'.$place.'</option>';
							}
							?>

							</select>
							<div class="errorBlock traffics"></div>

						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">ID в CRM</label>
							<input type="text" class="form-control" name="id_in_crm" value="<?=$main->id_in_crm;?>" />
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


								<?php
								foreach ($users->result() as $row) {
									$o_id = $row->id;
									$u_email = $row->email;
									$dis='';
									if( $o_id == $main->user_id ) $selected = " selected";
									else $selected = "";
									echo '<option value="'.$o_id.'"'.$selected.'>'.$u_email.'</option>';
								}
								?>


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
							<select name="offers_private[]" multiple="multiple" class="form-control bs-select" data-live-search="true">
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
								<label class="btn btn-default btn-sm <? if($main->sex == 0) echo 'active'; ?>">
									<input type="radio" class="toggle" name="sex" value="0" <? if($main->sex == 0) echo 'checked'; ?>> Все </label>
								<label class="btn btn-default btn-sm<? if($main->sex == 1) echo 'active'; ?>">
									<input type="radio" class="toggle" name="sex" value="1" <? if($main->sex == 1) echo 'checked'; ?>> Мужчины </label>
								<label class="btn btn-default btn-sm<? if($main->sex == 2) echo 'active'; ?>">
									<input type="radio" class="toggle" name="sex" value="2" <? if($main->sex == 2) echo 'checked'; ?>> Женщины </label>
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Возраст: <span id="slider-range-amount">
								</span>

								<input type="hidden" id="ageMin" name="ageMin" value="<? echo $main->age['0'] ?>">
								<input type="hidden" id="ageMax" name="ageMax" value="<? echo $main->age['1'] ?>">
							</label>
							<div id="slider-range" class="slider bg-grey">
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Постклик:
								<span id="slider-postclick-amount"></span>
								<input type="hidden" id="postClick" name="postclick" value="<? echo $main->postclick ?>">
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

							<textarea name="text" data-provide="markdown" required="" rows="10" data-error-container="#editor_error" class="md-input" style="resize: none;" aria-required="true" name="small_descr"><?=$main->small_descr;?></textarea>



							<div class="errorBlock small_descr"></div>
						</div>
					</div>
				</div>

				<div class="portlet-body  row">
					<div class="col-md-4">
						<legend>Цели
							<!--<a id="goals_editable_1_new" class="pull-right">
								<span class="icon-plus"></span>
							</a>-->
						</legend>
						<table class="table table-hover table-bordered edit" id="goals_editable_1">
							<thead>
							<tr>
								<th class="col-md-2">
									#
								</th>
								<th class="col-md-8">
									Название
								</th>
								<th class="col-md-2">
								</th>
							</tr>
							</thead>
							<tbody>

							<?php if( count( $goals ) ) : ?>
							<?php foreach( $goals as $goal ): ?>
							<tr>
								<td><?=$goal->id;?></td>
								<td><?=$goal->name;?></td>
								<td>
									<input type="hidden" class="goals_ids" data-id="<?=$goal->id;?>" name="goals[<?=$goal->id;?>]" value="<?=$goal->name;?>">
									<!--<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> <a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a>-->


								</td>
							</tr>


							<?php endforeach;?>
							<?php endif; ?>
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


							<?php if( count( $gaskets ) ) : ?>
								<?php foreach( $gaskets as $gasket ): ?>
									<tr>
										<td><?=$gasket->name;?></td>
										<td><?=$gasket->url;?></td>
										<td>
											<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> <a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a>
											<input type="hidden" name="gaskets[links][]" value="<?=$gasket->name;?>'">
											<input type="hidden" name="gaskets[names][]" value="<?=$gasket->url;?>">


										</td>
									</tr>


								<?php endforeach;?>
							<?php endif; ?>

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


							<? foreach ($geo_goals as $row) : ?>
							<tr>
								<td class="col-md-3"><?= $row->goal_id;?></td>
								<td class="col-md-5">
									<? if( $row->city_id ): ?>
									<?=$row->city_name;?>
									<? else : echo $row->country_name; endif; ?>
								</td>
								<td class="col-md-1"><?= $row->real_price;?> </td>
								<td class="col-md-1"><?= $row->price;?> </td>
								<td class="col-md-1"><?= $row->lid_count;?> </td>
								<td class="col-md-1 vcenter">

									<a class="setStatus" href="javascript:;" data-id="<?=$row->id;?>" data-offer="<?=$main->id;?>" data-status="<?=$row->status;?>"> <i class="fa fa-<? echo ($row->status)?"pause":"play"; ?>"></i></a>
									<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a>

									<a class="delete font-red" href="javascript:;" data-offer="<?=$main->id;?>" data-id="<?=$row->id;?>"> <i class="fa fa-times"></i> </a>
									<input type="hidden" name="bunches[goal][]" value="<?= $row->goal_id;?>">
									<input type="hidden" name="bunches[real_price][]" value="<?= $row->real_price;?> ">
									<input type="hidden" name="bunches[price][]" value="<?= $row->price;?> ">
									<input type="hidden" name="bunches[lid_count][]" value="<?= $row->lid_count;?> ">
									<input type="hidden" name="bunches[country][]" value="<?=$row->country_id;?>">
									<input type="hidden" name="bunches[city][]" value="<?=$row->city_id;?>">

									<input type="hidden" name="bunches[id][]" value="<?=$row->id;?>">
									<input type="hidden" name="bunche" value="<?=$row->id;?>">
								</td>
							</tr>
							<? endforeach; ?>








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
								<th class="col-md-5">
									Группа UTM меток
								</th>
								<th class="col-md-2">
									Мобильный лендинг
								</th>
								<th class="col-md-1">
								</th>
							</tr>
							</thead>
							<tbody>

							<?php if( count( $pages ) ) : ?>
								<?php foreach( $pages as $page ): ?>
									<tr>
										<td><?=$page->name;?></td>
										<td><?=$page->url;?></td>
										<td><?=$page->title;?></td>
										<td><?=($page->type=="2")?"Да":"Нет";?></td>
										<td class="col-md-2 vcenter"> <a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> <a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a>
											<input type="hidden" name="pages[links][]" value="<?=$page->url;?>">
											<input type="hidden" name="pages[names][]" value="<?=$page->name;?>">
											<input type="hidden" name="pages[utm_group_ids][]" value="<?=$page->utm_group_id;?>">
											<input type="hidden" name="pages[pageType][]" value="<?=$page->type;?>">
											<input type="hidden" name="pages[id][]" value="<?=$page->id;?>">
											</td>
									</tr>


								<?php endforeach;?>
							<?php endif; ?>



							</tbody>
						</table>
					</div>
				</div>


			</div>
			<div class="row text-center">
				<a href="/admin/offer/list"><button type="button" class="btn default">Отмена</button></a>
				<button type="submit" class="btn blue"><i class="fa fa-check"></i> Сохранить</button>
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
<input type="hidden" id="utm_groups" value='<?php echo json_encode( $utm_groups ); ?>'>
<script type="text/javascript" src="/app/admin/pages/scripts/offer.js"></script>









			
