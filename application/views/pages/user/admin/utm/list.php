



<div class="panel panel-default">

    <div class="panel-body">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-tag font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">UTM метки</span>
            </div>
        </div>
        <div class="pull-right">


            <a class="btn grey btn-sm dropdown-toggle" href="<?=base_url();?>admin/utm/groups">
                <i class="icon-settings"></i> Управление группами</a>

                <a class="btn green-haze btn-sm dropdown-toggle" href="<?=base_url();?>admin/utm/add_utm">
                    <i class="icon-plus"></i> Добавить метку</a>

                <br><br>
            </div>



        <table class="table table-striped table-bordered table-hover" id="terms_list">
            <thead>
            <tr>
                <th class="hide"></th>
                <th>Term</th>
                <th>Заголовок</th>
                <th><select data-type="datatable_select" data-td-num="0" class="form-control" id="chooseGroup">
                        <option value="0">выберите группу</option>
                        <?php foreach($groups AS $key => $value):?>
                            <option value="<?=$value->id;?>"><?=$value->name;?></option>
                        <?php endforeach;?>
                    </select></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($result AS $row):?>
                <tr>


                    <td class="hide"><?=$row->group_id;?></td>


                    <td class="col-md-3">
                        <?=$row->keyValue;?>
                    </td>


                    <td class="col-md-6 ">
                        <?= $row->title; ?>
                    </td>

                    <td>
                        <a class="" href="/admin/utm/edit/<?=$row->id;?>"><i class="fa fa-pencil"></i></a>
                        <a class="font-red" title="Удалить" href="/admin/utm/delete/<?=$row->id;?>" onclick="return confirm('Удалить term?');"><i class="fa fa-times"></i></a>
                    </td>

                </tr>
            <?php endforeach;?>

            </tbody>
        </table>


    </div>
</div>



<script type="text/javascript" src="/app/admin/pages/scripts/utm_groups.js"></script>