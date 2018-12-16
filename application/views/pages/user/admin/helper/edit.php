


<div class="portlet light bordered form-fit">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-support font-blue-hoki"></i>
            <span class="caption-subject font-blue-hoki bold uppercase"><?php echo (isset($result->id))?'Редактирование':'Добавление';?></span>
        </div>
        <div class="actions">
            <?php if(isset($result->id)):?>
                <a onclick="return confirm('Удалить?');" class="btn btn-circle btn-icon-only btn-default" href="/admin/helper/delete/<?=$result->id;?>">
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
                    <label class="control-label col-md-3">Заголовок</label>
                    <div class="col-md-9">
                        <input type="text" name="title" class="form-control" required value="<?=(isset($result->title))?$result->title:'';?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Ссылка</label>
                    <div class="col-md-9">
                        <input type="text" name="link" class="form-control" required value="<?=(isset($result->link))?$result->link:'';?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Иконка</label>
                    <div class="col-md-9">
                        <div class="col-md-8">
                            <div class="radio-list">
                        <?php foreach( $icons as $icon ):
                            if( isset( $result->icon ) AND $icon == $result->icon ) $checked = " checked";
                                else $checked = "";
                            ?>
                            <label class="radio-inline">
                                    <input type="radio" name="icon" value="<?=$icon;?>"<?=$checked;?>>
                                </label>
                            <i class="fa fa-<?=$icon;?>"></i>

                        <?php endforeach;?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Приоритет</label>
                    <div class="col-md-9">
                        <div class="col-md-8">
                            <div class="radio-list">
                                <?php foreach( $icons_label as $label ):
                                    if( isset( $result->label ) AND $label == $result->label ) $checked = " checked";
                                        else $checked = '';
                                    ?>
                                    <label class="radio-inline label label-<?=$label;?>">
                                        <input type="radio" name="label" value="<?=$label;?>"<?=$checked;?>>
                                    </label>

                                <?php endforeach;?>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green"><i class="fa fa-check"></i> Сохранить</button>
                        <a href="<?=base_url();?>admin/helper"><button type="button" class="btn default">Отмена</button></a>
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
                link: {
                    required: "Обязательное поле"
                },
                title: {
                    required: "Обязательное поле"
                }
            },
            rules: {
                title: {
                    required: true
                },
                link: {
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