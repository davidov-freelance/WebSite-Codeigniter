<h3>
	<img class="offer-image pull-left" src="<?=config_item("base_url");?><?=$info->image;?>" />
	<div class="pull-left" style="margin: 10px 0 0 20px">
		<div class="offer-name">
			<?=$info->name;?>
			<div class="offer-url"><small> <a href="<?=$info->url;?>" target="_blank"><?=$info->url;?></a> </small></div>
		</div>
		<div class=""><small>Цена: <?=$info->price;?>р</small></div>
		<div class="clearfix"></div>
		<div class="offer-action">
		<?php
		if($this->user_model->info->type == '0') {
		?>
			<?php if($info->is_my == 0):?>
			<a href="<?=base_url();?>webmaster/offer/operation/add/<?=$info->id;?>" class="btn btn-success btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-plus-circle"></i></span>Добавить</a>
			<?php else:?>
			<a href="<?=base_url();?>webmaster/offer/operation/delete/<?=$info->id;?>" class="btn btn-danger btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-minus-circle"></i></span>Убрать</a>
			<a href="<?=base_url();?>webmaster/flow/add/<?=$info->id;?>" class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-random"></i></span>Создать поток</a>
			<?php endif;?>
		<?php
		}	
		?>

		<?php
		if($this->user_model->info->type == '2' || $this->user_model->info->type == '3') {
			switch($info->type) {
				case '-1':
				echo "<span class='label label-danger'>Не прошел модерацию</span>";
				break;
				case '0':
				echo "<span class='label label-warning'>На модерации</span>";
				break;
				default:
				echo "";
				break;
			}
		}
		?>
			<!--<button class="btn btn-default btn-labeled btn-sm" type="button"><span class="btn-label"><i class="fa fa-desktop"></i></span>Промо материалы</button>
		--></div>
	</div>
	
	<div class="clearfix"></div>
</h3>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-8">
					<fieldset style="border-bottom: 0">
						<legend>Описание оффера</legend>
						<div><?=$info->small_descr;?></div>
					</fieldset>
					<!--<fieldset style="border-bottom: 0">
						<legend>Описание</legend>
						<div><?=$info->descr;?></div>
					</fieldset>-->
					<?php if($news->num_rows() > 0):?>
						<fieldset style="border-bottom: 0">
							<legend>Новости оффера</legend>
							<?php foreach($news->result() AS $row):?>
								<a href="#" class="list-group-item">
									<div class="media">
										<div class="media-body clearfix">
											<small class="pull-right text-muted"><?=date("d.m.y", $row->added);?></small>
											<strong class="media-heading text-primary"><?=$row->name;?></strong>
											<p class="mb-sm">
											   <small class="text-muted"><?=$row->text;?></small>
											</p>
										</div>
									</div>
								</a>
							<?php endforeach;?>
						</fieldset>
					<?php endif;?>
				</div>
				<div class="col-md-4">
					<fieldset style="border-bottom: 0">
						<legend>Цели</legend>
						<?php foreach($goals AS $row):?>
							<div class="goal-list">
								<div class="pull-left"><?=$row->name;?></div>
								<div class="pull-right">(<?=$row->city;?>)&nbsp;&nbsp;&nbsp;<?=$row->price;?>р</div>
								<div class="clearfix"></div>
							</div>					
						<?php endforeach;?>
					</fieldset>		
					<fieldset style="border-bottom: 0">
						<legend>Лендинги</legend>
						<?php foreach($pages AS $page):?>
							<div class="goal-list">
								<div class="pull-left"><a href="<?=$page->url;?>" target="_blank"><?=$page->name;?></a></div>
								<div class="pull-right"><?php echo getConversion($page->requests_count, $page->transits_count);?></div>
								<div class="clearfix"></div>
							</div>														
						<?php endforeach;?>
					</fieldset>
					<?php if(count($gaskets) > 0):?>
					<fieldset style="border-bottom: 0">
						<legend>Прокладки</legend>
						<?php foreach($gaskets AS $gasket):?>
							<div class="goal-list">
								<div class="pull-left"><a href="<?=$gasket->url;?>" target="_blank"><?=$gasket->name;?></a></div>
								<div class="pull-right"><?php echo getConversion($page->requests_count, $page->transits_count);?></div>
								<div class="clearfix"></div>
							</div>														
						<?php endforeach;?>
					</fieldset>
					<?php endif;?>
					<fieldset style="border-bottom: 0">
						<legend>Гео-таргентинг</legend>
						<div>
							<?php
							$countriesAll = config_item("countries");
							$countries = explode(", ", $info->countries);
							foreach($countries AS $cId):
							echo $countriesAll["$cId"] . ", ";
							endforeach;?>
						</div>
						
					</fieldset>
					<fieldset style="border-bottom: 0">
						<legend>Источники трафика</legend>
						<div>
							<?php
							$placesAll = config_item("places");
							$places = explode(", ", $info->places);
							foreach($places AS $place){
								echo "<div class='pull-left'>".$place."</div><div class='pull-right'><i class='fa fa-check'></i></div>";
								echo "<div class='clearfix'></div>";
								$pos = array_search($place, $placesAll);
								unset($placesAll[$pos]);
							}
							foreach($placesAll AS $place){
								echo "<div class='pull-left'>".$place."</div><div class='pull-right'><i class='fa fa-times'></i></div>";
								echo "<div class='clearfix'></div>";
							}							
							?>
						</div>
						
					</fieldset>					
				</div>
			</div>			
		</div>
	</div>
</div>	

<?php
if($this->user_model->info->type == '2' || $this->user_model->info->type == '3') {
?>

<div class="well">
	<div>

	<?php
	if($info->type == '-1' || $info->type == '0') {
	?>
		<a href="<?=base_url();?>admin/offer/take_moderation/solve/<?=$info->id;?>" name="solve" class="btn btn-success">Разрешить</a>
	<?php
	}
	?>

	<?php
	if($info->type == '0' || $info->type == '1') {
	?>
	<a href="<?=base_url();?>admin/offer/take_moderation/forbid/<?=$info->id;?>" name="forbid" class="btn btn-danger">Запретить</a>
	<?php
	}
	?>

	</div>
</div>

<?php
}
?>
<!--
	<div class="col-md-8">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Описание</h3>
				</div>
				<div class="panel-body">

				</div>
			</div>
	</div>

	<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Цели</h3>
				</div>
				<div class="panel-body">
					<div>
						<div class="pull-left">Покупка</div>
						<div class="pull-right">590 <i class="fa fa-rub"></i></div>
					</div>
					<div class="clearfix"></div>
					<hr>

					<div>
						<div class="pull-left">Подтвержденная заявка</div>
						<div class="pull-right">1090 <i class="fa fa-rub"></i></div>
					</div>				
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Цели</h3>
				</div>
				<div class="panel-body">
					<div>
						<div class="pull-left">Покупка</div>
						<div class="pull-right">590 <i class="fa fa-rub"></i></div>
					</div>
					<div class="clearfix"></div>
					<hr>

					<div>
						<div class="pull-left">Подтвержденная заявка</div>
						<div class="pull-right">1090 <i class="fa fa-rub"></i></div>
					</div>				
				</div>
			</div>		
	</div>
-->