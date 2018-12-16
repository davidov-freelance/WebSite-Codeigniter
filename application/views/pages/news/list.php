
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-book-open font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Новости</span>
		</div>

	</div>
	<div class="portlet-body">
		<?php if($this->user_model->info->type == 3):?>
			<div class="pull-right">

				<a class="btn green-haze btn-sm dropdown-toggle" href="<?=base_url();?>news/add_news">
					<i class="icon-plus"></i> Добавить</a>

				<br><br>
			</div>
		<?php endif;?>

		<p>Список актуальных новостей. Обо всех изменениях мы сообщаем в виде письма на почтовый ящик. <a href="/webmaster/settings">Управление уведомлениями.</a></p>


		<table class="table table-striped table-bordered table-hover" id="sample_1">
			<thead>
			<tr>
				<th>Новость</th>
				<th>Оффер</th>
				<?php if($this->user_model->info->type == 3):?><th></th><? endif; ?>
			</tr>
			</thead>
			<tbody>
			<tr class="odd gradeX">
				<?php foreach($result AS $row):?>
			<tr>
				<td class="col-md-6">

					<a href="/news/view/<?=$row->id;?>" data-target=".ajaxNews" data-toggle="modal"><?=$row->name;?></a>

				</td>
				<td class="col-md-4"><?php if($row->show == 2 OR $this->user_model->info->type == 3):?> <a href="/offer/view/id/<?= $row->offer_id; ?>"><?= $row->offer_name; ?></a>
					<? endif; ?></td>


				<?php if($this->user_model->info->type == 3):?>
					<td>
						<a class="" href="/news/edit/<?=$row->id;?>"><i class="fa fa-pencil"></i></a>
						<a class="font-red" title="Удалить" href="/news/delete/<?=$row->id;?>" onclick="return confirm('Удалить новость?');"><i class="fa fa-times"></i></a>
					</td>
				<? endif; ?>
			</tr>
			<?php endforeach;?>

			</tbody>
		</table>
	</div>
</div>

