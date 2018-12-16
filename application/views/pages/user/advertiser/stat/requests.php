<h3><?=$title;?></h3>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css">
<script src="<?=base_url();?>app/vendor/moment/min/moment-with-langs.min.js"></script>
<script src="<?=base_url();?>app/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css" />
<script src="<?=base_url();?>app/vendor/chosen/chosen.jquery.min.js"></script>

<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/ColVis/css/dataTables.colVis.css">

<!-- Data Table Scripts-->
<script src="<?=base_url();?>app/vendor/datatable/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrapPagination.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/ColVis/js/dataTables.colVis.min.js"></script>

<div class="panel panel-default">
	<div class="panel-body">
		<form method="get" action="">
			<fieldset style="border-bottom: 0; margin-bottom: 0;">
				<legend>Фильтр заявок</legend>
				<div class="col-md-3">
					<label>Выводить с</label>
					<div class="form-group">

						<div data-date-format="DD-MM-YYYY" data-pick-time="false" class="datetimepicker input-group date mb-lg">
							<input type="text" class="form-control" name="from_date" value="<?php echo $this->input->get("from_date");?>">
							<span class="input-group-addon">
							   <span class="fa-calendar fa"></span>
							</span>
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<label>По</label>
					<div class="form-group">

						<div data-date-format="DD-MM-YYYY" data-pick-time="false" class="datetimepicker input-group date mb-lg">
							<input type="text" class="form-control" name="to_date" value="<?php echo $this->input->get("to_date");?>">
							<span class="input-group-addon">
							   <span class="fa-calendar fa"></span>
							</span>
						</div>

					</div>
				</div>	
				<div class="col-md-3">
					<label>Оффер</label>
					<select name="offer" class="form-control chosen-select">
						<option value="0">Любой</option>
						<?php foreach($offers AS $offer):?>
						<option<?=($this->input->get("offer") == $offer->id ? " selected" : "");?> value="<?=$offer->id;?>"><?=$offer->name;?></option>
						<?php endforeach;?>
					</select>
				</div>	
				<div class="col-md-3">
					<label>Статус</label>
					<select name="status" class="form-control chosen-select">
						<option value="all">Любой</option>
						<option<?=($this->input->get("status") == "deflected" ? " selected" : "");?> value="deflected">Отклоненные</option>
						<option<?=($this->input->get("status") == "pending" ? " selected" : "");?> value="pending">В ожидании</option>
						<option<?=($this->input->get("status") == "confirmed" ? " selected" : "");?> value="confirmed">Подтвержденные</option>
						<option<?=($this->input->get("status") == "new" ? " selected" : "");?> value="new">Новые</option>
					</select>
				</div>			
			</fieldset>
			<div class="panel-footer text-center">
				<button type="submit" class="btn btn-info">Поиск</button>
			</div>
		</form>
	</div>
</div>

<!-- START panel-->
<div class="panel panel-default">

	<div class="panel-body">
		<!-- START table-responsive-->
		<div class="table-responsive">
		   <table data-table="true" class="table table-bordered">
		      <thead>
			 <tr>
			    <th class="text-center col-md-1">Дата</th>
			    <th class="">Оффер</th>
			    <!--<th class="col-md-1 text-center">Цель</th>-->
			    <th class="col-md-1 text-center">К оплате</th>
			    <th class="col-md-2 text-center">Фио</th>
			    <th class="col-md-2 text-center">Телефон</th>
			    <th class="col-md-1 text-center">Статус</th>
			    <?php if($type != "confirmed"):?>
			    <th class="text-center col-md-2">Действия</th>
			    <?php endif;?>
			 </tr>
		      </thead>
		      <tbody>
			      <?php
			      $class_array = array(
				  "-3"	=>	array("label-inverse", "Отменен"),
				  "-2"	=>	array("label-info", "Новый"),
				  "0"	=>	array("label-warning", "Ожидает"),
				  "-1"	=>	array("label-danger", "Отклонен"),
				  "1"	=>	array("label-success", "Подтвержден")
			      );
			      ?>
			      <?php foreach($result->result() AS $request):?>
			      <?php $info = json_decode($request->dop_info);?>
			      <tr>
				      <td class="text-center"><nobr><?php echo $request->date;?></nobr></td>
				      <td><a href="<?=base_url();?>offer/view/id/<?=$request->offer_id;?>"><?php echo $request->offer_name;?></a></td>
				      <!--<td class="text-center"><?php echo $request->goal_name;?></td>-->
				      <td class="text-center"><?php echo $request->real_profit;?> руб.</td>
				      <td class="text-center"><?php echo $info->fio;?></td>
				      <td class="text-center"><?php echo $info->phone;?></td>
				      <td class="text-center"><label class="label <?=$class_array[$request->status][0];?>"><?=$class_array[$request->status][1];?></label></td>
				      <?php if($type != "confirmed"):?>
				      <td class="text-center">
					     <nobr>
					     <div class="btn-group btn-sm">
						<button<?=(config_item("change_status_advertiser") === false ? " disabled" : "");?><?=($request->status == "1" ? " disabled" : "");?> type="button" class="btn btn-default btn-sm">Выберите</button>
						<button<?=(config_item("change_status_advertiser") === false ? " disabled" : "");?><?=($request->status == "1" ? " disabled" : "");?> type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm">
						   <span class="caret"></span>
						</button>
						<ul role="menu" class="dropdown-menu">
						   <li><a href="<?=base_url();?>advertiser/stat/status/confirm/<?=$request->id;?>">Подтвердить</a></li>
						   <li><a href="<?=base_url();?>advertiser/stat/status/pending/<?=$request->id;?>">Ожидает</a></li>
						   <li><a href="<?=base_url();?>advertiser/stat/status/deflect/<?=$request->id;?>">Отклонить</a></li>
						   <li><a href="<?=base_url();?>advertiser/stat/status/cancel/<?=$request->id;?>">Отменить</a></li>
						</ul>
					     </div>
					     </nobr>
				      </td>
				      <?php endif;?>
			      </tr>
			      <?php endforeach;?>
		      </tbody>
		   </table>
		</div>
		<!-- END table-responsive-->
   
	</div>
   
</div>
<!-- END panel-->
