

<div class="portlet light bordered form-fit">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-user font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase"><?=$title;?></span>
			<span class="caption-helper">редактирование данных</span>
		</div>
		<div class="actions">

			<?php  if($this->user_model->isAdmin()): ?>
				<a onclick="return confirm('Удалить пользователя?');" class="btn btn-circle btn-icon-only btn-default" href="/admin/user/delete/<?=$row->id;?>">
					<i class="icon-trash"></i>
				</a>
				<? if( $row->status == 1 ): ?>
				<a onclick="return confirm('Заблокировать пользователя?');" class="btn btn-danger btn-circle" href="/admin/user/status/<?=$row->id;?>/0">
					<i class="icon-lock"></i> Заблокировать
				</a><? else:?>
					<a onclick="return confirm('Заблокировать пользователя?');" class="btn btn-success btn-circle" href="/admin/user/status/<?=$row->id;?>/1">
						<i class="icon-lock-open"></i> Разблокировать
					</a>
					<? endif; ?>
			<?php endif;?>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<form data-parsley-validate id="profileSetting" method="post" action=""  class="form-horizontal form-bordered form-row-stripped">
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">Имя</label>
					<div class="col-md-9 input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i>
						</span>
						<input type="text" placeholder="имя пользователя" class="form-control" name="login" value="<?=$row->login;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Телефон</label>
					<div class="col-md-9 input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i>
						</span>
						<input name="phone" type="text" value="<?=$row->phone;?>" data-toggle="masked" data-inputmask="'mask': '+9 (999) 999-99-99'" placeholder="Введите номер телефона" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Email</label>
					<div class="col-md-9">
						<div class="input-inline<?php  if(!$this->user_model->isAdmin()): ?> input-large<?php endif;?>">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i>
								</span>
								<input name="email" type="text" value="<?=$row->email;?>" class="form-control">
							</div>
						</div>
						<?php  if(!$this->user_model->isAdmin()): ?>
							<span class="help-inline">

							<label><input type="checkbox" name="notices_status" value="1" <? if( $row->notices_status) :?> checked<? endif;?> id="notices_status">получать уведомления</label>

						</span>

							<span class="help-block font-red" <? if( $row->notices_status<1) :?>style="display:none;"<? endif;?> id="notice_info">При отключении уведомлений вы не будете получать никакие уведомления, например об отключении офферов, городов или технических работах. Пожалуйста, не отключайте эту опцию без необходимости.</span>

						<?php endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Skype</label>
					<div class="col-md-9 input-group">
						<span class="input-group-addon"><i class="fa fa-skype"></i>
						</span>
						<input name="skype" type="text" value="<?=$row->skype;?>" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Новый пароль</label>
					<div class="col-md-9">
						<input name="new_password" type="text" class="form-control">
						<span class="help-block">сбросить пароль пользователя</span>
					</div>
				</div>
				<?php  if($this->user_model->isAdmin()): ?>
					<div class="form-group">
						<label class="control-label col-md-3">API key</label>
						<div class="col-md-9 input-group">
							<input class="form-control md-9" name="api_key" value="<?=$row->api_key;?>" id="api_key" />
						<span class="input-group-btn">
						<button class="btn blue" type="button" onclick="genkey();">сгенерировать</button>
						</span>
						</div>
					</div>
				<?php endif; ?>

				<?php  if($this->user_model->isAdmin()): ?>
					<div class="form-group">
						<label class="control-label col-md-3">Тип</label>
						<div class="col-md-9">
							<select name="type" class="form-control">
								<option value="0"<?php if ($row->type == 0) { echo ' selected'; } ?>>Вебмастер</option>
								<option value="1"<?php if ($row->type == 1) { echo ' selected'; } ?>>Рекламодатель</option>
								<option value="3"<?php if ($row->type == 3) { echo ' selected'; } ?>>Админ</option>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-md-3">Холд</label>
						<div class="col-md-9">
							<input class="form-control" name="hold_days" value="<?=$row->hold_days;?>" />
							<span class="help-block">количество дней</span>
						</div>
					</div>

				<?php endif; ?>

				<div class="form-group">
					<label class="control-label col-md-3">WMR</label>
					<div class="col-md-9">
						<input value="<?=$row->wmr;?>" type="text" data-toggle="masked" data-inputmask="'mask': 'R999999999999'" name="wmr" class="form-control"<?if( $row->wmr  ): ?> disabled<? endif;?>>
						<?if( $row->wmr  ): ?>
						<span class="help-block red">кошелёк недоступен для изменения</span>
						<? else: ?>
						<span class="help-block font-red">обращаем ваше внимание: после сохранения кошелёк изменить нельзя</span>
						<? endif; ?>
					</div>
				</div>



			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn green"><i class="fa fa-check"></i> Сохранить</button>
						<a href="/"><button type="button" class="btn default">Отмена</button></a>
					</div>
				</div>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>



<script>
	function randomString(length) {
		return Math.round((Math.pow(36, length + 1) - Math.random() * Math.pow(36, length))).toString(36).slice(1);
	}

	function genkey() {
		$('#api_key').val(randomString(32));
	}
	/*
	 $(document).ready(function(){
	 $('.disable-notfs').click(function () {
	 if( !$(this).hasClass('active') ){
	 $('#email').prop('disabled', true );
	 } else {
	 $('#email').prop('disabled', false );
	 }
	 });
	 }); */
</script>