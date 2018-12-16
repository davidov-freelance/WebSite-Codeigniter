


<div class="portlet light bordered form-fit">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-tag font-blue-hoki"></i>
            <span class="caption-subject font-blue-hoki bold uppercase"><?php echo (isset($result->name))?'Редактирование':'Добавление';?> метки</span>
        </div>
        <div class="actions">
            <?php if(isset($result->id)):?>
                <a onclick="return confirm('Удалить метку?');" class="btn btn-circle btn-icon-only btn-default" href="/admin/utm/delete/<?=$result->id;?>">
                    <i class="icon-trash"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>


    <div class="portlet-body form">
        <?php echo validation_errors(); ?>
        <!-- BEGIN FORM-->
        <form data-parsley-validate="" id="form_sample_1" method="post" action="" class="form-horizontal form-bordered form-row-stripped">
            <?php if( isset( $result->id ) ): ?>
                <input type="hidden" name="action" value="edit">
            <?php endif; ?>
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-3">Ключевик</label>
                    <div class="col-md-9">
                        <input type="text" name="keyValue" class="form-control" required value="<?=(isset($result->keyValue))?$result->keyValue:'';?>" />
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3">Заголовок</label>
                    <div class="col-md-9">
                        <input type="text" name="title" class="form-control" required value="<?=(isset($result->title))?$result->title:'';?>" />
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3">Группа</label>
                    <div class="col-md-9">
                        <div class="col-md-8">
                        <select name="group_id" class="form-control" id="groups_list">
                        <?php foreach( $groups as $group ):
                            if( isset( $result->group_id ) AND $group->id == $result->group_id ) $selected = " selected";
                            else $selected = '';
                            ?>
                            <option value="<?=$group->id;?>"<?=$selected;?>><?=$group->name;?></option>
                        <?php endforeach;?>
                        </select>
                            <input type="text" class="form-control hide" id="new_group">
                            </div>
                            <div class="col-md-3">
                                <a href="javascript:;" class="btn btn-default" data-add="1" id="add_new_group">Создать</a>
                            </div>
                    </div>
                </div>


            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green"><i class="fa fa-check"></i> Сохранить</button>
                        <a href="<?=base_url();?>admin/utm"><button type="button" class="btn default">Отмена</button></a>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>






<script type="text/javascript">

    var handleValidation1 = function() {



        $('#form_sample_1').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error hide', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                keyValue: {
                    required: "Обязательное поле"
                },
                title: {
                    required: "Обязательное поле"
                }
            },
            rules: {
                title: {
                    required: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            }

        });
    }

</script>