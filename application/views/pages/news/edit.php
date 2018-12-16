


<div class="portlet light bordered form-fit">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-book-open font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase"><?php echo (isset($result->name))?'Редактирование':'Добавление';?> новости</span>
		</div>
		<div class="actions">
			<?php if(isset($result->id)):?>
			<a onclick="return confirm('Удалить новость?');" class="btn btn-circle btn-icon-only btn-default" href="/news/delete/<?=$result->id;?>">
				<i class="icon-trash"></i>
			</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="portlet-body form">
		<?php echo validation_errors(); ?>
		<!-- BEGIN FORM-->
		<form data-parsley-validate="" id="form_sample_1" method="post" action="" class="form-horizontal form-bordered form-row-stripped">
				<?php if( isset( $result->id ) ): ?>
					<input type="hidden" name="action" value="edit">
				<?php endif; ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">Заголовок</label>
					<div class="col-md-9">
						<input type="text" name="name" class="form-control" required value="<?=(isset($result->name))?$result->name:'';?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Описание</label>
					<div class="col-md-9">
						<textarea name="text" class="wysihtml5 form-control" required rows="10" data-error-container="#editor_error"><?=(isset($result->text))?$result->text:'';?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Новость видна</label>
					<div class="col-md-9">
						<select name="show_for" class="form-control chosen-select">
							<option value="1"<?=(isset($result->show) AND ($result->show == 1 ))?' selected':'';?>>Всем</option>
							<option value="0"<?=(isset($result->show) AND ($result->show == 0 ))?' selected':'';?>>Никому</option>
							<option value="2"<?=(isset($result->show) AND ($result->show == 2 ))?' selected':'';?>>У кого добавлен оффер</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Оффер</label>
					<div class="col-md-9">
						<select name="offer_id" class="form-control chosen-select">
							<option value="0">Любой</option>
							<?php  foreach($offers AS $offer):?>
								<option value="<?=$offer->id;?>"<?=(isset( $result->offer_id ) AND $offer->id==$result->offer_id)?' selected':'';?>><?=$offer->name;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Тип новости</label>
					<div class="col-md-9">
						<div class="radio-list">
							<label>
								<input required type="radio" name="news_type" required value="danger" <?=(isset($result->news_type) AND ($result->news_type == "danger" ))?' checked':'';?>> Критическая</label>
							<label>
								<input required type="radio" name="news_type" required value="warning"<?=(isset($result->news_type) AND ($result->news_type == "warning" ))?' checked':'';?>> Внимание</label>
							<label>
								<input required type="radio" name="news_type" required value="info" <?=(isset($result->news_type) AND ($result->news_type == "info" ))?' checked':'';?>>Информационная </label>
						</div>
						<div id="editor_error">
						</div>
					</div>
				</div>





				<div class="form-group">
					<label class="control-label col-md-3">Отправить email</label>
					<div class="col-md-9">
						<select name="alert" class="form-control chosen-select">
							<option value="1"<?=(isset($result->alert) AND ($result->alert == 1 ))?' selected':'';?>>Всем</option>
							<option value="0"<?=(isset($result->alert) AND ($result->alert == 0 ))?' selected':'';?>>Никому</option>
							<option value="2"<?=(isset($result->alert) AND ($result->alert == 2 ))?' selected':'';?>>Тем, у кого добавлен оффер</option>
						</select>
					</div>
				</div>



			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn green"><i class="fa fa-check"></i> Сохранить</button>
						<a href="/news"><button type="button" class="btn default">Отмена</button></a>
					</div>
				</div>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>






			</div>
		</form>

	</div>
</div>

<script type="text/javascript">

	var handleValidation1 = function() {

		$('#form_sample_1').validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error hide', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input
			messages: {
				title: {
					required: "Обязательное поле"
				}
			},
			rules: {
				title: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success1.hide();
				error1.show();
				Metronic.scrollTo(error1, -200);
			},

			highlight: function (element) { // hightlight error inputs
				$(element)
					.closest('.form-group').addClass('has-error'); // set error class to the control group
			},

			unhighlight: function (element) { // revert the change done by hightlight
				$(element)
					.closest('.form-group').removeClass('has-error'); // set error class to the control group
			},

			success: function (label) {
				label
					.closest('.form-group').removeClass('has-error'); // set success class to the control group
			}

		});
	}

</script>