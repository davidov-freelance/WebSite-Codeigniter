<h3>Добавление нового сотрудника</h3>

<link rel="stylesheet" href="<?=base_url();?>app/vendor/chosen/chosen.min.css">
<script src="<?=base_url();?>app/vendor/chosen/chosen.jquery.min.js"></script>

<div class="panel panel-default">
	<div class="panel-body">

		<?php echo validation_errors(); ?>
		
		<form method="POST">
			<div class="form-horizontal">
			
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label">ФИО</label>
						<div class="col-sm-8">
							<input type="text" name="name" class="form-control" required />
						</div>
					</div>	
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label">Телефон</label>
						<div class="col-sm-8">
							<input type="text" name="phone" class="form-control" required />
						</div>
					</div>	
				</fieldset>
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-8">
							<input type="text" name="email" class="form-control" required />
						</div>
					</div>	
				</fieldset>				
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label">Офферы</label>
						<div class="col-sm-4">
							<select multiple="multiple" name="offer_id[]" class="form-control chosen-select">
								   <option value="0">Любой</option>
								   <?php foreach($offers AS $offer):?>
									<option value="<?=$offer->id;?>"><?=$offer->name;?></option>
								   <?php endforeach;?>
							</select>
						</div>
					</div>	
				</fieldset>
				<fieldset>
					<div class="form-group">
					   <div class="col-sm-8 col-md-offset-2">
						   <button type="submit" class="btn btn-default">Добавить</button>
					   </div>
					</div>
				</fieldset>
			</div>
		</form>

	</div>
</div>