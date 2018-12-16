
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
	<div class="pull-right">
		<div class="btn-group">
			<?php foreach($urls AS $url):?>
				<a href="<?=$url["url"];?>" class="btn btn-default<?=($type == $url["type"] ? " active" : "");?>"><?=$url["name"];?></a>
			<?php endforeach;?>
		</div>
	</div>
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
	   
		<?php if($type == "leads"):?>
		
			<table data-table="true" class="table table-striped table-bordered">
				<thead>
				   <tr>
				      <th class="text-center col-md-1">Дата</th>
				      <th class="">Оффер</th>
				      <th class="col-md-2 text-center">Страница</th>
				      <th class="col-md-2 text-center">Цель</th>
				      <th class="col-md-1 text-center">Заработок</th>
				      <th class="text-left">Данные</th>
				   </tr>
				</thead>
				<tbody>
					<?php
					$class_array = array(
					    "-2"	=>	"warning",
					    "0"		=>	"waring",
					    "-1"	=>	"danger",
					    "1"		=>	"success"
					);
					?>
					<?php foreach($result->result() AS $request):?>
					<?php 
						  $info = json_decode($request->dop_info);
						  if(isset($info->fio))
						  {
							  $fioAr = explode(" ", $info->fio);
							  $fio = "";
							  foreach($fioAr AS $name)
							  {
								  $fio .= substr($name, 0, count($name) - 3) . "***" . " ";
							  }
						  }
						  else
							  $fio = "Неверно введено";
						  if(isset($info->phone))
							  $phone = substr($info->phone, 0, count($info->phone) - 5) . "***";
						  else
							  $phone = "Неверно введено";					
					?>
					<tr class="<?=$class_array[$request->status];?>">
						<td class="text-center">
							<nobr><?php echo $request->date;?></nobr><br/>
							в <?php echo $request->time;?>
						</td>
						<td><a href="<?=base_url();?>offer/view/id/<?=$request->offer_id;?>"><?php echo $request->offer_name;?></a></td>
						<td class="text-center"><a href="<?=$request->page_url;?>" target="_blank"><?php echo $request->page_name;?></a></td>
						<td class="text-center"><?php echo $request->goal_name;?></td>
						<td class="text-center"><?php echo $request->profit;?> руб.</td>
						<td class="text-left">
							ФИО: <?php echo $fio;?><br/>
							Телефон: <?php echo $phone;?>
						</td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
	   
		<?php else:?>
	   
				<table data-table="true" class="table table-striped table-bordered">
				   <thead>
					   <tr class="info">
						   <td<?=(isset($num_columns) ? " colspan='".$num_columns."'" : "");?>></td>
						   <td class="text-center">Трафик</th>
						   <td colspan="2" class="text-center">Коэффициенты</td>
						   <td colspan="4" class="text-center">Конверсии</td>
						   <td colspan="4" class="text-center">Финансы</td>
					   </tr>
				      <tr>
					 <th class="text-center"><?php echo $one_column;?></th>
					 <?php if(isset($two_column)):?>
					 <th class="text-center"><?php echo $two_column;?></th>
					 <?php endif;?>
					 <?php if(isset($three_column)):?>
					 <th class="text-center"><?php echo $three_column;?></th>
					 <?php endif;?>  
					 <?php if(isset($four_column)):?>
					 <th class="text-center"><?php echo $four_column;?></th>
					 <?php endif;?>                                         
					 <th class="text-center">Клики</th>
					 <th class="text-center">CR%</th>
					 <th class="text-center">EPC</th>
					 <th class="text-center">Всего</th>
					 <th class="text-center">Принято</th>
					 <th class="text-center">Ожидают</th>
					 <th class="text-center">Отклонено</th>
					 <th class="text-center">Всего</th>
					 <th class="text-center">Зачислено</th>
					 <th class="text-center">Ожидают</th>
					 <th class="text-center">Отклонено</th>
				      </tr>
				   </thead>
				   <tbody>
					   <?php foreach($result AS $key => $row):?>
						  <?php $sum_profit = $row["profit_confirm"] + $row["profit_pending"] + $row["profit_reflected"];?>
					   <tr>
						   <?php if(isset($two_column)){
							   $subs = explode(" - ", $key);
							   $key = $subs[0];
							   $row["two"] = $subs[1];
						   }
						   ?>
						   <td class="text-center"><?php echo (strlen($key) > 25 ? mb_substr($key, 0, 25) . "..." : $key);?></td>
						   <?php if(isset($two_column)):?>
							  <td class="text-center"><?=$row["two"];?></td>
						   <?php endif;?>			 
						  <?php if($this->user_model->isAdmin()):?>
							  <?php switch($type){
								  case "days": 
									  $url_transits = base_url() . "admin/visitors/index/" . $this->stat_model->getUserId() . "/" . $key . "/" . $key;
									  break;
								  case "flows":
									  $url_transits = base_url() . "admin/visitors/index/" . $this->stat_model->getUserId() . "/0/0/" . $row["flow_id"];
									  break;
								  case "offers":
									  $url_transits = base_url() . "admin/visitors/index/" . $this->stat_model->getUserId() . "/0/0/0/" . $row["offer_id"];
									  break;
							  }			 
							  ?>

						   <?php /* <td class="text-center"><a href="<?=$url_transits;?>"><?=$row["click_all"];?></a></td> */ ?>
						   <td class="text-center"><?=$row["click_all"];?></td>
						   <?php else:?>
						   <td class="text-center"><?=$row["click_all"];?></td>
						   <?php endif;?>
						   <td class="text-center"><?=getConversion($row["requests_all"], $row["click_all"], false);?></td>
						   <td class="text-center"><?=getEPC($row["profit_confirm"], $row["click_all"], false);?></td>
						   <td class="text-center"><?=$row["requests_all"];?></td>
						   <td class="text-center"><?=$row["requests_confirm"];?></td>
						   <td class="text-center"><?=$row["requests_pending"];?></td>
						   <td class="text-center"><?=$row["requests_reflected"];?></td>
						   <td class="text-center"><?=getNormalMoney($sum_profit);?></td>
						   <td class="text-center"><?=getNormalMoney($row["profit_confirm"]);?></td>
						   <td class="text-center"><?=getNormalMoney($row["profit_pending"]);?></td>
						   <td class="text-center"><?=getNormalMoney($row["profit_reflected"]);?></td>
					   </tr>
					   <?php endforeach;?>
				   </tbody>

				</table>
	   
		<?php endif;?>
	   
   </div>
</div>
</div>
<!-- END panel-->
