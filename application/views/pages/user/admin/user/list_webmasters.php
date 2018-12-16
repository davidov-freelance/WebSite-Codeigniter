<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?=$title;?>
				</div>
				<div class="pull-right title-button"><a class="" href="<?=base_url();?>admin/users/advertisers"><button class="btn btn-default">Рекламодатели</button></a></div>

			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
						</div>
						<div class="col-md-6">
							<div class="btn-group pull-right">


							</div>
						</div>
					</div>
				</div>
				<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
					<thead>
					<tr class="text-center">
						<th>#</th>
						<th>Регистрация</th>
						<th>Email</th>
						<th class="col-md-1">Тип</th>
						<th class="col-md-1">Баланс</th>
						<th class="col-md-1">Задержка</th>
						<th class="col-md-1">Hold</th>
						<th class="col-md-1">Выплата</th>
						<th class="col-md-1"></th>
					</tr>


					</tr>
					</thead>
					<tbody>
					<?php foreach($result->result() AS $user):?>
						<tr>
							<td>
								<a class="btn default btn-xs <?=($user->status == 1 ? "green" : "red");?>-stripe" href="<?=base_url();?>admin/users/go_login_to_user/<?=$user->id;?>">
									<?=$user->id;?></a>
								</td>

							<td class="text-center"><nobr><?php echo $user->reg_date;?></nobr></td>
							<td><?=$user->email;?> <?php if (!empty($user->api_key)) { echo '<br><small title="api-key">' . $user->api_key . '</small>'; } ?></td>
							<td>
								<?php
								if($user->type == 0) {
									echo 'Вебмастер';
								} elseif ($user->type == 1) {
									echo 'Покупатель';
								} elseif ($user->type == 3) {
									echo 'Админ';
								} ?>
							</td>

							<td class="text-center"><?php echo getNormalMoney($user->money);?></td>
							<td class="text-center"><?php echo getNormalMoney($user->hold_money);?></td>
							<td class="text-center"><?php echo $user->hold_days;?> д.</td>
							<td class="text-center"><?php echo getNormalMoney($user->on_payment);?></td>
							<td class="text-center">

								<a class="" href="<?=base_url();?>admin/user/edit/<?=$user->id;?>"><i class="fa fa-edit"></i></a>
								<a class="font-green" href="<?=base_url();?>admin/stats/index/<?=$user->id;?>"><i class="fa fa-bar-chart-o"></i></a>
								<a class="font-red" title="Удалить" href="<?=base_url();?>admin/user/delete/<?=$user->id;?>" onclick="return confirm('Удалить пользователя?');"><i class="fa fa-times"></i></a>
							</td>
						</tr>
					<?php endforeach;?>

					</tbody>
					<tfoot>
					<tr>
						<th data-width="60">ID </th>
						<th></th>
						<th data-width="250">Email </th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->



<script type="text/javascript">

	var TableEditable = function () {

		var handleSampleTable = function () {
			var table = $('#sample_editable_1');

			$('#sample_editable_1 tfoot th').each( function (index, value) {
				var title = $(this).text();
				var width = $(this).data('width');
				if( title )
				$(this).html( '<input type="text" class="form-control input-inline searchable" style="width:'+width+'px" placeholder="'+title+'" data-column="'+index+'" />' );
			} );


			var oTable = table.DataTable({
				"lengthMenu": [
					[10, 15, 20, -1],
					[10, 15, 20, "Все	"] // change per page values here
				],

				// set the initial value
				"pageLength": 10,

				destroy: true,
				"language": {
					"lengthMenu": " _MENU_"
				},
				"columnDefs": [
					{ // set default column settings
					'orderable': true,
					'targets': [0]
					},
					{
					"searchable": true,
					"targets": [0]
					}
				],
				"order": [
					[0, "asc"]
				] // set first column as a default sort by asc
			});

			$('.searchable').on( 'keyup', function () {

				oTable
					.columns($(this).data("column"))
					.search( this.value )
					.draw();
			} );


		};

		return {
			init: function () {
				handleSampleTable();
			}
		};

	}();
</script>
