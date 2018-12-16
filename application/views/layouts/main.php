<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title><?=$title;?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/app/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
    <link rel="stylesheet" type="text/css" href="/app/global/plugins/bootstrap-select/bootstrap-select.min.css"/>

    <link href="/app/global/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="/app/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/morris/morris.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="/app/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="/app/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="/app/global/plugins/jquery-multi-select/css/multi-select.css"/>
    
    
    <link href="/app/admin/pages/css/todo.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/app/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="/app/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

    <link rel="stylesheet" type="text/css" href="/app/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link href="/app/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="/app/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/app/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/app/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/app/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/app/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/">
                <img src="/app/img/logo-single.png" alt="logo" class="logo-default"/>
                <div class="logo-text">OVERADS</div>
            </a>
            <div class="menu-toggler sidebar-toggler"> </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU  -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide">
                    </li>




                    <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                        <a href="/money/payment" class="dropdown-toggle"  data-hover="dropdown" data-close-others="true">
                            <i class="icon-wallet"></i> <b>
                            <?php echo $this->user_model->info->money; ?> ₽ </b>&#160;&#160;
                        </a>

                    </li>

                    <li class="separator hide">
                    </li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell <?php if( $this->user_model->info->saw_news < 1 ): ?>font-green<?php endif; ?>"></i>
                            <?php if( $this->user_model->info->saw_news < 1 ): ?><i class="font-green  icon-check" id="showNews"></i><?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3><span class="bold"><?=$newsCount;?> </span><?=getPhrase($newsCount, array( 'новость', 'новости', 'новостей' )) ;?></h3>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <?php foreach( $news as $news_one ) {
                                        echo '
                                    <li>
                                        <a href="/news/view/'.$news_one->id.'" data-target=".ajaxNews" data-toggle="modal" class="showNews">
                                            <span class="time">'.showDate($news_one->added).'</span>
										<span class="details">
										<span class="label label-sm label-icon label-'.$news_one->news_type.'">
										<i class="fa fa-plus"></i>
										</span>'.$news_one->name.'</span>
                                        </a>
                                    </li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide">
                    </li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-question"></i>

                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>Помощь по системе</h3>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 235px;" data-handle-color="#637283">
                                    <li>
                                        <a href="skype:overadsteam">
										<span class="photo">
										<img src="/app/img/operator.png" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Сергей </span>
										<span class="time"> online </span>
										</span>
										<span class="message">
										Отвечу на любые вопросы </span>
										<span class="message">
										<i class="fa fa-skype"></i> overadsteam</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/tickets">
										<span class="photo">
										<img src="/app/img/operator.jpeg" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Тикет-система </span>
										<span class="time"> online </span>
										</span>
										<span class="message">
										    Создайте тикет, чтобы детально обсудить вашу проблему
                                        </span>
                                        <span class="message">
                                        <br ><button type="button" class="btn red-haze" ><span class="hidden-sm hidden-xs">Создать тикет</span></button>
                                        </span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END INBOX DROPDOWN -->
                    <li class="separator hide">
                    </li>

                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="/webmaster/settings" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="username username-hide-on-mobile"><?=$this->user_model->info->email;?></span>
                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->

                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="/webmaster/settings">
                                    <i class="icon-user"></i>Профиль </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="/account/logout">
                                    <i class="icon-key"></i> Выйти </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
                <li class="start">
                    <a href="/panel">
                        <i class="icon-home"></i>
                        <span class="title">Панель</span>
                    </a>
                </li>

                <? if( $this->user_model->info->type == "0" ): ?>
                <li>
                    <a href="/tickets">
                        <i class="icon-bubbles"></i>
                        <span class="title">Тикеты</span>
                    </a>
                </li>
                <? endif; ?>
                <? if( $this->user_model->info->type == "3" ): ?>

                <li>
                    <a href="/admin/countries">
                        <i class="icon-globe"></i>
                        <span class="title">Страны и города</span>
                    </a>
                </li>
                <? endif; ?>

                <li>
                    <a href="/news">
                        <i class="icon-book-open"></i>
                        <span class="title">Новости</span>
                    </a>
                </li>
                <? if( $this->user_model->info->type == "0" ): ?>
                <li>
                    <a href="/webmaster/places/index">
                        <i class="icon-direction"></i>
                        <span class="title">Площадки</span>
                    </a>
                </li>
                    <li>
                        <a href="/offer/list">
                            <i class="icon-call-in"></i>
                            <span class="title">Офферы</span>
                        </a>
                    </li>
                    <li>
                        <a href="/offer/my">
                            <i class="icon-star"></i>
                            <span class="title">Мои офферы </span>
                        </a>
                    </li>

                    <li>
                        <a href="/webmaster/flow/all">
                            <i class="icon-shuffle"></i>
                            <span class="title">Потоки</span>
                        </a>
                    </li>

                    <li data-link="stat">
                        <a href="/webmaster/stat/list">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Статистика</span>
                        </a>
                    </li>
                    <li data-link="stat">
                        <a href="/webmaster/promo/landing">
                            <i class="icon-magic-wand"></i>
                            <span class="title">Генерация лэндинга</span>
                        </a>
                    </li>

                <? endif; ?>

                <? if( $this->user_model->info->type == "3" ): ?>
                <li>
                    <a href="/admin/users">
                        <i class="icon-user"></i>
                        <span class="title">Пользователи</span>
                    </a>
                </li>
                    <li>
                        <a href="/admin/offer/list">
                            <i class="icon-call-in"></i>
                            <span class="title">Офферы</span>
                            <span class="pull-right icon-plus font-green" onclick="location.href='/admin/offer/add';return false;"></span>
                        </a>

                    </li>


                <li class="last ">
                    <a href="/admin/visitors">
                        <i class="icon-speedometer"></i>
                        <span class="title">Визиты</span>
                    </a>
                </li>



                    <li class="last ">
                        <a href="/admin/utm">
                            <i class="icon-tag"></i>
                            <span class="title">UTM метки</span>
                        </a>
                    </li>

                    <li class="last ">
                        <a href="/admin/helper">
                            <i class="icon-support"></i>
                            <span class="title">Помощник</span>
                        </a>
                    </li>

                <? endif; ?>

            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php if( isset( $info_msg ) ): ?>
                <div class="alert alert-<?=$info_msg['type'];?>"><?=$info_msg['msg'];?></div>
            <?php endif; ?>
            <?=$content;?>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        <?=config_item("footer_date");?> - <?=config_item("footer_name");?>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
<div class="modal fade ajaxNews"  role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="/app/global/img/loading-spinner-grey.gif" alt="" class="loading">
											<span>
											&nbsp;&nbsp;Загрузка... </span>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="access" tabindex="-1" role="access" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Оффер недоступен</h4>
            </div>
            <div class="modal-body">
                <p>
                    Данный оффер отключен или является приватным.
                    К сожалению, вам запрещен доступ к нему. Если вы можете аргументировать вашу необходимость именно в нём, напишите, пожалуйста, администратору через <a href='/tickets'>тикет систему</a>.
                </p>

                <p>Спасибо за понимание.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Закрыть</button>
                <a href='/tickets'><button type="button" class="btn red">Создать тикет</button></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--[if lt IE 9]>
<script src="/app/global/plugins/respond.min.js"></script>
<script src="/app/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/app/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/app/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->

<script type="text/javascript" src="/app/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/app/global/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.ru.js"></script>
<script type="text/javascript" src="/app/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="/app/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

<script type="text/javascript" src="/app/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/app/global/plugins/datatables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/app/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="/app/global/plugins/datatables/plugins/bootstrap/dataTables.Pagination.js"></script>
<script type="text/javascript" src="/app/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/app/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/app/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="<?=base_url();?>app/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>

<script src="/app/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->


<script type="text/javascript" src="/app/global/plugins/bootstrap-select/bootstrap-select.js"></script>
<script type="text/javascript" src="/app/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/app/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>



<script type="text/javascript" src="/app/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/app/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script src="/app/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/app/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="/app/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="/app/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="/app/admin/pages/scripts/components-pickers.js"></script>

<script type="text/javascript" src="/app/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript" src="/app/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/app/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="/app/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script src="/app/admin/pages/scripts/form-validation.js"></script>
<script src="/app/admin/pages/scripts/todo.js"></script>
<script src="/app/admin/pages/scripts/table-editable.js"></script>

<script src="/app/admin/pages/scripts/components-dropdowns.js"></script>
<script src="/app/admin/pages/scripts/components-jqueryui-sliders.js"></script>

<!-- END PAGE LEVEL SCRIPTS


-->
<? if( isset( $page ) AND $page == "flow" ): ?>
<script type="text/javascript" src="/app/admin/pages/scripts/flow.js"></script>
<? endif;?>

<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        Demo.init(); // init demo features
        //Index.init(); // init index page
        Tasks.initDashboardWidget(); // init tash dashboard widget
        if (typeof TableEditable != "undefined")
            TableEditable.init();
        FormValidation.init();
        if (typeof ComponentsPickers != "undefined")
            ComponentsPickers.init();
        if (typeof LandingFormWizard != "undefined")
            LandingFormWizard.init();


        ComponentsDropdowns.init();
        ComponentsjQueryUISliders.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>