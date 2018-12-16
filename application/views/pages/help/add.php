

<form action="#" class="form-horizontal">
	<div class="tabbable-line">
		<ul class="nav nav-tabs ">
			<li class="active">
				<a href="#tab_1" data-toggle="tab">
					Обсуждение </a>
			</li>
			<li>
				<a href="#tab_2" data-toggle="tab">
					История </a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				<!-- TASK COMMENTS -->
				<div class="form-group">
					<div class="col-md-12">
						<ul class="media-list">
							<li class="media">
								<div class="media-body todo-comment">
									<p class="todo-comment-head">
										<span class="todo-comment-username">Christina Aguilera</span> &nbsp; <span class="todo-comment-date">17 Sep 2014 at 2:05pm</span>
									</p>
									<p class="todo-text-color">
										Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. <br>
									</p>

								</div>
							</li>

						</ul>
					</div>
				</div>
				<!-- END TASK COMMENTS -->
				<!-- TASK COMMENT FORM -->
				<div class="form-group">
					<div class="col-md-12">
						<ul class="media-list">
							<li class="media">
								<div class="media-body">
									<textarea class="form-control todo-taskbody-taskdesc" rows="4" placeholder="Type comment..."></textarea>
								</div>
							</li>
						</ul>
						<button type="button" class="pull-right btn btn-sm btn-circle green-haze"> &nbsp; Submit &nbsp; </button>
					</div>
				</div>
				<!-- END TASK COMMENT FORM -->
			</div>
			<div class="tab-pane" id="tab_2">
				<ul class="todo-task-history">
					<li>
						<div class="todo-task-history-date">
							20 Jun, 2014 at 11:35am
						</div>
						<div class="todo-task-history-desc">
							Task created
						</div>
					</li>
					<li>
						<div class="todo-task-history-date">
							21 Jun, 2014 at 10:35pm
						</div>
						<div class="todo-task-history-desc">
							Task category status changed to "Top Priority"
						</div>
					</li>
					<li>
						<div class="todo-task-history-date">
							22 Jun, 2014 at 11:35am
						</div>
						<div class="todo-task-history-desc">
							Task owner changed to "Nick Larson"
						</div>
					</li>
					<li>
						<div class="todo-task-history-date">
							30 Jun, 2014 at 8:09am
						</div>
						<div class="todo-task-history-desc">
							Task completed by "Nick Larson"
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>

<div class="panel panel-default">
	<div class="panel-body">
		<form method="POST">
         <div class="form-horizontal">
		<fieldset>
			<legend>Заполнение формы</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">Тема</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="title" required />
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Вопрос</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="text" required rows="8"></textarea>
				</div>
			</div>							
		</fieldset>
		 <?php if($this->user_model->info->type >= 2):?>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Для кого</label>
				<div class="col-sm-2">
					<input <?=($user_id > 0 ? "value='".$user_id."'" : "");?> placeholder="Id пользователя" type="text" class="form-control" name="user_id" required />
				</div>
			</div>							
		</fieldset>
		 <?php endif;?>
		<fieldset>
			<div class="col-sm-4 col-sm-offset-2">
				<a href="<?=base_url()?>tickets/lists/open" class="btn btn-default">Вернуться к списку</a>
				<button type="submit" class="btn btn-primary">Добавить тикет</button>
			</div>
		</fieldset>
		</div>
		</form>
	</div>
</div>