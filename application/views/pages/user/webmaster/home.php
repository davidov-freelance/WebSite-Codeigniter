<!-- BEGIN PAGE HEAD -->
<div class="page-head">
	<!-- BEGIN PAGE TITLE -->
	<div class="page-title">
		<h1>Панель управления <small>статистика и быстрые ссылки</small></h1>
	</div>
	<!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD -->

<!-- BEGIN PAGE CONTENT INNER -->
<div class="row margin-top-10">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-blue-sharp"><?=getNormalMoney($this->user_model->info->money);?><small class="font-blue-sharp"> ₽</small></h3>
					<small>Ваш баланс</small>
				</div>
				<div class="icon">
					<i class="icon-wallet"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-red red-sharp"></span>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-green-sharp"><?=getNormalMoney($requests_profit, false);?><small class="font-green-sharp"> ₽</small></h3>
					<small>Общая прибыль</small>
				</div>
				<div class="icon">
					<i class="icon-pie-chart"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success green-sharp"></span>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-blue-sharp"><?= getNormalMoney($requests_count, false);?></h3>
					<small>Лиды</small>
				</div>
				<div class="icon">
					<i class="icon-basket"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp"></span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-purple-soft"><?=getNormalMoney($transits_count, false);?></h3>
					<small>Уников</small>
				</div>
				<div class="icon">
					<i class="icon-user"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success purple-soft"></span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">


	<div class="col-md-6 col-sm-12">
		<!-- BEGIN PORTLET-->
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption caption-md">
					<i class="icon-bar-chart theme-font-color hide"></i>
					<span class="caption-subject theme-font-color bold uppercase">Новые офферы</span>
					<span class="caption-helper">всего новых <?=count($newOffers);?></span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="scroller" style="height: 350px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
					<div class="general-item-list">


						<?php
						$i = 0;
						foreach($newOffers AS $offer):$i++;?>
							<div class="item">
								<div class="item-head">
									<div class="item-details">
										<? if( !empty( $offer->image ) ): ?>
											<img class="item-pic dashboard-offer" src="<?=base_url();?>files/images/offers/<?=$offer->id;?>/<?= $offer->image;?>">
										<? endif; ?>

										<? if( !$offer->access_data['status']  ):?>
										<a data-toggle="modal" href="#access" class="item-name primary-link">
											<?php else:?>

											<a href="<?=base_url();?>offer/view/id/<?=$offer->id;?>" class="item-name primary-link"><?php endif; ?>

												<?=$offer->name;?>
											</a>



											<span class="item-label"><?=showDate($offer->added);?></span>

									</div>

									<span class="item-status"><span class="badge badge-empty badge-success"></span> </span>

								</div>

								<div class="item-body clip">
									<div class="item-offer-status"><? if( $offer->access_data['status'] ):?><small class="font-green"><?=$offer->access_data['msg'];?></small><?endif;?><? if( !$offer->access_data['status']  ):?><small class="font-red"><?=$offer->access_data['msg'];?></small><?endif;?></div><br/>
									<?=$offer->small_descr;?>
								</div>
							</div>


						<?php endforeach;?>

					</div>
				</div>
			</div>
		</div>
		<!-- END PORTLET-->
	</div>


	<div class="col-md-6 col-sm-6">
		<!-- BEGIN PORTLET-->
		<div class="portlet light">
			<div class="portlet-title tabbable-line">
				<div class="caption caption-md">
					<span class="caption-subject theme-font-color bold uppercase">Информация и инструменты</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="scroller" style="height: 337px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
					<ul class="feeds">
						<?php foreach( $helper as $help ): ?>
							<li>
								<a href="<?=$help->link;?>" target="_blank">
									<div class="col1">
										<div class="cont">
											<div class="cont-col1">
												<div class="label label-sm label-<?=$help->label;?>">
													<i class="fa fa-<?=$help->icon;?>"></i>
												</div>
											</div>
											<div class="cont-col2">
												<div class="desc">
													<?=$help->title;?>
												</div>
											</div>
										</div>
									</div>
									<div class="col2">
										<div class="date">
											<?=showDate($help->add_time);?>
										</div>
									</div>
								</a>
							</li>
						<?php endforeach;?>

					</ul>
				</div>

			</div>
			<!--END TABS-->
		</div>
	</div>
	<!-- END PORTLET-->
</div>
</div>



<script src="/app/admin/pages/scripts/index3.js" type="text/javascript"></script>