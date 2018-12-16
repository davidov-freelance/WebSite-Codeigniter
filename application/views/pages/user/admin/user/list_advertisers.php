<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?=$title;?>
				</div>
				<div class="pull-right title-button"><a class="" href="<?=base_url();?>admin/users"><button class="btn btn-default">Вебмастеры</button></a></div>

			</div>
			<div class="portlet-body">
		   <table class="table table-striped table-bordered">
		      <thead>
			 <tr>
			    <th class="col-md-3">Рекламодатель</th>
				 <th class="">Офферы</th>
				 <th class="col-md-1"></th>
			 </tr>
		      </thead>
		      <tbody>
			      <?php foreach($users as $user):?>
			      <tr>
				      <td>
						<?=$user["info"]["email"];?>

				      </td>
				      <td>
						  <div class="table-responsive">
						<table class="table table-striped">
							<?php foreach($user["offers"] AS $offer):?>					      
								<tr>
									<td><a href="<?=base_url();?>offer/view/id/<?=$offer["offer_id"];?>"><?=$offer["offer_name"];?></a></td>
								</tr>					      
							<?php endforeach;?>
						</table>
					      </div>
				      </td>

				      <td class="text-center">
						  <a href="<?=base_url();?>admin/user/edit/<?=$user["info"]["user_id"];?>"><i class="fa fa-edit"></i></a>
						  <a href="<?=base_url();?>admin/users/go_login_to_user/<?=$user["info"]["user_id"];?>"><i class="fa fa-user"></i></a>

					  </td>
			      </tr>
			      <?php endforeach;?>
		      </tbody>
		   </table>

			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- END PAGE CONTENT -->
