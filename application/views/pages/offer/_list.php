<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/ColVis/css/dataTables.colVis.css">

<!-- Data Table Scripts-->
<script src="<?=base_url();?>app/vendor/datatable/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrapPagination.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/ColVis/js/dataTables.colVis.min.js"></script>

<h3><?=$title;?></h3>

<?php $countriesAll = config_item("countries");
       $cats = config_item("cats");
?>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				<label>Выберите категорию</label>
				<div>
					<select data-type="datatable_select" data-td-num="0" class="form-control" onchange="window.location='?cat='+this.options[this.options.selectedIndex].value">
						<option value="-">Все</option>
						<?php foreach($cats AS $key => $value):?>
							<option value="<?=$key;?>"<?php if ($cat == $key) { echo ' selected'; } ?>><?=$value;?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<label>Выберите страну</label>
				<div>
					<select data-type="datatable_select" data-td-num="6" class="form-control" onchange="window.location='?c='+this.options[this.options.selectedIndex].value">
						<option value="-">Все</option>
						<?php foreach($countriesAll AS $key => $value):?>
							<option value="<?=$key;?>"<?php if ($c == $key) { echo ' selected'; } ?>><?=$value;?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>			
		</div>
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
			    <th class="hide"></th>
                            <th class="text-center">ID</th>
		       <th>Логотип</th>
		       <th>Название</th>
		       <th>Цели</th>
		       <th class="text-center">EPC</th>
		       <th class="text-center">CR</th>
		       <!--<th class="text-center">%</th>-->
		       <th>Таргетинг</th>
		       <?php if($this->user_model->info->type == 0):?>
		       <th>Действия</th>
		       <?php endif;?>
		    </tr>
		 </thead>
		 <tbody>
			 <?php foreach($result AS $offer):?>
				<tr>
					<td class="hide">Все, <?=$cats[$offer->cat];?></td>
                                        <td class="text-center"><?=$offer->id;?></td>
				   <td>
				       <div class="text-center">
					       <a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><img src="<?=base_url();?><?=$offer->image;?>" alt="Image" class="image-offers" /></a>
				       </div>
				    </td>
				    <td>
					    <a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><?=$offer->name;?></a>	
					    <?php /*<br />Цена: <?=$offer->price;?>р*/ ?>
				    </td>
				   <td width="280px">
					<nobr>
						<?php 
						$goals = $this->offer_info->my_get_goals($offer->id);
						foreach($goals AS $goal):
						?>
						<div class="goal-list">
							<div class="pull-left"><?=$goal->name;?></div>
							<div class="pull-right"><!--(<?=$goal->city;?>)&nbsp;&nbsp;--><?=$goal->price;?>р</div>
							<div class="clearfix"></div>
						</div>
						<?php endforeach;?>								
	
					</nobr>
				   </td>
				   <td class="text-center"><?php echo getEPC($offer->profits, $offer->transits);?></td>
				   <td class="text-center"><?php echo getConversioN($offer->requests, $offer->transits);?></td>
				   <!--<td class="text-center"><?php echo getProcentRequests(8, 2);?></td>-->
				   <td>
					   <span class="hide">Все</span>
					<?php
					$countries = explode(", ", $offer->countries);
					foreach($countries AS $cId):
						echo $countriesAll["$cId"] . "<br />";
					endforeach;

					if (!empty($offer->cities)) {
						echo '(' . implode(', ', $offer->cities) . ')';
					}
					?>
				   </td>
				   <?php if($this->user_model->info->type == 0):?>
				   <td align="center">
				   <nobr>
					   <?php if($type == "all"):?>
						<?php if($offer->is_my == 0):?>
							<a data-toggle="tooltip" data-original-title="Добавить" href="<?=base_url();?>webmaster/offer/operation/add/<?=$offer->id;?>" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i></a>
						<?php else:?>
							<a data-toggle="tooltip" data-original-title="Убрать" href="<?=base_url();?>webmaster/offer/operation/delete/<?=$offer->id;?>" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a>
						<?php endif;?>
					<?php elseif($type == "myweb"):?>
					   <a  data-toggle="tooltip" data-original-title="Создать поток" href="<?=base_url();?>webmaster/flow/add/<?=$offer->id;?>" class="btn btn-default btn-sm"><i class="fa fa-random"></i></a>						
					   <a data-toggle="tooltip" data-original-title="Убрать" href="<?=base_url();?>webmaster/offer/operation/delete/<?=$offer->id;?>" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a>
					<?php endif;?>
				   </nobr>
				   </td>
				   <?php endif;?>				   
				</tr>
			<?php endforeach;?>




			<?php if (!empty($result2)): ?>
			<?php foreach($result2 AS $offer):?>
				<tr>
					<td class="hide">Все, <?=$cats[$offer->cat];?></td>
                                        <td class="text-center"><?=$offer->id;?></td>
				   <td>
				       <div class="text-center">
					       <a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><img src="<?=base_url();?><?=$offer->image;?>" alt="Image" class="image-offers" /></a>
				       </div>
				    </td>
				    <td>
					    <a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><?=$offer->name;?></a>
					    <br><small>*оффер приватный, назначен администратором - просмотр ограничен</small>

					    <?php /*<br />Цена: <?=$offer->price;?>р*/ ?>
				    </td>
				   <td width="280px">
					<nobr>
						<?php 
						$goals = $this->offer_info->my_get_goals($offer->id);
						foreach($goals AS $goal):
						?>
						<div class="goal-list">
							<div class="pull-left"><?=$goal->name;?></div>
							<div class="pull-right"><!--(<?=$goal->city;?>)&nbsp;&nbsp;--><?=$goal->price;?>р</div>
							<div class="clearfix"></div>
						</div>
						<?php endforeach;?>								
	
					</nobr>
				   </td>
				   <td class="text-center"><?php echo getEPC($offer->profits, $offer->transits);?></td>
				   <td class="text-center"><?php echo getConversioN($offer->requests, $offer->transits);?></td>
				   <!--<td class="text-center"><?php echo getProcentRequests(8, 2);?></td>-->
				   <td>
					   <span class="hide">Все</span>
					<?php
					$countries = explode(", ", $offer->countries);
					foreach($countries AS $cId):
						echo $countriesAll["$cId"] . "<br />";
					endforeach;

					if (!empty($offer->cities)) {
						echo '(' . implode(', ', $offer->cities) . ')';
					}
					?>
				   </td>
				   <?php if($this->user_model->info->type == 0):?>
				   <td align="center">
				   <nobr>
					   <?php if($type == "all"):?>
						<?php if($offer->is_my == 0):?>
							<a data-toggle="tooltip" data-original-title="Добавить" href="<?=base_url();?>webmaster/offer/operation/add/<?=$offer->id;?>" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i></a>
						<?php else:?>
							<a data-toggle="tooltip" data-original-title="Убрать" href="<?=base_url();?>webmaster/offer/operation/delete/<?=$offer->id;?>" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a>
						<?php endif;?>
					<?php elseif($type == "myweb"):?>
					   <a  data-toggle="tooltip" data-original-title="Создать поток" href="<?=base_url();?>webmaster/flow/add/<?=$offer->id;?>" class="btn btn-default btn-sm"><i class="fa fa-random"></i></a>						
					   <a data-toggle="tooltip" data-original-title="Убрать" href="<?=base_url();?>webmaster/offer/operation/delete/<?=$offer->id;?>" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a>
					<?php endif;?>
				   </nobr>
				   </td>
				   <?php endif;?>
				</tr>
			<?php endforeach;?>
			<?php endif;?>


		 </tbody>
		 
	      </table>
	   </div>
	   <!-- END table-responsive-->

	</div>
   
</div>
<!-- END panel-->
