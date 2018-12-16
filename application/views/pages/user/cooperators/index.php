<!DOCTYPE html>
<html lang="ru">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title><?=$title;?></title>
   
   <link rel="shortcut icon" href="<?=base_url();?>favicon.png" type="image/x-icon" />
   
   <link rel="stylesheet" href="<?=base_url();?>app/css/app.css">
   <link rel="stylesheet" href="<?=base_url();?>app/css/theme-a.css">
   <link rel="stylesheet" href="<?=base_url();?>app/vendor/fontawesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?=base_url();?>app/vendor/simplelineicons/simple-line-icons.css">
   <script src="<?=base_url();?>app/vendor/jquery/jquery.min.js"></script>
   <script src="<?=base_url();?>app/vendor/bootstrap/js/bootstrap.min.js"></script>
   
   <script src="<?=base_url();?>app/vendor/fastclick/fastclick.js"></script>
   
   <script src="<?=base_url();?>app/js/app.js"></script>   
   
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datatable/extensions/ColVis/css/dataTables.colVis.css">

<!-- Data Table Scripts-->
<script src="<?=base_url();?>app/vendor/datatable/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/datatable-bootstrap/js/dataTables.bootstrapPagination.js"></script>
<script src="<?=base_url();?>app/vendor/datatable/extensions/ColVis/js/dataTables.colVis.min.js"></script>
   
<script src="<?=base_url();?>app/vendor/moment/min/moment-with-langs.min.js"></script>
<link rel="stylesheet" href="<?=base_url();?>app/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css">
<script src="<?=base_url();?>app/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

</head>

<body>
	
<div id="isCollapsed" class="aside-collapsed">
<div class="wrapper layout-fixed">
    
    <!-- START Top Navbar-->
<nav role="navigation" class="navbar topnavbar ng-scope">
   <!-- START navbar header-->
   <div class="navbar-header">
      <a href="<?=base_url()?>" class="navbar-brand">
         <div class="brand-logo">
            <img src="<?=base_url();?>app/img/logo.png" alt="App Logo" class="img-responsive" />
         </div>
         <div class="brand-logo-collapsed">
            <img src="<?=base_url();?>app/img/logo-single.png" alt="App Logo" class="img-responsive" />
         </div>
      </a>
   </div>
   <!-- END navbar header-->
</nav>

<aside class="aside">
<div class="aside-inner">
   <nav class="sidebar">
      
      <ul class="nav">
	      <li><a href="<?=base_url();?>cooperator/index" title="Главная"><em class="fa fa-home"></em><span class="item-text">Главная</span></a></li>
      </ul>
      <!-- END sidebar nav-->
   </nav>
</div>
</aside>


<!-- END Sidebar (left)-->

<section>
   <!-- Page content-->
		<div autoscroll="false" class="content-wrapper">
       
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<th class="col-md-2">Время</th>
							<th class="col-md-3">Продукт</th>
							<th>Фио</th>
							<th>Телефон</th>
							<th class="col-md-2 text-center">Действия</th>
						</thead>
						<tbody>
							<?php foreach($requests->result() AS $row):?>
							<!--class="<?=$requests_type[$row->status];?>"-->
							<tr id="tr<?=$row->id;?>">
								<?php $info = json_decode($row->dop_info);?>
								<td data-name="time"><?=$row->date;?> в <?=$row->time;?></td>
								<td data-name="offer_name"><?=$row->offer_name;?></td>
								<td data-name="fio"><?=$info->fio;?></td>
								<td data-name="phone"><?=$info->phone;?></td>
								<td>
									<button data-id="<?=$row->id;?>" data-toggle="modal" data-target="#start" class="buttonStart btn btn-default btn-sm"><i class="fa fa-headphones"></i> Начать обработку</button>
									<a data-id="<?=$row->id;?>" class="btn btn-inverse btn-sm deleteButton"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
</section>

</div>
</div>
	
