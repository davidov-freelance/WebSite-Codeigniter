



<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-call-in font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase"><?=$title;?></span>
			<span class="caption-helper"> список предложений</span>
		</div>
		<div class="pull-right">
			<?php if($type == "myweb"):?>
				<a class="btn btn-sm default dropdown-toggle" href="/offer/list" id="countriesTable_new">
					<i class="icon-star"></i> все офферы</a>
			<?php else: ?>
			<a class="btn btn-sm default dropdown-toggle" href="/offer/my" id="countriesTable_new">
				<i class="icon-star"></i> мои офферы</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="portlet-body form">
		<p>
		<?php if($type == "myweb"):?>
			Офферы, с которыми вы работаете.
		<?php else: ?>
			Список всех доступных вам офферов. После того, как вы добавите оффер, он появится в разделе "Мои оффер", где вы сможете сгенерировать ссылки.
		<?php endif; ?>
			</p>
		<table data-table="true" class="table table-bordered table-hover"  id="user">
			 <thead>
				<tr>
					<th class="hide"></th>
				   	<th></th>
				   	<th>Оффер</th>
				   	<th>Цели</th>
				   	<th>Стоимость</th>
					<th class="text-center">EPC</th>
					<th class="text-center">CR</th>
				    <?php if($this->user_model->info->type == 0):?>
				    <th>Добавить</th>
				   	<?php endif;?>
					<?php if($type == "myweb"):?> <th>Создать поток</th>
					<?php endif;?>
				</tr>
			 </thead>
			<tbody>
			 	<?php foreach($result AS $offer):?>
				<tr>
					<td class="hide">Все, <?=$cats[$offer->cat];?></td>
				   	<td>
				       <div class="text-center">
						   <?php if( $offer->image ):?>
						   <? if( !$offer->access_data['status']  ):?>
						   <a data-toggle="modal" href="#access">
							   <?php else:?>

							   <a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><?php endif;?><img src="<?=base_url();?>/files/images/offers/<?=$offer->id;?>/<?=$offer->image;?>" alt="Image" class="image-offers" style="width: 35px; height: 35px;" /></a>
						   <?php endif; ?>

				       </div>
				    </td>
				    <td>
						<? if( !$offer->access_data['status']  ):?>
						<a data-toggle="modal" href="#access">
						<?php else:?>
					    <a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>"><?php endif; ?><?=$offer->name;?></a><br>
						<? if( $offer->access_data['status'] ):?><small class="font-green"><?=$offer->access_data['msg'];?></small><?endif;?><? if( !$offer->access_data['status']  ):?><small class="font-red"><?=$offer->access_data['msg'];?></small><?endif;?>
				    </td>
				   <td width="200px" class="chooseGoals text-center"  style="vertical-align: middle;">
					   <?php if( count( $offer->goals ) ) :?>

					   <select class="form-control bs-select offer-goal-list" style="" data-offer="<?=$offer->id;?>">
						   <?php foreach($offer->goals AS $key=>$row): ?>
							   <option value="<?=$row->id;?>"><?=$row->name;?></option>
						   <?php endforeach;?>
					   </select>



						   <? else: ?>
						    Целей пока нет
					   <? endif; ?>
				   </td>

				   <td id="geoData<?=$offer->id;?>">
					   <?php

						   $geo = $this->offer_info->getBunches( ["goal_id"=>$offer->goals['0']->id] );
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
					<td class="text-center"><?php echo getEPC($offer->profits, $offer->transits);?></td>
					<td class="text-center"><?php echo getConversioN($offer->requests, $offer->transits);?></td>
				   <?php if($this->user_model->info->type == 0):?>
				   <td align="center">
				   <nobr>
					   <?php if($type == "all"):?>
						   <?php if($offer->is_my == 0 ):?>
							   <?php if($offer->type == "1" ):?>
							<a data-toggle="tooltip" data-original-title="Добавить" href="<?=base_url();?>webmaster/offer/operation/add/<?=$offer->id;?>" class="btn btn-sm green">
									Добавить <i class="icon-plus">
									</i></a>
								<? endif;?>
						   <?php else:?>
							<a data-toggle="tooltip" onclick="if(confirm('Вы уверены, что хотите удалить?'))return true; return false;" data-original-title="Убрать" href="<?=base_url();?>webmaster/offer/operation/delete/<?=$offer->id;?>" class="btn btn-sm red">Удалить <i class="icon-minus">
								</i></a>
						<?php endif;?>
					<?php elseif($type == "myweb"):?>
						   <? if( ($offer->private AND $offer->private_offer )  OR !$offer->private ): ?>
						   <a data-toggle="tooltip" onclick="if(confirm('Вы уверены, что хотите удалить?'))return true; return false;" data-original-title="Убрать" href="<?=base_url();?>webmaster/offer/operation/delete/<?=$offer->id;?>" class="btn btn-sm red">Удалить<i class="icon-minus"><? endif; ?>
							   </i></a>
					<?php endif;?>
				   </nobr>
				   </td>
					   <?php if($type == "myweb"):?>
						   <td>
							   <? if( $offer->access_data['status'] ): ?>
							   <a  data-toggle="tooltip" data-original-title="Создать поток" href="<?=base_url();?>webmaster/flow/add/<?=$offer->id;?>" class="btn btn-sm green">Создать поток <i class="icon-shuffle"></i></a> <? endif; ?>

						   </td>
					   <?php endif;?>
				   <?php endif;?>				   
				</tr>
			<?php endforeach;?>
		 </tbody>
		 
	      </table>


	</div>
</div>

