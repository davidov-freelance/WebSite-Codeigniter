
<div class="modal-body">
    <?=$news->name;?><span class="pull-right">
	<?php echo normal_time(($news->added));?>
    </span>
    <div class="news-item-page">
    <p>
        <?=$news->text;?>
    </p>
</div>
</div>