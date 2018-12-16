

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-shuffle font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase">Потоки</span>
		</div>

	</div>
	<div class="portlet-body form">

	<table class="table">
         <thead>
            <tr>
				<th class="col-md-3">Ссылка</th>
               	<th class="col-md-2">Название</th>
               	<th class="col-md-3">Оффер</th>
              	<th class="col-md-2">Город</th>
				<th class="col-md-1">Страница</th>
	       		<th class="col-md-1">Действия</th>
            </tr>
         </thead>
         <tbody>
		<?php foreach($flows AS $flow):?>
		 <tr>
			 <td>
				<input type="text" class="form-control input-sm clickSelect" value="http://<?=$flow->url_str;?>/<?=$flow->url;?>" <?php if ($flow->status == "stop" OR $flow->status == "forbidden"):?>title="Поток отключен" disabled<?php endif; ?> />
				 <?php if ( $flow->status == "stop" ):?>
					 <small style="color:red;">*Отключен, приостановите трафик</small><br>
				 <?php endif; ?>
				 <?php if ( $flow->status == "forbidden" ):?>
					 <small style="color:red;">*Доступ закрыт, приостановите трафик</small><br>
				 <?php endif; ?>
				 <?php if ( $flow->status == "active_private" ):?>
					 <small style="color:green;">*Приватный оффер</small><br>
				 <?php endif; ?>
			</td>
			 <td><?=$flow->name;?></td>
			 <td><a href="<?=base_url();?>offer/view/id/<?=$flow->offer_id;?>"><?=$flow->offer_name;?></a></td>
             <td><?=($flow->city_name)?$flow->city_name:'mix';?> </td>
             <td>
				 <a href="<?=$flow->page_url;?>" target="_blank"><?=$flow->page_name;?></a>
			 </td>
			 <td class="text-right">
				 <a data-toggle="tooltip" data-original-title="Редактировать" href="<?=base_url();?>webmaster/flow/edit/<?=$flow->id;?>" class=""><i class="fa fa-edit"></i></a>
				 <a onclick="if(confirm('Вы уверены что хотите удалить поток?'))return true; return false;" data-toggle="tooltip" data-original-title="Удалить" href="<?=base_url();?>webmaster/flow/delete/<?=$flow->id;?>" class="font-red"><i class="fa fa-remove"></i></a>
			 </td>
		 </tr>
		<?php endforeach;?>
         </tbody>
      </table>


	</div>
</div>