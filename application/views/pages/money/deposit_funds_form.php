<h3><?php echo $title; ?></h3>

<!-- START panel-->
<div class="panel panel-default">
   <div class="panel-body">
      <form enctype="multipart/form-data" action="" method="POST" data-parsley-validate>
        <div class="form-horizontal">
		<fieldset>
			<legend>Выберите способ оплаты</legend>
		</fieldset>

		<div class="form-group">
			<div class="col-sm-3">
				<div class="input-group m-b">
                 <span class="input-group-addon"><em class="fa fa-rouble"></em></span>
                 <input type="text" class="form-control">
                 <span class="input-group-addon">.00</span>
              </div>
			</div>
            <div class="col-sm-10">
              <label class="radio-inline c-radio">
                	<input id="inlineradio10" type="radio" name="i-radio" value="option1">
                	<span class="fa fa-check"></span>a</label>
                <label class="radio-inline c-radio">
                	<input id="inlineradio20" type="radio" name="i-radio" value="option2">
                	<span class="fa fa-check"></span>b</label>
                <label class="radio-inline c-radio">
                	<input id="inlineradio30" type="radio" name="i-radio" value="option3">
                	<span class="fa fa-check"></span>c</label>
           	</div>
        </div>

		</div>
	</form>
	</div>
</div>