<script>
$(function(){
	
	var request_id = 0;
	var json = {};
	
	$("#confirmButton").click(function(){
		json = {
			request_id: request_id
			, status: 1
			, fio: $("[name='fio']").val()
			, address: $("[name='address']").val()
			, postcode: $("[name='postcode']").val()
			, date: $("[name='date']").val()
			, time: $("[name='time']").val()
			, count: $("[name='count']").val()
			, comment: $("[name='comments']").val()
		};
		change_status();
	});
	
	$("#cancelButton").click(function(){
		json = {request_id: request_id, status: -1};
		change_status();
	});
	
	$(".deleteButton").click(function(){
		if(confirm('Вы уверены что хотите отменить заявку?'))
		{
			request_id = $(this).attr("data-id");
			json = {request_id: request_id, status: -3};
			change_status();
		}
	});
	
	function change_status(){
		$.post("changeStatus", json, function(data){
			$("#tr" + request_id).slideUp();
		});
	}
	
	function refreshComments(id){
		$.post("getHistory", {request_id: id}, function(data){
			//$("#commentHistoryPlace").slideUp(100, function(){
				$("#commentHistoryPlace").html(data);
			//	$(this).slideDown(500);
			//});
		});		
	}
	//Кнопка, для открытия выбора комментариев и добавления
	$("#openAddCommentPlace").click(function(){
		$(this).fadeOut(100, function() {
			$("#addCommentPlace").slideDown(500);
		});
	});
	//Кнопка, для открытия истории комментариев
	$("#openCommentHistoryPlace").click(function(){		
		$("#openCommentHistoryPlace").fadeOut(100, function(){
			refreshComments(request_id);
		});
	});
	
	$(".buttonStart").click(function(){
		request_id = $(this).attr("data-id");
		var info = $(this).parents("tr");
		$("#addCommentPlace").hide();
		$("#openAddCommentPlace").show();
		$("#commentHistoryPlace").html("");
		$("#openCommentHistoryPlace").show();
		$("#product_name").html(info.find("td[data-name='offer_name']").text());
		$("#fio").html(info.find("td[data-name='fio']").text());
		$("#phone").html(info.find("td[data-name='phone']").text());
		$("#time").html(info.find("td[data-name='time']").text());
	});
	
	//Добавление нового комментария
	$("#addComment").click(function(){
		var val = $("[name='comment']:checked").val();
		$.post("setNewHistory", {request_id: request_id, comment_id: val}, function(data){			
			$("#addCommentPlace").slideUp(500, function(){
				$("#openAddCommentPlace").show();
			});
			$("#openCommentHistoryPlace").fadeOut(100);
			refreshComments(request_id);
		});
	});
});
</script>
	
   <!-- START modal-->
   <div id="start" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
		<div class="modal-header">
			<button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
			<h4 id="myModalLabel" class="modal-title">Обработка заявки</h4>
		</div>
		 <div class="modal-body">
			 <div class="table-responsive">
			 <table class="table">
				 <tbody>
					 <tr>
						 <td class="col-md-3"><strong>Продукт:</strong></td>
						 <td id="product_name"></td>
					 </tr>
					 <tr>
						 <td class="col-md-3"><strong>Фио:</strong></td>
						 <td id="fio"></td>
					 </tr>
					 <tr>
						 <td class="col-md-3"><strong>Телефон:</strong></td>
						 <td id="phone"></td>
					 </tr>
					 <tr>
						 <td class="col-md-3"><strong>Время заявки:</strong></td>
						 <td id="time"></td>
					 </tr>
					 <tr>
						 <td class="col-md-3"><strong>Новый комментарий:</strong></td>
						 <td id="comment_new">
							 <a id="openAddCommentPlace" class="btn btn-default">Добавить</a>
							 <div id="addCommentPlace">
								<?php $comments = config_item("call_center_history_names");?>
								<?php foreach($comments AS $key => $value):?>
								<div class="col-md-12">
									<div class="radio c-radio">
										<label>
											<input type="radio" name="comment" value="<?=$key;?>">
											<span class="fa fa-circle"></span><?=$value;?>
										</label>
									</div>
								</div>
								<?php endforeach;?>
								 <div class="col-md-12">
									 <a id="addComment" class="btn btn-info">Добавить</a>
								 </div>
							 </div>
						 </td>
					 </tr>
					 <tr>
						 <td class="col-md-3"><strong>История заявки:</strong></td>
						 <td id="history">
							 <a id="openCommentHistoryPlace" class="btn btn-default">Показать</a>
							 <div id="commentHistoryPlace"></div>
						 </td>
					 </tr>					 
				 </tbody>
			 </table>
			 </div>
		 </div>
            
		<div class="modal-footer">
			<div class="pull-right">
				<button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
			</div>
			<div class="pull-left">
				<a data-dismiss="modal" data-toggle="modal" data-target="#confirm" class="btn btn-success">Подтвердить</a>
				<a id="cancelButton" data-dismiss="modal" onclick="return confirm('Вы уверены что хотите отклонить заявку?')" class="btn btn-danger">Отклонить</a>				
			</div>
		</div>
         </div>
      </div>
   </div>
   <!-- END modal-->
   
   <!-- START modal-->
   <div id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
		<div class="modal-header">
			<button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
			<h4 id="myModalLabel" class="modal-title">Подтверждение заявки</h4>
		</div>
		 <div class="modal-body">
			 <table class="table">
				 <tbody>
					 <tr>
						 <td class="col-md-3"><strong>ФИО:</strong></td>
						 <td class="col-md-9">
							 <input class="form-control" name="fio" placeholder="Иванов Иван Иванович" />
						 </td>
					 </tr>						 
					 <tr>
						 <td class="col-md-3"><strong>Адрес:</strong></td>
						 <td class="col-md-9">
							 <input class="form-control" name="address" />
						 </td>
					 </tr>	
					 <tr>
						 <td class="col-md-3"><strong>Почтовый индекс:</strong></td>
						 <td class="col-md-9">
							 <input class="form-control" name="postcode" placeholder="Не обязательно" />
						 </td>
					 </tr>						 
					 <tr>
						 <td class="col-md-3"><strong>Количество:</strong></td>
						 <td class="col-md-9">
							 <input class="form-control" name="count" value="1" />
						 </td>
					 </tr>
					 <tr>
						 <td class="col-md-3"><strong>Желаемая дата:</strong></td>
						 <td class="col-md-9">
								<div data-date-format="YYYY-MM-DD" data-pick-time="false" class="datetimepicker input-group date">
									<input value="" type="text" class="form-control" name="date" placeholder="Не обязательно">
									<span class="input-group-addon">
									   <span class="fa-calendar fa"></span>
									</span>
								</div>
							<span class="help-block">Желаемое клиентом дата доставки товара</span>
						 </td>
					 </tr>
					 <tr>
						 <td class="col-md-3"><strong>Желаемая время:</strong></td>
						 <td class="col-md-9">
							 <input class="form-control" name="time" placeholder="Не обязательно" />
							 <span class="help-block">Желаемое клиентом время доставки товара</span>
						 </td>
					 </tr>		
					 <tr>
						 <td class="col-md-3"><strong>Комментарий:</strong></td>
						 <td class="col-md-9">
							 <input class="form-control" name="comments" placeholder="Не обязательно" />
							 <span class="help-block">Можно написать любую информацию о клиенте или заказе</span>
						 </td>
					 </tr>						 
				 </tbody>
			 </table>
		 </div>
            
		<div class="modal-footer">
			<div class="pull-right">
				<button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
			</div>
			<div class="pull-left">
				<a data-dismiss="modal" id="confirmButton" class="btn btn-success">Подтвердить</a>
			</div>
		</div>
         </div>
      </div>
   </div>
   <!-- END modal-->
	
</body>
</html>