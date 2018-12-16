<div class="btn-group">

	<a href="/webmaster/stat/list" class="btn btn-default <?=( $type=="")?'grey':'';?>">По дате</a>
	<a href="/webmaster/stat/list/subs" class="btn btn-default <?=( $type=="subs")?'grey':'';?>">По субаккаунтам</a>
	<a href="/webmaster/stat/list/flows" class="btn btn-default <?=( $type=="flows")?'grey':'';?>">По потокам</a>
	<a href="/webmaster/stat/list/offers" class="btn btn-default <?=( $type=="offers")?'grey':'';?>">По офферам</a>
	<a href="/webmaster/stat/list/pages" class="btn btn-default <?=( $type=="pages")?'grey':'';?>">По лендингам</a>
	<a href="/webmaster/stat/list/leads" class="btn btn-default <?=( $type=="leads")?'grey':'';?>">По действиям</a>
</div>

<div class="page-head"><div class="page-title"></div></div>


<div class="row">

	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box grey-salsa">

			<div class="portlet-title">

				<div class=" search-caption">
				<form action="/webmaster/stat/list/<?=$type;?>" method="post">
					<div class="row">
						<div class="col-md-5">
					<input type="hidden" name="from_date" id="from_date" >
					<input type="hidden" name="to_date" id="to_date" >
						<div id="reportrange" class="btn default">
							<i class="fa fa-calendar"></i>&nbsp; <span></span>
							<b class="fa fa-angle-down"></b>
						</div>

							<button type="submit" class="btn btn-info  reload" id="search_date">Поиск</a></button>
						</div>
					<div  class="col-md-7 subs-search">
						<?php if(isset($num_columns) ):?>
						<i class="btn btn-default font-red icon-refresh" id="resetSearch"></i>
						<input type="text" class="form-control sub_search_field" data-column="3" placeholder="<?php echo $four_column;?>" />

						<input type="text" class="form-control sub_search_field" data-column="2" placeholder="<?php echo $three_column;?>" />
						<input type="text" class="form-control sub_search_field" data-column="1" placeholder="<?php echo $two_column;?>" />
						<input type="text" class="form-control sub_search_field" data-column="0" placeholder="<?php echo $one_column;?>"/>
						<?php endif; ?>
					</div>
					</div>
				</form>


				</div>



			</div>


			<div class="portlet-body">

				<?php if($type == "leads"):?>

					<table data-table="true" class="table table-hover table-bordered" id="sample_editable_2">

						<thead>
						<tr>
							<th class="col-md-2">Дата</th>
							<th class="">Оффер</th>
							<th class="col-md-2 text-center">Страница</th>
							<th class="col-md-2 text-center">Цель</th>
							<th class="col-md-1 text-center">Заработок</th>
							<th class="text-left">Данные</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$class_array = array(
							"-2"	=>	"warning",
							"0"		=>	"waring",
							"-1"	=>	"danger",
							"1"		=>	"success"
						);
						?>
						<?php foreach($result->result() AS $request):?>
							<?php
							$info = json_decode($request->dop_info);
							if(isset($info->fio))
							{
								$fioAr = explode(" ", $info->fio);
								$fio = "";
								foreach($fioAr AS $name)
								{
									$fio .= substr($name, 0, count($name) - 3) . "***" . " ";
								}
							}
							else
								$fio = "Неверно введено";
							if(isset($info->phone))
								$phone = substr($info->phone, 0, count($info->phone) - 5) . "***";
							else
								$phone = "Неверно введено";
							?>
							<tr class="<?=$class_array[$request->status];?>">
								<td class="text-center"><?php echo $request->date;?>
									в <?php echo $request->time;?>
								</td>
								<td><a href="<?=base_url();?>offer/view/id/<?=$request->offer_id;?>"><?php echo $request->offer_name;?></a></td>
								<td class="text-center"><a href="<?=$request->page_url;?>" target="_blank"><?php echo $request->page_name;?></a></td>
								<td class="text-center"><?php echo $request->goal_name;?></td>
								<td class="text-center"><?php echo $request->profit;?> руб.</td>
								<td class="text-left">
									ФИО: <?php echo $fio;?><br/>
									Телефон: <?php echo $phone;?>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>

				<?php else:?>
					<!--div class="row">
						<div class="col-md-5"></div>
						<div class="col-md-7">
							<input type="text" class="form-control" style="float: right;width:130px" placeholder="<?php echo $one_column;?>" />
							<input type="text" class="form-control" style="float: right;width:130px" placeholder="<?php echo $one_column;?>" />
							<input type="text" class="form-control" style="float: right;width:130px" placeholder="<?php echo $one_column;?>" />
							<input type="text" class="form-control" style="float: right;width:130px" placeholder="<?php echo $one_column;?>" />

						</div>
					</div-->
					<table data-table="true" class="table table-hover table-bordered" id="sample_editable_1">
						<tfoot>
						<tr style="border: none;">
							<th<?=(isset($num_columns) ? " colspan='".$num_columns."'" : "");?> class="text-right">
							Всего</th>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center" title="Ожидают"></td>
							<td class="text-center" title="Отклонено"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center" title="Зачислено"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
						</tr>
						</tfoot>
						<thead>
						<tr>
							<td<?=(isset($num_columns) ? " colspan='".$num_columns."'" : "");?>></td>
							<td class="text-center">Трафик</th>
							<td colspan="2" class="text-center">Коэффициенты</td>
							<td colspan="4" class="text-center">Конверсии</td>
							<td colspan="4" class="text-center">Финансы</td>
						</tr>
						<tr>
							<th class="text-center">
								<?php echo $one_column;?></th>
							<?php if(isset($two_column)):?>
								<th class="text-center"><?php echo $two_column;?></th>
							<?php endif;?>
							<?php if(isset($three_column)):?>
								<th class="text-center"><?php echo $three_column;?></th>
							<?php endif;?>
							<?php if(isset($four_column)):?>
								<th class="text-center"><?php echo $four_column;?></th>
							<?php endif;?>
							<th class="text-center">Клики</th>
							<th class="text-center">CR%</th>
							<th class="text-center">EPC</th>
							<th class="text-center">Всего</th>
							<th class="text-center">Принято</th>
							<th class="text-center" title="Ожидают">Ожид.</th>
							<th class="text-center" title="Отклонено">Откл.</th>
							<th class="text-center">Всего</th>
							<th class="text-center" title="Зачислено">Зачисл.</th>
							<th class="text-center">Ожидают</th>
							<th class="text-center">Отклонено</th>
						</tr>
						</thead>

						<tbody id="table_data">
							<?=$table_data;?>
						</tbody>

					</table>

				<?php endif;?>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>





