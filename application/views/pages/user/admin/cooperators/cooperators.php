<h3>
<?=$title;?>
	<a class="btn btn-default pull-right" href="cooperators/add">Добавить</a>
</h3>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css">
<script src="<?=base_url();?>app/vendor/moment/min/moment-with-langs.min.js"></script>
<script src="<?=base_url();?>app/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css" />
<script src="<?=base_url();?>app/vendor/chosen/chosen.jquery.min.js"></script>

<!-- START panel-->
<div class="panel panel-default">

	<div class="panel-body">
		<!-- START table-responsive-->
		<div class="table-responsive">
		   <table class="table">
		      <thead>
			 <tr>
			    <th class="">ФИО</th>
			    <th class="col-md-2 text-center">Телефон</th>
			    <th class="col-md-2 text-center">Емайл</th>
			    <th class="col-md-2 text-center">Пароль</th>
			    <th class="col-md-1 text-center">Статус</th>
			    <th class="text-center col-md-1">Действия</th>
			 </tr>
		      </thead>
		      <tbody>
			      <?php foreach($result->result() AS $row):?>
			      <tr>
				      <td class="text-left"><nobr><?php echo $row->name;?></nobr></td>
				      <td class="text-center"><?php echo $row->phone;?></td>
				      <td class="text-center"><?php echo $row->email;?></td>
				      <td class="text-center"><?php echo $row->password;?></td>
				      <td class="text-center"><?php echo $row->status;?></td>
				      <td class="text-center">
					      <a href="<?=base_url();?>admin/user/cooperators/remove/<?=$row->id;?>" class="btn btn-default btn-sm"><i class="fa fa-times"></i></a>
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
