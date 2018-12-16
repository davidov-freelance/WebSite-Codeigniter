<script src="<?=base_url();?>app/vendor/flot/jquery.flot.min.js"></script>
<script src="<?=base_url();?>app/vendor/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?=base_url();?>app/vendor/flot/jquery.flot.resize.min.js"></script>
<script src="<?=base_url();?>app/vendor/flot/jquery.flot.pie.min.js"></script>
<script src="<?=base_url();?>app/vendor/flot/jquery.flot.time.min.js"></script>
<script src="<?=base_url();?>app/vendor/flot/jquery.flot.categories.min.js"></script>
<script src="<?=base_url();?>app/vendor/slimscroll/jquery.slimscroll.min.js"></script>

<h3><?=$title;?></h3>


<div class="row">
	<div class="col-lg-9 col-sm-9">
		
			<!--<div class="row">
			      <div class="col-lg-4">
					<div class="panel widget bg-default">
					   <div class="row row-table">
					      <div class="col-xs-4 text-center bg-success-dark pv-lg">
						 <em class="fa fa-group fa-3x"></em>
					      </div>
					      <div class="col-xs-8 pv-lg">
						      <div class="h2 mt0"><?php echo getNormalMoney($transits_count, false);?></div>
						 <div class="text-uppercase">Посетителей</div>
					      </div>
					   </div>
					</div>
			      </div>
			      <div class="col-lg-4">
					<div class="panel widget bg-default">
					   <div class="row row-table">
					      <div class="col-xs-4 text-center bg-info-dark pv-lg">
						 <em class="fa fa-magnet fa-3x"></em>
					      </div>
					      <div class="col-xs-8 pv-lg">
						      <div class="h2 mt0"><?php echo getNormalMoney($requests_count, false);?></div>
						 <div class="text-uppercase">Заказов</div>
					      </div>
					   </div>
					</div>
			      </div>

			      <div class="col-lg-4">
					<div class="panel widget bg-default">
					   <div class="row row-table">
					      <div class="col-xs-4 text-center bg-warning-dark pv-lg">
						 <em class="fa fa-money fa-3x"></em>
					      </div>
					      <div class="col-xs-8 pv-lg">
						      <div class="h2 mt0"><?php echo getNormalMoney($requests_profit, false);?></div>
						 <div class="text-uppercase">Прибыли</div>
					      </div>
					   </div>
					</div>
			      </div>
			</div>-->
		
			<div class="row">
		
				<div class="col-md-12">

					<div class="panel panel-default">
						<div class="panel-heading">
						  <div class="panel-title">Статистика заявок за 7 дней</div>
						</div>
						<div class="panel-body">
							  <div data-source="<?=base_url();?>advertiser/getForChart" class="chart-line flot-chart"></div>
						</div>
					</div>

				</div>
			</div>
		
	</div>
	
	<aside class="col-lg-3 col-sm-3">
			<div class="panel panel-default">
				<div class="panel-heading">
				  <div class="panel-title">Тех. поддержка</div>
				</div>
				<div class="panel-body">
					<div class="row">						
						<div class="col-md-12">
							<p><small>Skype: <?=config_item("ticket_skype");?></small></p>
							<p><small>Телефон: <?=config_item("ticket_phone");?></small></p>							
						</div>
					</div>
				</div>
			</div>
		
		
	</aside>
	
</div>
