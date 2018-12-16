


<h3><?php echo $ticket->title; ?></h3>
<form action="#" class="form-horizontal">
	<div class="tabbable-line">
		<ul class="nav nav-tabs ">
			<li class="active">
				<a href="#tab_1" data-toggle="tab">
					Обсуждение </a>
			</li>
			<li>
				<a href="#tab_2" data-toggle="tab">
					История </a>
			</li>
			<li class="pull-right">
					<?php if($ticket->status == 1):?>
						<a href="#">Тикет закрыт</a>
					<?php else:?>
						<a  href="<?=base_url()?>tickets/close/<?php echo $ticket->id; ?>">Закрыть тикет</a>
					<?php endif;?>
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				<!-- TASK COMMENTS -->
				<div class="form-group">
					<div class="col-md-12">
						<ul class="media-list">
							<?php
							$isAdmin = in_array($this->user_model->info->type, array("2", "3"));
							foreach($result AS $row):
								if($row->author > 0)
									$author = "Служба поддержки";
								else
									if($isAdmin)
										$author = "Написал " . $ticket->email;
									else
										$author = "Ваш ответ";
								?>

								<li class="media">
									<div class="media-body todo-comment">
										<p class="todo-comment-head">
											<span class="todo-comment-username"><?php echo $author;?></span> &nbsp; <span class="todo-comment-date"><?php echo normal_time(strtotime($row->time));?></span>
										</p>
										<p class="todo-text-color">
											<?php echo $row->text;?>
										</p>

									</div>
								</li>

							<?php endforeach;?>


						</ul>
					</div>
				</div>
				<!-- END TASK COMMENTS -->
				<!-- TASK COMMENT FORM -->
				<div class="form-group">
					<div class="col-md-12">
						<ul class="media-list">
							<li class="media">
								<div class="media-body">
									<input type="hidden" id="ticket_id" value="<?php echo $ticket->id;?>">
									<textarea class="form-control todo-taskbody-taskdesc" rows="4" placeholder="Ваш комментарий..." id="textComment"></textarea>
								</div>
							</li>
						</ul>
						<button type="button" class="pull-right btn btn-sm btn-circle green-haze" id="addComment"> &nbsp; Отправить &nbsp; </button>
					</div>
				</div>
				<!-- END TASK COMMENT FORM -->
			</div>
			<div class="tab-pane" id="tab_2">
				<ul class="todo-task-history">


					<?php
					$isAdmin = in_array($this->user_model->info->type, array("2", "3"));
					foreach($result AS $key => $row):
						if( $key == 0 )
							$author = "Создано тикет-обращение";
						elseif($row->author > 0)
							$author = "Ответ службы поддержки";
						else
							if($isAdmin)
								$author = "Написал " . $ticket->email;
							else
								$author = "Вы написали";
						?>

					<li>
						<div class="todo-task-history-date">
							<?php echo normal_time(strtotime($row->time));?>
						</div>
						<div class="todo-task-history-desc">
							<?php echo $author; ?>
						</div>
					</li>
					<?php endforeach;?>
					<?php if($ticket->status === 0):?>
					<li>
						<div class="todo-task-history-date">
							<?php echo normal_time(strtotime($ticket->date_close));?>
						</div>
						<div class="todo-task-history-desc">
							Тикет закрыт
						</div>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>


<script>
$(function(){
	$("#addComment").click(function(){
		$.post("/tickets/addComment", {message: $("#textComment").val(), ticket_id: $("#ticket_id").val()}, function(data){
			$("#textComment").val("");
			$.ajax({
				type: "GET",
				cache: false,
				url: 'tickets/view/'+$("#ticket_id").val(),
				dataType: "html",
				success: function(res) {
					$(".loading-block").addClass("hide");
					$("#ticketView").html( res );
				},
				error: function(xhr, ajaxOptions, thrownError) {
					var msg = 'Error on reloading the content. Please check your connection and try again.';
					alert(msg);
				}
			});
		});
	});
});
</script>