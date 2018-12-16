<div class="portlet box red">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>Визиты
		</div>
		<div class="tools">
			<a href="" class="collapse" data-original-title="" title="">
			</a>
		</div>

	</div>
	<div class="portlet-body form">
		<form role="form" class="form-body" method="post">
			<div class="row">
				<div class="col-md-3">
					<input type="hidden" name="start_date" id="from_date" >
					<input type="hidden" name="finish_date" id="to_date" >
					<div id="reportrange" class="btn default">
						<i class="fa fa-calendar"></i>&nbsp; <span></span>
						<b class="fa fa-angle-down"></b>
					</div>
				</div>

				<div class="col-md-4">
					<select name='offer_id' class="form-control chosen-select" id="select_offer">
						<option value="Любой">Выберите оффер</option>
						<?php foreach($offers AS $offer):?>
							<option value="<?=$offer->id;?>"<?=($offer_id == $offer->id ? " selected" : "");?>><?=$offer->name;?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="col-md-1">
					<input placeholder="User ID" class="form-control" name="user_id" value="<?=$user_id;?>" />
				</div>
				<div class="col-md-2">
					<select name="status" class="form-control">
						<option value="0">Любой</option>
						<option value="-3"<?=($status == "-3" ? " selected" : "");?>>Отмененные</option>
						<option value="-2"<?=($status == "-2" ? " selected" : "");?>>Ожидающие</option>
						<option value="-1"<?=($status == "-1" ? " selected" : "");?>>Отклоненные</option>
						<option value="1"<?=($status == "1" ? " selected" : "");?>>Подтвержденные</option>
					</select>
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-default" id="search">Поиск</button>
				</div>
			</div>
		</form>
	</div>
</div>

		<!-- START panel-->
		<div class="panel panel-default">



			<div class="panel-body">

					<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
						<thead>
						<tr>
							<th class="col-md-2">Дата / Время</th>
							<th class="col-md-1 text-center">UserID</th>
							<th class="col-md-2">Оффер</th>
							<th class="">Откуда</th>
							<th class="col-md-2">IP</th>
							<th class="col-md-2">Браузер</th>
							<th class="col-md-1">Страна</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($result AS $row):?>
							<?php
							$class = "";
							if($row->request_id > 0)
							{
								switch($row->request_status){
									case "-1": $class="danger"; break;
									case "1": $class="success"; break;
									default: $class="warning"; break;
								}
							}
							?>
							<tr class="<?=$class;?>">
								<td>
									<div class="text-center"><?=$row->date . " в " . $row->time;?></div>
								</td>
								<td class="text-center"><?=$row->user_id;?></td>
								<td>
									<div class="text-center">
										<span class="hide">Любой, <?=$row->name;?></span>
										<a target="_blank" href="<?=base_url();?>offer/view/id/<?=$row->offer_id;?>">
											<?=cut_words($row->name, 0, 15);?>
										</a>
									</div>
								</td>
								<td>
									<div class="text-center"><?=getNormalReferer($row->referer);?></div>
								</td>
								<td>
									<div class="text-center"><?=long2ip($row->ip);?></div>
								</td>
								<td>
									<div class="text-center"><?=$row->agent;?></div>
								</td>
								<td>
									<div class="text-center"><?=$row->country_code;?></div>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>

					</table>

			</div>

		</div>
		<!-- END panel-->





		<script type="text/javascript">
			var ComponentsDropdowns = function () {

				var handleSelect2 = function () {

					$('#select_offer').select2({
						placeholder: "Select an option",
						allowClear: true
					});
				}
				return {
					init: function () {
						handleSelect2();
					}
				};

			}();


			var ComponentsPickers = function () {

				var handleDateRangePickers = function () {
					var table = $('#sample_editable_1');
					var oTable = table.dataTable({
						"lengthMenu": [
							[5, 15, 20, -1],
							[5, 15, 20, "All"] // change per page values here
						],

						// set the initial value
						"pageLength": 10,

						destroy: true,
						"language": {
							"lengthMenu": " _MENU_ записей"
						},
						"columnDefs": [{ // set default column settings
							'orderable': true,
							'targets': [0]
						}, {
							"searchable": true,
							"targets": [0]
						}],
						"order": [
							[0, "asc"]
						] // set first column as a default sort by asc
					});

					if (!jQuery().daterangepicker) {
						return;
					}
					$("#search").click(function(){
						$("#from_date").val( $("input[name=daterangepicker_start]").val() );
						$("#to_date").val( $("input[name=daterangepicker_end]").val() );

					});
					$('#reportrange').daterangepicker({
							opens: (Metronic.isRTL() ? 'left' : 'right'),
							startDate: moment("<?=$startDate;?>").format(),
							endDate: moment("<?=$endDate;?>").format(),
							showDropdowns: true,
							showWeekNumbers: true,
							timePicker: false,
							timePickerIncrement: 1,
							timePicker12Hour: true,
							ranges: {
								'Сегодня': [moment(), moment()],
								'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
								'Последние 7 дней': [moment().subtract('days', 6), moment()],
								'Последние 30 дней': [moment().subtract('days', 29), moment()],
								'Текущий месяц': [moment().startOf('month'), moment().endOf('month')],
								'Прошлый месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
							},
							buttonClasses: ['btn'],
							applyClass: 'green',
							cancelClass: 'default',
							format: 'YYYY-MM-DD',
							separator: ' по ',
							locale: {
								applyLabel: 'Есть',
								fromLabel: 'С',
								toLabel: 'По',
								customRangeLabel: 'Другой диапозон',
								daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
								monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
								firstDay: 1
							}
						},
						function (start, end) {
							$('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
						}
					);
					$('#reportrange span').html('<?=$startDate;?>' + ' - ' + '<?=$endDate;?>');
				}
				return {
					init: function () {
						handleDateRangePickers();
					}
				};

			}();
		</script>