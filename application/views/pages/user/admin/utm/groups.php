



<div class="panel panel-default">

    <div class="panel-body">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-tag font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">Группы UTM меток</span>
            </div>

        </div>
        <div class="pull-right">
            <a class="btn grey btn-sm dropdown-toggle" href="<?=base_url();?>admin/utm">
                <i class="icon-settings"></i> К меткам</a>

            <a class="btn green btn-sm dropdown-toggle add" id="add_group" href="javascript:;">
                <i class="icon-plus"></i> Добавить группу</a>
            <br><br>
        </div>

        <table class="table table-hover table-bordered edit" id="groups">
            <thead>
            <tr>
                <th class="col-md-1">
                    #
                </th>
                <th class="col-md-5">
                    Название группы
                </th>
                <th class="col-md-5">
                    Заголовок по умолчанию
                </th>
                <th class="col-md-1">
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($result AS $row):?>
                <tr>
                    <td class="col-md-1">

                        <?=$row->id;?>

                    </td>
                    <td class="col-md-5">
                        <?= $row->name; ?>
                    </td>
                    <td class="col-md-5">
                        <?= $row->title; ?>
                    </td>

                    <td>
                        <a class="edit" href="javascript:;"><i class="fa  fa-edit"></i></a>
                        <a class="font-red delete" title="Удалить" href="javascript:;"><i class="fa fa-times"></i></a>
                    </td>

                </tr>
            <?php endforeach;?>
            </tbody>
        </table>


    </div>
</div>


<script type="text/javascript" src="/app/admin/pages/scripts/utm_groups.js"></script>