
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/ColVis/css/dataTables.colVis.css">
<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css" />
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css">

<!-- Data Table Scripts-->
<script src="<?=base_url();?>app/vendor/datatable/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrapPagination.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/ColVis/js/dataTables.colVis.min.js"></script>

<script src="<?=base_url();?>app/vendor/moment/min/moment-with-langs.min.js"></script>
<script src="<?=base_url();?>app/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<h3>
	<?=$title;?>
</h3>
<!-- START panel-->

<div class="panel panel-default">
	<div class="panel-body">
		
		<div class="row">
		<form method="post">
			<div class="col-md-3">
				<div class="form-group">

					<div data-date-format="YYYY-MM-DD" data-pick-time="false" class="datetimepicker input-group date mb-lg">
						<input value="<?=checkStr($this->input->post("from_date"));?>" type="text" class="form-control" name="from_date" placeholder="Выводить с">
						<span class="input-group-addon">
						   <span class="fa-calendar fa"></span>
						</span>
					</div>

				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">

					<div data-date-format="YYYY-MM-DD" data-pick-time="false" class="datetimepicker input-group date mb-lg">
						<input value="<?=checkStr($this->input->post("to_date"));?>" type="text" class="form-control" name="to_date" placeholder="По">
						<span class="input-group-addon">
						   <span class="fa-calendar fa"></span>
						</span>
					</div>

				</div>
			</div>
			<div class="col-md-1">
				<button type="submit" class="btn btn-info">Поиск</a>
			</div>
		</form>
		</div>
	</div>
</div>

<div class="panel panel-default">

<div class="panel-body">
   <!-- START table-responsive-->
   <div class="table-responsive">
	   
				<table data-table="true" class="table table-striped table-bordered">
				   <thead>
				      <tr>
					 <th class="text-center col-md-2">Дата</th>
					 <th class="text-center">Статус</th>
					 <th class="text-center col-md-2">Сумма</th>
				      </tr>
				   </thead>
				   <tbody>
					   <?php foreach($result AS $row):?>
					   <tr>
						   <td class="text-center"><?=$row->date;?></td>
						   <td class="text-center">Списано</td>
						   <td class="text-center"><?=$row->sum;?></td>
					   </tr>
					   <?php endforeach;?>
				   </tbody>

				</table>
	   	   
   </div>
</div>
</div>
<!-- END panel-->
