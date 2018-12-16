<h3>Заказы</h3>
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

<!-- START panel-->
<div class="panel panel-default">

	<div class="panel-body">
		<!-- START table-responsive-->
		<div class="table-responsive">
		   <table data-table="true" class="table table-bordered">
		      <thead>
			 <tr>
			    <th class="col-md-2">Оффер</th>
			    <!--<th class="col-md-1 text-center">Цель</th>-->
			    <th class="col-md-10 text-center">Информация о заказе</th>
			 </tr>
		      </thead>
		      <tbody>
			      <?php foreach($orders AS $order):?>
			      <?php $info = json_decode($order->dop_info);?>
			      <tr>
				      <td class="text-center"><nobr><?php echo $order->offer_name;?></nobr></td>
					<td>
						<b>ФИО:</b> <?=$order->fio;?><br/>
						<b>Телефон:</b> <?=$info->phone;?><br/>
						<b>Адрес:</b> <?=$order->address;?><br/>
						<b>Индекс:</b> <?=$order->postcode;?><br/>
						<?php if($order->date != "0000-00-00"):?>
							<b>Желаемая дата доставки:</b> <?=$order->date;?><br/>
						<?php endif;?>
						<?php if($order->time):?>
							<b>Желаемая время доставки:</b> <?=$order->time;?><br/>
						<?php endif;?>	
						<?php if($order->comment):?>
						<b>Комментарий:</b> <?=$order->comment;?>
						<?php endif;?>
					</td>
			      </tr>
			      <?php endforeach;?>
		      </tbody>
		   </table>
		</div>
		<!-- END table-responsive-->
   
	</div>
   
</div>
<!-- END panel-->
