<?php // <?=($type == "open" ? " active" : ""); ?>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN TODO CONTENT -->
		<div class="todo-content">
			<div class="portlet light">
				<!-- PROJECT HEAD -->
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-green-sharp hide"></i>
						<span class="caption-helper"><?php echo $title; ?></span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase"></span>
					</div>
					<div class="actions">
						<div class="btn-group">
							<a class="btn green-haze btn-circle btn-sm" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								Опции <i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="/tickets">
										<i class="i"></i> Создать </a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="/tickets/lists/open">
										Открытые <span class="badge badge-success">
												<?=$tickets_count['open']?> </span>
									</a>
								</li>
								<li>
									<a href="/tickets/lists/close">
										Закрытые <span class="badge badge-danger">
												<?=$tickets_count['close']?>  </span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end PROJECT HEAD -->
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-5 col-sm-4">
							<div class="scroller" style="max-height: 500px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7">
								<div class="todo-tasklist">

									<?php if( count( $ticket ) ): ?>
									<?php foreach($ticket as $list):?>
										<div class="todo-tasklist-item todo-tasklist-item-border-green">
											<a href="javascript:;" data-ticket-id="<?php echo $list->id;?>">

											<img class="todo-userpic pull-left" src="/app/admin/layout4/img/avatar4.jpg" width="27px" height="27px">
											<div class="todo-tasklist-item-title"><?php echo $list->login;?>
											</div>

											<div class="todo-tasklist-item-text">
												<?php echo $list->title; ?>
											</div>

											<div class="todo-tasklist-controls pull-left">
												<span class="todo-tasklist-date"><i class="fa fa-calendar"></i>
													<?php echo $list->date; ?> </span>
												<span class="todo-tasklist-badge badge badge-roundless">
													<?php echo ($list->message_num);?></span>

											</div>
											</a>

										</div>


									<?php endforeach;

									else: ?>
										<br>
										<div class="well">
											Не найдено ни одного открытого тикета
										</div>

									<? endif;
									?>

								</div>
							</div>
						</div>
						<div class="todo-tasklist-devider">
						</div>
						<div class="col-md-7 col-sm-8">
							<div class="loading-block hide"> <img src="/app/admin/layout4/img/ajax-loading.gif"></div>
							<div class="scroller" style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7" id="ticketView">

									<?php if( $action == "list" ): ?>


									<form id="form_sample_1" class="form-horizontal" method="POST">
									<!-- TASK HEAD -->
									<div class="form">
										<div class="form-group">
											<div class="col-md-8 col-sm-8">
												<div class="todo-taskbody-user">
													<span class="todo-username pull-left">Создать тикет</span>
												</div>
											</div>

										</div>

										<div class="form-group">
											<div class="col-md-12">
												<input type="text" name="title" class="form-control todo-taskbody-tasktitle" placeholder="Тема" required>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
									 			<textarea class="form-control todo-taskbody-taskdesc" rows="8" placeholder="Вопрос" name="text" required></textarea>
											</div>
										</div>
										<?php if($this->user_model->info->type >= 2):?>
										<div class="form-group">
											<div class="col-md-12">
												<input <?=($user_id > 0 ? "value='".$user_id."'" : "");?> type="text" class="form-control todo-taskbody-tasktitle" placeholder="ID пользователя" name="user_id" required>
											</div>
										</div>
										<?php endif;?>

										<div class="form-actions right todo-form-actions">
											<button class="btn btn-circle btn-sm green-haze">Создать</button>

										</div>
									</form>



										<?php endif; ?>



							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END TODO CONTENT -->
	</div>
</div>
<!-- END PAGE CONTENT-->




