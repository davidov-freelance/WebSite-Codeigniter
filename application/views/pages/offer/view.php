



<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<?php if( $info->image ):?>
				<img src="<?=base_url();?>/files/images/offers/<?=$info->id;?>/<?=$info->image;?>" class="item-pic offer-image" alt="Image" class="image-offers" style="width: 25px; height: 25px;" />
			<?php else: ?>
				<i class="icon-call-in font-blue-hoki"></i>
			<?php endif; ?>
			<span class="caption-subject font-blue-hoki bold uppercase"><?=$info->name;?></span>
			<span class="caption-helper">просмотр оффера</span>
		</div>
		<div class="actions">
			<?php
			if($this->user_model->info->type == '2' || $this->user_model->info->type == '3') {
				?>


				<?php if ($this->user_model->info->type == '3') { ?>
					<a href="<?= base_url(); ?>admin/offer/edit/<?= $info->id; ?>" class="btn btn-success"
					   type="button"><span class="btn-label"><i class="fa fa-pencil-square-o"></i></span></a>
				<?php }
				if ($info->type == '-1' || $info->type == '0') {
					?>
					<a href="<?= base_url(); ?>admin/offer/take_moderation/solve/<?= $info->id; ?>" name="solve"
					   class="btn btn-success">Разрешить</a>
				<?php
				}
				if ($info->type == '0' || $info->type == '1') {
					?>
					<a href="<?= base_url(); ?>admin/offer/take_moderation/forbid/<?= $info->id; ?>" name="forbid"
					   class="btn btn-danger">Запретить</a>


				<?php
				}
			}
					?>
					<?php
					if($this->user_model->info->type == '0') {
						?>
						<?php if($info->is_my == 0):?>

							<?php if ($info->private == 1): ?>
								<a href="<?=base_url();?>webmaster/flow/add/<?=$info->id;?>" class="btn btn-default  btn-sm" type="button"><span class="btn-label"><i class="fa fa-random"></i></span> Создать поток</a>
							<?php else: ?>
								<a href="<?=base_url();?>webmaster/offer/operation/add/<?=$info->id;?>" class="btn btn-success btn-sm" type="button"><span class="btn-label"><i class="fa fa-plus-circle"></i></span> Добавить</a>
							<?php endif; ?>

						<?php else:?>
							<a onclick="if(confirm('Вы уверены, что хотите удалить?'))return true; return false;" href="<?=base_url();?>webmaster/offer/operation/delete/<?=$info->id;?>" class="btn btn-sm red" type="button">Удалить</a>
							<a href="<?=base_url();?>webmaster/flow/add/<?=$info->id;?>" class="btn btn-default btn-sm" type="button"><i class="fa fa-random"></i> Создать поток</a>
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



				</div>

	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12 blog-page">
				<div class="row">
					<div class="col-md-9 article-block">
						<div class="blog-tag-data">

							<div class="row">
								 <br>
							</div>
						</div>
						<!--end news-tag-data-->
						<div>

							<div class="tabbable tabbable-custom">
								<ul class="nav nav-tabs">
									<li class="active">
										<a data-toggle="tab" href="#tab_1_3" aria-expanded="true">
											Цены </a>
									</li>
									<li>
										<a data-toggle="tab" href="#tab_1_1" aria-expanded="true">
											Лендинги </a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab_1_2" aria-expanded="false">
											Прокладки </a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab_1_3" class="tab-pane active">
										<div class="goal-list">
											<div class="panel-group accordion" id="accordion3">

												<?php foreach($goals AS $row):?>

												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a class="goal_show accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_<?=$row->id;?>"
															   data-goalid="<?=$row->id;?>"  data-infoid="<?=$info->id;?>"><?=$row->name;?></a>
														</h4>
													</div>
													<div id="collapse_<?=$row->id;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
														<div class="panel-body" id="goalGeoData_<?=$row->id;?>">
															Ничего не найдено
														</div>
													</div>
												</div>
												<?php endforeach;?>
											</div>
											<br />
											</div>
									</div>



									<div id="tab_1_1" class="tab-pane">
										<table class="table table-hover">
											<thead>
											<th>Название</th>
											<th>Ссылка</th>
											<th>Статус</th>
											</thead>
										<?php foreach($pages AS $page):?>
											<tr>
												<td><?=$page->name;?></td>
												<td><a href="<?=$page->url;?>" target="_blank"><?=$page->url;?></a></td>
												<td><?php echo getConversion($page->requests_count, $page->transits_count);?></td>
											</tr>
										<?php endforeach;?>
										</table>
									</div>
									<div id="tab_1_2" class="tab-pane">
										<?php if(count($gaskets) > 0):?>
											<table class="table table-hover">
											<?php foreach($gaskets AS $gasket):?>
												<tr>
													<td><a href="<?=$gasket->url;?>" target="_blank"><?=$gasket->name;?></a></td>
													<td><?php echo getConversion($page->requests_count, $page->transits_count);?></td>
												</tr>
											<?php endforeach;?>
											</table>
										<?php else: ?>
											Ничего не найдено.
										<? endif;?>
									</div>
								</div>
							</div>
						</div>

						<p>
							<?=nl2br($info->small_descr);?>
						</p>


					</div>
					<!--end col-md-9-->
					<div class="col-md-3 blog-sidebar">

						<h3 style="margin-top: -3px">Новости оффера</h3>
						<div class="top-news">

							<?php if($news->num_rows() > 0):?>
									<?php foreach($news->result() AS $row):
									$color = "green";
									if( $row->news_type == "info" ) $color = "blue";
									if( $row->news_type == "danger" ) $color = "red";

									?>




									<a href="/news/view/<?=$row->id;?>" data-target=".ajaxNews" data-toggle="modal" class="btn <?=$color;?>">
										<span>
										<?=$row->name;?> </span>
										<em></em>
										<em><?=date("d.m.y", $row->added);?></em>
										<i class="fa fa-book top-news-icon"></i>
									</a>


									<?php endforeach;?>

							<?php endif;?>




						</div>
						<div class="space20">
						</div>
						<h3>Источники</h3>
						<ul class="list-inline sidebar-tags">
							<?php
							$placesAll = config_item("places");
							$places = explode(", ", $info->places);
							foreach($places AS $place){
								echo '<li><a href="#"><i class="fa fa-tags"></i> '.$place.' </a></li>';
							}
							?>

						</ul>
						<div class="space20">
						</div>


						<h3>Аудитория</h3>
						<ul class="list-inline sidebar-tags">

							<?php
							echo '<li><a href="#"><i class="fa fa-tags"></i> ';
							if ($info->sex == 0) { echo 'Мужчины и женщины'; }
							if ($info->sex == 1) { echo 'Мужчины'; }
							if ($info->sex == 2) { echo 'Женщины'; }


							echo '</a></li><li><a href="#"><i class="fa fa-tags"></i> '. str_replace(array('[', ']', ' ', ','), array('', '', '', '-'), $info->age) . ' лет</a></li>';
							?>

						</ul>
						<div class="space20">
						</div>









					</div>
					<!--end col-md-3-->
				</div>
			</div>
		</div>
	</div>
</div>

