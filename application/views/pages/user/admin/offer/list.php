
<?php $countriesAll = config_item("countries");
$cats = config_item("cats");
?>

<div class="portlet light bordered form-fit">

	<div class="portlet-title">
		<div class="caption">
			<i class="icon-list font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase">Список офферов</span>
		</div>
		<div class="actions row">
			<div class="col-md-8">
				<select data-type="datatable_select" data-td-num="0" class="form-control" id="chooseCat">
					<option value="0">выберите категорию</option>
					<?php foreach($cats AS $key => $value):?>
						<option value="<?=$key;?>"><?=$value;?></option>
					<?php endforeach;?>
				</select>

			</div>
			<div class="col-md-4">
			<a href="/admin/offer/add"> <button class="btn green-haze"><i class="icon-plus"></i> Добавить</button></a>
			</div>
		</div>
	</div>

	<div class="panel-body">
		<div class=" portlet-tabs">


			<ul class="nav nav-tabs">
				<li<?php if($type):?> class="active"<?php endif;?>>
					<a href="<?=base_url();?>admin/offer/list"  aria-expanded="true">Активные</a>
				</li>
				<li<?php if(!$type):?> class="active"<?php endif;?>>
					<a href="<?=base_url();?>admin/offer/list/moderation">На модерации</a>

				</li>

			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="portlet_tab2">
					<table class="table table-striped table-hover table-bordered dataTable no-footer" id="sample_editable_1" role="grid" aria-describedby="sample_1_info">
						<thead>

						<tr>
							<th class="hide"></th>
							<th class="text-center">ID</th>
							<th></th>
							<th>Оффер</th>
							<th>Цели</th>
							<th>Гео и стоимость</th>

							<th>Действия</th>
						</tr>
						</thead>
						<tbody>
						<?php if( !count( $result ) ): ?>
						<tr>

							<td colspan="7" class="text-center">Ничего не найдено</td>

						</tr>

						<?php endif; ?>
						<?php foreach($result AS $offer):?>
							<tr>
								<td class="hide">Все, <?=$cats[$offer->cat];?></td>
								<td><?=$offer->id;?></td>
								<td>
									<div class="text-center">
										<?php if( $offer->image ):?>
										<a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><img src="<?=base_url();?>/files/images/offers/<?=$offer->id;?>/<?=$offer->image;?>" alt="Image" class="image-offers" style="width: 35px; height: 35px;" /></a>
										<?php endif; ?>
									</div>
								</td>
								<td>
									<a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><?=$offer->name;?></a>
									<?php if( $offer->private ):?>
										<br><small class="font-red">приватный оффер</small>
									<?php endif; ?>
								</td>


								<td width="200px">
									<?php
									$goals = $this->offer_info->my_get_goals($offer->id);
									if( count($goals ) ):
									?>
									<select class="bs-select offer-goal-list"  style="" data-offer="<?=$offer->id;?>">
										<?php foreach($goals AS $key=>$row): ?>
											<option value="<?=$row->id;?>"><?=$row->name;?></option>
										<?php endforeach;?>
									</select>
									<? else: ?>
									Целей пока нет
									<? endif; ?>
								</td>

								<td id="geoData<?=$offer->id;?>" style="width:200px;">
									<?php

										$geo = $this->offer_info->getBunches( ["goal_id"=>$goals['0']->id] );
										if( count( $geo ) ):
										foreach( $geo as $geo_one ) :?>
											<div>
												<div class="pull-left"><?=($geo_one->city)?$geo_one->city:$geo_one->country_name;?></div>
												<div class="pull-right">
													<?=$geo_one->price;?> <i class="fa fa-rub"></i>
												</div>
											</div>
											<br>
										<?
										endforeach;
									else: echo "Нет ни одной связки";
									endif;
									?>

								</td>

								<td align="center">
									<nobr>
										<?php if($offer->type == '1'):?>
											<a href="<?=base_url();?>admin/offer/take_moderation/stop/<?=$offer->id;?>"  onclick="if(!confirm('Вы уверены, что хотите остановить данный оффер?') return false;)"><em class="glyphicon glyphicon-pause"></em></a>
										<?php else:?>
											<a href="<?=base_url();?>admin/offer/take_moderation/solve/<?=$offer->id;?>"  onclick="if(!confirm('Вы уверены, что хотите запустить данный оффер?') return false;)"><em class="glyphicon glyphicon-play"></em></a>
										<?php endif;?>
										<a href="<?=base_url();?>admin/offer/edit/<?=$offer->id;?>"><em class="glyphicon glyphicon-pencil"></em></a>
										<a href="<?=base_url();?>admin/offer/delete/<?=$offer->id;?>" class="font-red" onclick="return confirm('Вы уверены, что хотите удалить данный оффер?');"><em class="glyphicon glyphicon-remove"></em></a>
									</nobr>
								</td>


							</tr>
						<?php endforeach;?>
						</tbody>

					</table>
				</div>
			</div>
		</div>


	</div>
</div>


<script type="text/javascript" src="/app/admin/pages/scripts/offer.js"></script>