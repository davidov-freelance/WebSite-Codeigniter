<h3><?=$title;?></h3>

<link rel="stylesheet" href="<?=base_url();?>app/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css">
<script src="<?=base_url();?>app/vendor/moment/min/moment-with-langs.min.js"></script>
<script src="<?=base_url();?>app/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css" />
<link rel="stylesheet" href="" />
<script src="<?=base_url();?>app/vendor/chosen/chosen.jquery.min.js"></script>



<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/ColVis/css/dataTables.colVis.css">

<!-- Data Table Scripts-->
<script src="<?=base_url();?>app/vendor/datatable/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrapPagination.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/ColVis/js/dataTables.colVis.min.js"></script>

<script>
function get_goals() {
	$.get('<?=base_url();?>admin/ind/goals/' + $('#offer').val(), function(data) {
		$('#goal').html(data);
	});
}
$(document).ready(function(){
	$(".chosen-select").chosen();
});
</script>

<div class="panel panel-default">
	<div class="panel-body">
		<form method="post" action="">
			<fieldset style="border-bottom: 0; margin-bottom: 0;">

				<div class="col-md-3">
					<label>Вебмастер</label>
					<select name="new[user_id]" class="form-control chosen-select">
						<?php foreach($webmasters as $w): ?>
						<option value="<?=$w->id;?>"><?=$w->email;?></option>
						<?php endforeach;?>
					</select>
				</div>

				<div class="col-md-3">
					<label>Оффер</label>
					<select name="tmp" class="form-control chosen-select" onchange="get_goals();" id="offer">
						<option value="0">- выбор</option>
						<?php foreach($offers as $o):?>
						<option value="<?=$o->id;?>"><?=$o->name;?></option>
						<?php endforeach;?>
					</select>
				</div>

				
				<div class="col-md-3">
					<label>Цель</label>
					<select name="new[goal_id]" class="form-control chosen-select" id="goal">
						<option value="0">-</option>
					</select>
				</div>

				<div class="col-md-2">
					<label>Новая цена</label>
					<input type="text" name="new[price]">
				</div>

			</fieldset>
			<div class="panel-footer text-center">
				<button type="submit" class="btn btn-info">Добавить</button>
			</div>
		</form>
	</div>
</div>

<!-- START panel-->
<div class="panel panel-default">

	<div class="panel-body">
		<!-- START table-responsive-->
		<div class="table-responsive">
		   <table data-table="true" class="table table-bordered table-hover">
		    <thead>
			<tr class="info">
			    <th class="col-md-2">Вебмастер</th>
			    <th class="col-md-2">Оффер</th>
			    <th class="col-md-2">Цель</th>
			    <th class="col-md-1">Старая оплата</th>
			    <th class="col-md-1">Новая оплата</th>
			    <th class="col-md-1 text-center">Действия</th>
			</tr>
		    </thead>
		      <tbody>
			      <?php foreach($rows as $row): ?>
			      <tr>
						<td><?php echo $row->user;?></td>
						<td><?php echo $row->offer_name;?></td>
						<td><?php echo $row->goal_name;?></td>
						<td class="text-center"><?php echo $row->old_price;?> руб.</td>
						<td class="text-center"><?php echo $row->price;?> руб.</td>
				      	<td class="text-center">
					    	<a class="btn btn-warning btn-sm" title="Удалить" href="<?=base_url();?>admin/ind/delete/<?=$row->id;?>" onclick="return confirm('Удалить запись?');"><i class="fa fa-times"></i></a>
				      	</td>
			      </tr>
			      <?php endforeach; ?>
		      </tbody>
		   </table>
		</div>
		<!-- END table-responsive-->
   
	</div>
   
</div>