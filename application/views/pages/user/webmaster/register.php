<!DOCTYPE html>
<!--[if IE 8]> <html lang="ru" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="ru" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Регистрация</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/app/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/app/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="/app/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/app/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/app/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/app/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/app/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login ">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler"></div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="/app/img/logo.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <?php if(config_item("open_reg")):?>
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" method="post">
        <h3>Присоединиться</h3>
        <p class="hint">
            Заполните все поля:
        </p>
        <?php echo validation_errors('<div class="alert alert-danger"> <button class="close" data-close="alert"></button>', '</div>'); ?>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Логин</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Логин" name="login"/>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Пароль</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Пароль" name="password"/>
        </div>
        <div class="form-group">
            <p class="hint">Ответьте на вопрос: <b><span id="question_value"><?=$question;?></span></b></p>
            <input type="text" placeholder="Ответ" id='answer' name="answer" class="form-control placeholder-no-fix" />
        </div>


        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6Le9rhMTAAAAADDcL97VHNiakRSfhfJNhfHxNZ3T"></div>
        </div>

        <div class="form-actions">
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Готово</button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
    <?php else:?>
        <p class="text-center pv">Регистрация вебмастеров на данный момент закрыта, вы можете <a href="<?=base_url();?>#registr">оставить заявку</a> на рассмотрение, и мы свяжемся с вами в течение 3-ех часов</p>
    <?php endif;?>



</div>
<div class="copyright">
  <span>&copy; <?=config_item("footer_date");?> - <?=config_item("footer_name");?>
      <br/><?=config_item("site_small_descr");?></span>

</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/app/global/plugins/respond.min.js"></script>
<script src="/app/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/app/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/app/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/app/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/app/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/app/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/app/admin/pages/scripts/login.js" type="text/javascript"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Login.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>