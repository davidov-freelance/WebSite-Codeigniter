<!DOCTYPE html>
<!--[if IE 8]> <html lang="ru" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="ru" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8"/>
   <title>Авторизация</title>
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
   <!-- BEGIN LOGIN FORM -->


   <form role="form" class="login-form" method="post" action="login">
      <h3 class="form-title">Вход</h3>
      <?php echo validation_errors('<div class="alert alert-danger"> <button class="close" data-close="alert"></button>', '</div>'); ?>
      <div class="alert alert-danger display-hide">
         <button class="close" data-close="alert"></button>
         <span>Введите логин и пароль</span>
      </div>
      <div class="form-group">
         <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
         <label class="control-label visible-ie8 visible-ie9">Логин или email</label>
         <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Логин или email" name="email"/>
      </div>
      <div class="form-group">
         <label class="control-label visible-ie8 visible-ie9">Пароль</label>
         <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Пароль" name="password"/>
      </div>
      <div class="form-actions">
         <button type="submit" class="btn btn-success uppercase">Войти</button>
         <label class="rememberme check"></label>
         <a href="javascript:;" id="forget-password" class="forget-password">Напомнить пароль</a>
      </div>

      <div class="create-account">
         <p>
            <a href="/register" id="register-btn" class="uppercase">Зарегистрироваться</a>
         </p>
      </div>
   </form>
   <!-- END LOGIN FORM -->
   <!-- BEGIN FORGOT PASSWORD FORM -->

   <form class="forget-form" action="#" method="post">

      <div class=" display-hide" id="recover-success">
			Письмо с дальнейшими инструкциями успешно отправлено на указанный почтовый ящик.
      </div>

      <div class="recover-form">
      <h3>Напомнить</h3>
      <div class="alert alert-danger display-hide" id="recover-error">
            <button class="close" data-close="alert"></button>
            <span>Проверьте введенные данные</span>
      </div>
      <div class="form-group">
         <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" id="recover-email"/>
      </div>
      <div class="form-group">
         <div class="g-recaptcha" data-sitekey="6Le9rhMTAAAAADDcL97VHNiakRSfhfJNhfHxNZ3T"></div>
      </div>
      <div class="form-actions">
         <button type="button" id="back-btn" class="btn btn-default">Обратно</button>
         <button type="submit" class="btn btn-success uppercase pull-right" id="recover-button">Напомнить</button>
      </div>
      </div>
   </form>
   <!-- END FORGOT PASSWORD FORM -->
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