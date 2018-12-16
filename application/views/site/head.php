<!DOCTYPE html>
<html lang="ru">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title><?=$title;?></title>
   <link rel="stylesheet" href="<?=base_url();?>app/css/app.css">
   <link rel="stylesheet" href="<?=base_url();?>app/css/theme-a.css">
   <link rel="stylesheet" href="<?=base_url();?>app/vendor/fontawesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?=base_url();?>app/vendor/simplelineicons/simple-line-icons.css">
   <script src="<?=base_url();?>app/vendor/jquery/jquery.min.js"></script>
   <script src="<?=base_url();?>app/vendor/bootstrap/js/bootstrap.min.js"></script>

   <script src="<?=base_url();?>app/vendor/fastclick/fastclick.js"></script>

   <script src="<?=base_url();?>app/js/app.js"></script>
</head>

<body class="layout-boxed">
<div id="isCollapsed">
<div class="wrapper layout-fixed">

    <!-- START Top Navbar-->
<nav role="navigation" class="navbar topnavbar ng-scope">
   <!-- START navbar header-->
   <div class="navbar-header">
      <a href="#/" class="navbar-brand">
         <div class="brand-logo">
            <img src="<?=base_url();?>app/img/logo.png" alt="App Logo" class="img-responsive" />
         </div>
         <div class="brand-logo-collapsed">
            <img src="<?=base_url();?>app/img/logo-single.png" alt="App Logo" class="img-responsive" />
         </div>
      </a>
   </div>
   <!-- END navbar header-->
   <!-- START Nav wrapper-->
   <div class="nav-wrapper">
      <!-- START Left navbar-->
      <ul class="nav navbar-nav">

               <li id="activatedCollapse">
               </li>
      </ul>
      <!-- END Left navbar-->
      <!-- START Right Navbar-->
      <ul class="nav navbar-nav navbar-right">
         <!-- START Contacts button-->
         <li>
            <a tooltip-placement="left" href="#">
            </a>
         </li>
         <li>
            <a tooltip-placement="left" href="#">
            </a>
         </li>
         <li>
		<!--<a tooltip-placement="left" tooltip="Выйти" href="<?=base_url();?>account/logout">
			<em class="fa fa-share"></em>
		</a>-->
         </li>
      </ul>
   </div>
</nav>

<aside class="aside">
<div class="aside-inner">
   <nav class="sidebar">

	<ul class="nav">
		<li class="nav-heading">Главное меню</li>
		<li><a href="<?=base_url();?>" title="Главная"><em class="fa fa-home"></em><span class="item-text">На главную</span></a></li>
		<li><a href="<?=base_url();?>for_advertisers" title="Рекламодателям"><em class="fa fa-shopping-cart"></em><span class="item-text">Рекламодателям</span></a></li>
		<li><a href="<?=base_url();?>account/login" title="Вход / Регистрация"><em class="fa fa-user"></em><span class="item-text">Вход / Регистрация</span></a></li>
	</ul>
      <!-- END sidebar nav-->
   </nav>
</div>
</aside>

<section>
   <!-- Page content-->
   <div autoscroll="false" class="content-wrapper">

