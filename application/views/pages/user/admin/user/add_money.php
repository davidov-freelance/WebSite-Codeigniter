<h3><?=$title;?></h3>

<div class="panel panel-default">
	<div class="panel-body">
		<form method="POST" data-parsley-validate>
         <div class="form-horizontal">
		<fieldset>
			<legend>Заполните форму</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">User Id</label>
				<div class="col-sm-2">
					<input <?=($user_id > 0 ? "value='".$user_id."'" : "");?> type="text" class="form-control" name="user_id" required />
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Сумма</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" name="sum" required />
				</div>
			</div>							
		</fieldset>
		<fieldset>
			<div class="col-md-4 col-md-offset-2">
				<button type="submit" class="btn btn-primary">Готово</button>
			</div>
		</fieldset>
		</div>
		</form>
	</div>
</div>