<script type="text/javascript">


	var ComponentsPickers = function () {



		var handleDateRangePickers = function () {
			var intVal = function ( i ) {
				return typeof i === 'string' ?
				i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
						i : 0;
			};

			var totalSearch = function(api){
				var plus =<?=(isset($num_columns)) ? 3 : 0; ?>;

				totalClick = api
					.column( 1+plus, {"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );

				totalCR = api
					.column( 2+plus,{"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return (parseInt(a)+parseInt(b));
					}, 0 );
				totalEPC = api
					.column( 3+plus,{"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return (parseInt(a)+parseInt(b));
					}, 0 );


				totalConversion = api
					.column( 4+plus,{"filter":"applied"} )
					.data()
					.reduceRight( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );




				totalConversionSuccess = api
					.column( 5+plus, {"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );




				totalConversionWait = api
					.column( 6+plus,{"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );



				totalConversionFail = api
					.column( 7+plus,{"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );



				totalProfit = api
					.column( 8+plus,{"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return parseFloat(a) + parseFloat(b);
					}, 0 );



				totalProfitPay = api
					.column( 9+plus,{"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return parseFloat(a) + parseFloat(b);
					}, 0 );



				totalProfitWait = api
					.column( 10+plus,{"filter":"applied"} )
					.data()
					.reduce( function (a, b) {
						return parseFloat(a) + parseFloat(b);
					}, 0 );



				totalProfitFail = api
					.column( 11+plus,{"filter":"applied"} )
					.data({"filter":"applied"})
					.reduce( function (a, b) {
						return parseFloat(a) + parseFloat(b);
					}, 0 );




				// Update footer
				$( api.column( 1+plus ).footer() ).html(totalClick);
				$( api.column( 2+plus ).footer() ).html(parseInt(totalCR/api.rows( {"filter":"applied"} ).data().length)+'%');
				$( api.column( 3+plus ).footer() ).html(parseInt(totalEPC/api.rows( {"filter":"applied"} ).data().length));
				$( api.column( 4+plus ).footer() ).html(totalConversion);
				$( api.column( 5+plus ).footer() ).html(totalConversionSuccess);
				$( api.column( 6+plus ).footer() ).html(totalConversionWait);
				$( api.column( 7+plus ).footer() ).html(totalConversionFail);
				$( api.column( 8+plus ).footer() ).html(totalProfit);
				$( api.column( 9+plus ).footer() ).html(totalProfitPay);
				$( api.column( 10+plus ).footer() ).html(totalProfitWait);
				$( api.column( 11+plus ).footer() ).html(totalProfitFail);
			};

			$("#sample_editable_2").dataTable({});

			var table = $('#sample_editable_1');
			var oTable = table.dataTable({
				"drawCallback": function( settings ) {
					var api = this.api();
					totalSearch(api);
				},
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
					totalSearch(api);
					// Remove the formatting to get integer data for summation
					var intVal = function ( i ) {
						return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
							typeof i === 'number' ?
								i : 0;
					};


				},

				"initComplete": function(settings, json) {
					var api = this.api();

					$('.sub_search_field').keyup( function() {
						var findColumn = parseInt($(this).data("column"));
						api.column(findColumn).search( this.value ).draw();
						totalSearch(api);
					} );

					$('#resetSearch').click( function() {
						$('.sub_search_field').val('');
						api.columns().search("").draw();
						totalSearch(api);
					});

				},


				"lengthMenu": [
					[5, 15, 20],
					[5, 15, 20] // change per page values here
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
					[0, "desc"]
				] // set first column as a default sort by asc
			});


			if (!jQuery().daterangepicker) {
				return;
			}

			$("#search_date").click(function(){
				$("#from_date").val( $("input[name=daterangepicker_start]").val() );
				$("#to_date").val( $("input[name=daterangepicker_end]").val() );

			});

			$("body").addClass("page-sidebar-closed page-sidebar-closed-hide-logo");
			$(".page-sidebar-menu").addClass("page-sidebar-menu-closed");


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