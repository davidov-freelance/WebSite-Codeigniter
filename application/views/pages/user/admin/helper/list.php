



<div class="panel panel-default">

    <div class="panel-body">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-support font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">Информация и инструменты</span>
            </div>
        </div>
        <div class="pull-right">


                <a class="btn green-haze btn-sm dropdown-toggle" href="<?=base_url();?>admin/helper/add_helper">
                    <i class="icon-plus"></i> Добавить</a>

                <br><br>
            </div>



        <table class="table table-striped table-bordered table-hover" id="terms_list">
            <thead>
            <tr>
                <th>#</th>
                <th>Материал</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($result AS $row):?>
                <tr>
                    <td><?=$row->id;?></td>
                    <td class="col-md-6"><?=$row->title;?></td>
                    <td class="col-md-3">
                        <?= $row->title; ?>
                    </td>

                    <td>
                        <a class="" href="/admin/helper/edit/<?=$row->id;?>"><i class="fa fa-pencil"></i></a>
                        <a class="font-red" title="Удалить" href="/admin/helper/delete/<?=$row->id;?>" onclick="return confirm('Удалить?');"><i class="fa fa-times"></i></a>
                    </td>

                </tr>
            <?php endforeach;?>

            </tbody>
        </table>


    </div>
</div>



<script type="text/javascript" src="/app/admin/pages/scripts/utm_groups.js"></script>