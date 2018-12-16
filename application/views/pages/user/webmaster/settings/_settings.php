<h3><?=$title;?></h3>
<script src="<?=base_url();?>app/vendor/inputmask/jquery.inputmask.bundle.min.js"></script> 
<script src="<?=base_url();?>app/vendor/parsley/parsley.min.js"></script>



<script>
function randomString(length) {
    return Math.round((Math.pow(36, length + 1) - Math.random() * Math.pow(36, length))).toString(36).slice(1);
}

function genkey() {
	$('#api_key').val(randomString(32));
}
</script>

<div class="panel panel-default">
	
	<div class="panel-body">
		<ul class="nav nav-tabs">
		   <li class="active"><a href="#profile" data-toggle="tab">Профиль</a></li>
		</ul>
		
		<div class="tab-content">
			<div id="profile" class="tab-pane fade active in">
				
				<form data-parsley-validate id="myData" method="post" action=""  class="form-horizontal">

					<?php if($this->user_model->isAdmin()):?>
						<fieldset>
							<legend>Личные данные</legend>
							<div class="form-group">
								<div class="col-sm-2 control-label">Тип</div>
								<div class="col-sm-4">
									<select name="type">
										<option value="0"<?php if ($row->type == 0) { echo ' selected'; } ?>>Вебмастер</option>
										<option value="1"<?php if ($row->type == 1) { echo ' selected'; } ?>>Рекламодатель</option>
										<option value="3"<?php if ($row->type == 3) { echo ' selected'; } ?>>Админ</option>
									</select>
									
								</div>
							</div>
						 </fieldset>
						<fieldset>
							<div class="form-group">
								<div class="col-sm-2 control-label">Имя в топе</div>
								<div class="col-sm-4">
									<input class="form-control" name="login" value="<?=$row->login;?>" />
								</div>
							</div>
						 </fieldset>
						<fieldset>
							<div class="form-group">
								<div class="col-sm-2 control-label">Телефон</div>
								<div class="col-sm-4">
									<input name="phone" type="text" value="<?=$row->phone;?>" data-toggle="masked" data-inputmask="'mask': '+9 (999) 999-99-99'" placeholder="Введите номер телефона" class="form-control">
								</div>
							</div>
						 </fieldset>	
						<fieldset>
							<div class="form-group">
								<div class="col-sm-2 control-label">Email</div>
								<div class="col-sm-4">
									<input required name="email" type="text" value="<?=$row->email;?>" class="form-control">
								</div>
							</div>
						 </fieldset>
						 <fieldset>
							<div class="form-group">
								<div class="col-sm-2 control-label">Новый пароль</div>
								<div class="col-sm-4">
									<input name="new_password" type="text" value="" class="form-control">
								</div>
							</div>
						 </fieldset>

						<fieldset>
							<div class="form-group">
								<div class="col-sm-2 control-label">Skype</div>
								<div class="col-sm-4">
									<input value="<?=$row->skype;?>" type="text" name="skype" placeholder="Введите скайп" class="form-control">
								</div>
							</div>
						 </fieldset>
						<fieldset>
							<div class="form-group">
								<div class="col-sm-2 control-label">Api Key</div>
								<div class="col-sm-4">
									<input class="form-control" name="api_key" value="<?=$row->api_key;?>" id="api_key" />
									<br>
									<button type="button" class="btn btn-xs btn-warning" onclick="genkey();">сгенерировать ключ</button>
								</div>
							</div>
						 </fieldset>
						 

						<fieldset>
							<legend>Настройки трафика</legend>
							<div class="form-group">
								<div class="col-sm-2 control-label">Холд (дней)</div>
								<div class="col-sm-4">
									<input class="form-control" name="hold_days" value="<?=$row->hold_days;?>" />
								</div>
							</div>
						 </fieldset>			
						<fieldset>
							<div class="col-md-offset-2">
								<button type="submit" class="btn btn-primary">Сохранить</button>
							</div>
						</fieldset>

					<?php else:?>
				
					<fieldset>
						<legend>Личные данные</legend>
						<div class="form-group">
							<div class="col-sm-2 control-label">Имя в топе</div>
							<div class="col-sm-4">
								<input class="form-control" name="login" value="<?=$this->user_model->info->login;?>" />
							</div>
						</div>
					 </fieldset>
					<fieldset>
						<div class="form-group">
							<div class="col-sm-2 control-label">Телефон</div>
							<div class="col-sm-4">
								<input name="phone" type="text" value="<?=$this->user_model->info->phone;?>" data-toggle="masked" data-inputmask="'mask': '+9 (999) 999-99-99'" placeholder="Введите номер телефона" class="form-control">
							</div>
						</div>
					 </fieldset>	
					<fieldset>
						<div class="form-group">
							<div class="col-sm-2 control-label">Email</div>
							<div class="col-sm-4">
								<input required name="email" type="text" value="<?=$this->user_model->info->email;?>" class="form-control" disabled>
								<span class="help-block">Email можно сменить при запросе в тикете</span>
							</div>
						</div>
					 </fieldset>
					 <fieldset>
							<div class="form-group">
								<div class="col-sm-2 control-label">Новый пароль</div>
								<div class="col-sm-4">
									<input name="new_password" type="text" value="" class="form-control">
								</div>
							</div>
						 </fieldset>
					<fieldset>
						<div class="form-group">
							<div class="col-sm-2 control-label">Skype</div>
							<div class="col-sm-4">
								<input value="<?=$this->user_model->info->skype;?>" type="text" name="skype" placeholder="Введите ваш скайп" class="form-control">
							</div>
						</div>
					 </fieldset>


					 

					<?php /*
					<fieldset>
						<div class="form-group">
							<div class="col-sm-2 control-label">Api Key</div>
							<div class="col-sm-4">
								<?=$this->user_model->info->api_key;?>
							</div>
						</div>
					</fieldset>
					*/ ?>
					<fieldset>
						<legend>Платежные данные</legend>
						<div class="form-group">
							<div class="col-sm-2 control-label">WMR Кошелек</div>
							<div class="col-sm-4">
								<input value="<?=$this->user_model->info->wmr;?>" type="text" data-toggle="masked" data-inputmask="'mask': 'R999999999999'" name="wmr" placeholder="Введите ваш кошелек WebMoney" class="form-control">
							</div>
						</div>
					 </fieldset>

						<fieldset>
							<div class="col-md-offset-2">
								<button type="submit" class="btn btn-primary">Сохранить</button>
							</div>
						</fieldset>	
					
					<?php endif;?>
					
				</form>
				
			</div>
		</div>
	</div>
	
</div>
