
<div class="row">
    <div class="col-md-12 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font-color hide"></i>
                    <span class="caption-subject theme-font-color bold uppercase"><i class="icon-magic-wand"></i> Лэндинги</span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1_1" data-toggle="tab">
                            Генерация </a>
                    </li>
                    <li>
                        <a href="#tab_1_2" data-toggle="tab">
                            Созданные </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <!--BEGIN TABS-->
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1_1">
                        <div class="scroller" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                <div class="portlet light" id="form_wizard_1">
                                    <div class="portlet-title">
                                        <div class="caption">
								<span class="caption-subject font-green-sharp bold uppercase">
								<span class="step-title">Шаг 1 из 3 </span>
								</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <form action="javascript:;" class="form-horizontal" id="submit_form" method="POST">
                                            <div class="form-wizard">
                                                <div class="form-body">
                                                    <ul class="nav nav-pills nav-justified steps">
                                                        <li>
                                                            <a href="#tab1" data-toggle="tab" class="step">
												<span class="number">
												1 </span>
												<span class="desc">
												<i class="fa fa-check"></i> Выбор лэдинга </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab2" data-toggle="tab" class="step">
												<span class="number">
												2 </span>
												<span class="desc">
												<i class="fa fa-check"></i> Настройка </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab3" data-toggle="tab" class="step active">
												<span class="number">
												3 </span>
												<span class="desc">
												<i class="fa fa-check"></i> Сохранение </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                                        <div class="progress-bar progress-bar-success">
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="alert alert-danger display-none">
                                                            <button class="close" data-dismiss="alert"></button>
                                                            Проверьте заполненные данные и повторите снова.
                                                        </div>
                                                        <div class="alert alert-success display-none">
                                                            <button class="close" data-dismiss="alert"></button>
                                                            Успешно.
                                                        </div>
                                                        <div class="tab-pane active" id="tab1">
                                                            <h3 class="block">Выберите вариант лэндинга</h3>

                                                            <div class="form-group">
                                                                <div class="col-md-12 text-center">
                                                                    <div class="radio-list" id="landing_variants">


                                                                        <?php foreach( $landings as $l ): ?>
                                                                        <label class="radio-inline landing btn btn-default">
                                                                            <input type="radio" name="landing_variant" class="button-next" value="1">
<img src="/app/promo/landings/<?=$l->alias;?>/screenshot.png" style="width: 280px; display: block;">

                                                                            <?=$l->title;?>

                                                                        </label>

                                                                        <?php endforeach; ?>




                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>
                                                        <div class="tab-pane" id="tab2">

                                                            <!-- BEGIN FORM-->
                                                            <form action="#" class="form-horizontal form-bordered form-row-stripped">
                                                                <div class="form-body">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Поток по умолчанию</label>
                                                                        <div class="col-md-9">
                                                                            <?php if( count($flows ) ) :?>

                                                                            <select class="form-control bs-select" data-live-search="true" name="flow_id" id="flow_id">
                                                                                <?php foreach( $flows as $f ): ?>


                                                                                <option value="<?=$f->id;?>"><?=$f->name;?></option>
                                                                                <?php endforeach; ?>

                                                                            </select>
                                                                                <?php else: ?>
                                                                                Не создано ни одного потока
                                                                            <?php endif; ?>
                                                                            <div class="help help-inline">Необходим, если была открыта главная страница лэндинга без перехода</div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Заголовок</label>
                                                                        <div class="col-md-9">
                                                                            <?php if( count($flows ) ) :?>

                                                                                <select class="form-control bs-select" data-live-search="true" name="term_group" id="term_group">
                                                                                    <?php foreach( $terms as $t ): ?>


                                                                                        <option value="<?=$t->id;?>"><?=$t->title;?></option>
                                                                                    <?php endforeach; ?>

                                                                                </select>
                                                                            <?php else: ?>
                                                                                Не создано ни одного потока
                                                                            <?php endif; ?>
                                                                            <div class="help help-inline">Необходим, если при переходе отстуствует utm_term и невозможно определить заголовок</div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                            <!-- END FORM-->



                                                        </div>
                                                        <div class="tab-pane" id="tab3">
                                                            <span class="help-block">Обращаем ваше внимание, что это системное название промо-материала и необходимо исключительно для вашей ориентации в материалах. Используйте понятные названия, например, имеющие связь с трафиком. </span>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Название <span class="required">
													* </span>
                                                                </label>
                                                                <div class="col-md-7">
                                                                    <input type="text" class="form-control" name="promo_name" id="promo_name">
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="tab-pane" id="tab4">

                                                            <div class="note note-success">
                                                                <h4 class="block">Материал успешно сохранен</h4>
                                                                <p>Ваш промо-материал успешно сохранен. Файл для скачивания доступен в течение 30 минут.  </p>

                                                                <p class="text-center">

                                                                    <a href="javascript:;" id="promo_link" class="btn default green-stripe"><i class="fa fa-code"></i> скачать архив </a>
                                                                </p>

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">

                                                    <div class="row">
                                                        <div class="col-md-offset-5 col-md-9">
                                                            <a href="javascript:;" class="btn default button-previous">
                                                                <i class="fa fa-arrow-left"></i> Назад </a>
                                                            <a href="javascript:;" class="btn btn-success button-next">
                                                                Дальше <i class="fa fa-arrow-right"></i>
                                                            </a>
                                                            <a href="javascript:;" class="btn green button-submit">
                                                                Сохранить <i class="m-icon-swapright m-icon-white"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>



                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1_2">
                        <div class="scroller" style="height: 337px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                            <?php if( count($my_promos)) :?>
                            <ul class="feeds">
                                <?php foreach( $my_promos as $p ): ?>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <?php if( $p->time> (time()-1800 ) ): ?>
                                                <a href="/webmaster/promo/download/<?=$p->id	;?>">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                <?=$p->promo_name;?> <span class="label label-sm label-success pull-right">Доступен для скачивания <i class="fa fa-download"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php else: ?>
                                            <div class="cont-col1">
                                                <div class="label label-sm label-danger">
                                                    <i class="fa fa-bolt"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    <?=$p->promo_name;?>
                                                    <span class="label label-sm label-danger ">Время загрузки истекло <i class="fa fa-trash"></i></span>
                                                </div>
                                            </div>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            <?php echo normal_time(($p->time));?>
                                        </div>
                                    </div>
                                </li>
                               <?php endforeach;?>

                            </ul>
                            <? else: ?>
                            <span class="text-center">Пока ничего не создано</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--END TABS-->
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>



<script src="/app/admin/pages/scripts/form-wizard.js"></script>