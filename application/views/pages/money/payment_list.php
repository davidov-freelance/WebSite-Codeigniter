


<div class="portlet light bordered form-fit">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-wallet font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase">Выплаты</span>
		</div>
	</div>
	<div class="panel">
		<div class="panel-body">

			<?php if( !$this->user_model->isAdmin() ): ?>
				<div class="tabbable-custom ">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_5_1" data-toggle="tab" aria-expanded="true">
								WebMoney </a>
						</li>
						<li class="">
							<a href="#tab_5_2" data-toggle="tab" aria-expanded="false" disabled>
								Яндекс деньги </a>
						</li>
						<li class="">
							<a href="#tab_5_3" data-toggle="tab" aria-expanded="false">
								Сбербанк-онлай </a>
						</li>
						<li class="">
							<a href="#tab_5_4" data-toggle="tab" aria-expanded="false">
								Альфа-клик </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_5_1">
							<form id="cashout_form" method="post" action="/money/payment/orderPayment">
							<div class="fieldset_payments">
								<fieldset>
									<div class="form-group">
										<div class="col-sm-6">
											<? if(!empty( $this->user_model->info->wmr ) ):?>
											<input required name="payment_type" id="bill" type="text" class="form-control" placeholder="WMR кошелек"  value="<?=$this->user_model->info->wmr;?>" disabled value="WebMoney">
			<? else: ?>
			<a href="/webmaster/settings">Для заказа выплаты заполните кошелек в профиле</a>
											<?endif;?>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div class="form-group">
										<div class="col-sm-6">
											<div class="input-group">
												<input  type="hidden" name="payment_type" >
												<input <? if(empty( $this->user_model->info->wmr ) ):?>  disabled<? endif;?>  required id="sum" name="sum" class="form-control" type="text" placeholder="Сумма выплаты" value="<?php echo (int)$this->user_model->info->money; ?>">
												<span class="input-group-btn">

												<button <? if(empty( $this->user_model->info->wmr ) ):?>  disabled<? endif;?> class="btn btn-success" type="submit"><i class="fa fa-arrow-left fa-fw"></i> Заказать</button>
												</span>
											</div>

											<span class="help-inline"> Вынимальная сумма выплаты 3000 рублей</span>
										</div>
									</div>

								</fieldset>
							</div>
							</form>
						</div>
						<div class="tab-pane" id="tab_5_2">
							<p>
								Данный способ оплаты временно недоступен.
							</p>
						</div>
						<div class="tab-pane" id="tab_5_3">
							<p>
								Данный способ оплаты временно недоступен.
							</p>
						</div>
						<div class="tab-pane" id="tab_5_4">
							<p>
								Данный способ оплаты временно недоступен.
							</p>
						</div>
					</div>
				</div>
			<?php endif; ?>

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
				<tr>
					<th class="text-center col-md-1">Дата</th>
					<?php if( $this->user_model->isAdmin() ): ?>
					<th class="text-center col-md-2">Кто заказал</th>
					<?php endif; ?>
					<th class="col-md-2">Тип кошелька</th>
					<th class="col-md-2">Счет</th>
					<th class="col-md-1">Сумма</th>
					<th class="col-md-2 text-center">Статус</th>
				</tr>


				</thead>
				<tbody>
				<?php foreach($result AS $row):?>
					<tr>
						<td class="text-center"><nobr><?php echo $row->time;?></nobr></td>

						<?php if( $this->user_model->isAdmin() ): ?>
						<td>ID <?=$row->user_id;?>, <a href="mailto:<?=$row->email;?>"><?=$row->name;?></a></td>
						<?php endif; ?>
						<td><?=$row->payment_type;?></td>
						<td><?=$row->bill;?></td>
						<td><?=$row->sum;?></td>

						<td class="text-center">
							<?php if( !$row->paid ): ?>

								<?php if( $this->user_model->isAdmin() ): ?>
							<a onclick="return confirm('Вы уверены, что хотите оплатить?')" class="btn btn-default btn-sm" href="<?=base_url();?>money/payment/ok/<?=$row->id;?>">Оплатить</a>
								<?php else: ?>
									Не выплачено
								<?php endif; ?>
							<?php else: ?>
								Оплачено
							<?php endif; ?>
						</td>

					</tr>
				<?php endforeach;?>
				</tbody>
			</table>


		</div>
	</div>
</div>


