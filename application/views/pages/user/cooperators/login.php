<!DOCTYPE html>
<html lang="ru">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title>Авторизация сотрудника</title>
   <link rel="stylesheet" href="<?=base_url();?>app/vendor/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?=base_url();?>app/css/app.css">
   <link rel="stylesheet" href="<?=base_url();?>app/vendor/fontawesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?=base_url();?>app/vendor/simplelineicons/simple-line-icons.css">
   <script src="<?=base_url();?>app/js/base.js"></script>
   <script src="<?=base_url();?>app/vendor/jquery/jquery.min.js"></script>
   <script src="<?=base_url();?>app/vendor/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

<div class="wrapper">

    <div class="block-center mt-xl wd-xl">
       <!-- START panel-->
       <div class="panel panel-dark panel-flat">
          <div class="panel-heading text-center">
             <a href="<?=base_url();?>">
                <img src="<?=base_url();?>app/img/logo.png" alt="Перейти на главную" class="block-center img-rounded" />
             </a>
          </div>
          <div class="panel-body">
             <p class="text-center pv">Пожалуйста авторизируйтесь, чтобы продолжить!</p>
             <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
             <form role="form" class="mb-lg" method="post" action="login">
                <div class="form-group has-feedback">
                   <input name="password" type="password" placeholder="Введите пароль" class="form-control" />
                   <span class="fa fa-lock form-control-feedback text-muted"></span>
                </div>
                <button type="submit" class="btn btn-block btn-primary mt-lg">Готово</button>
             </form>
          </div>
       </div>
       <!-- END panel-->
       <div class="p-lg text-center">
          <span>&copy; <?=config_item("footer_date");?> - <?=config_item("footer_name");?>
             <br/><?=config_item("site_small_descr");?></span>
       </div>
    </div>

    
</div>
</body>
</html>