<h3>
<?=$title;?>
</h3>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css" />

<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/ColVis/css/dataTables.colVis.css">

<!-- Data Table Scripts-->
<script src="<?=base_url();?>app/vendor/datatable/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrapPagination.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/ColVis/js/dataTables.colVis.min.js"></script>

<!-- START panel-->
<div class="panel panel-default">

	<div class="panel-body">
		<!-- START table-responsive-->
		<div class="table-responsive">
		   <table data-table="true" class="table table-bordered table-hover">
		      <thead>
			 <tr>
			    <th class="text-center col-md-1">Дата</th>
=			    <th class="col-md-3">Тип кошелька</th>
			    <th class="col-md-2">Счет</th>
			    <th class="col-md-2">Сумма</th>
			    <th class="col-md-1 text-center">Оплачен</th>
			    <th class="col-md-3 text-center">Действия</th>
			 </tr>
		      </thead>
		      <tbody>
				<?php foreach($result->result() AS $row):?>
				<tr>
					<td class="text-center"><nobr><?php echo $row->time;?></nobr></td>
=					<td><?=$row->payment_type;?></td>
					<td><?=$row->bill;?></td>
					<td><?=$row->sum;?></td>
					<td class="text-center"><?=($row->paid == "1" ? "Да" : "Нет");?></td>
					<td class="text-center">
						<a class="btn btn-default btn-sm" href="<?=base_url();?>tickets/add/<?=$row->user_id;?>">Написать в тикете</a>
						<a onclick="return confirm('Вы уверены, что хотите оплатить?')" class="btn btn-default btn-sm" href="<?=base_url();?>admin/user/payments/ok/<?=$row->id;?>">Оплатить</a>
					</td>
				</tr>
			      <?php endforeach;?>
		      </tbody>
		   </table>
		</div>
		<!-- END table-responsive-->
   
	</div>
   
</div>