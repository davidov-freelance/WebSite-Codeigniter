<h3><?php echo $user->name . " " . $user->surname; echo ($user->status == '0') ? " <span class='label label-danger'>Пользователь забанен</span>" : ""; ?></h3>

<div class="panel panel-default">
	<div class="panel-body">
		<h4><?php echo mb_ucfirst(getUserType($user->type)); ?></h4>

		<div>
			<table class="table table-striped">
			<tbody>
				<tr>
					<td>
						Имя
					</td>
					<td>
						<?php echo $user->name; ?>
					</td>
				</tr>
				<tr>
					<td>
						Фамилия
					</td>
					<td>
						<?php echo $user->surname; ?>
					</td>
				</tr>
				<tr>
					<td>
						Категория
					</td>
					<td>
						<?php echo mb_ucfirst(getUserType($user->type)); ?>
					</td>
				</tr>
				<tr>
					<td>
						Номер телефона
					</td>
					<td>
						<span class="label label-info"><?php echo $user->phone; ?></span>
					</td>
				</tr>
				<tr>
					<td>
						email
					</td>
					<td>
						<span class="label label-info"><?php echo $user->email; ?></span>
					</td>
				</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>

<div class="well">
	<h4>История пользователя</h4>
	<?php
		foreach($ban_reason as $list) {
			echo $list->puttime." ";
			echo $list->type == 'ban' ? '<strong> Забанен </strong>' : '<strong> Разбанен </strong>';
			echo $list->who == 'system' ? '<strong> системой по причине: </strong>' : '<strong> администрацией по причине: </strong>';
			echo $list->text." ";
			echo "<br>";
		}
	?>
</div>

<form method="POST" action="<?=base_url()?>admin/user/<?=$user->id?>">
<div class="well">
	<?php echo validation_errors(); ?>
	<textarea name="text" required></textarea>

<?php	
if($user->status == '0') 
{
?>
	<input type="hidden" name="type" value="unban">
	<input type="submit" class="btn btn-labeled btn-success" value="Разбанить" name="btn">
<?php
}
else 
{
?>
	<input type="hidden" name="type" value="ban">
	<input type="submit" class="btn btn-labeled btn-danger" value="Забанить" name="btn">
<?php
}
?>
</div>
</form>