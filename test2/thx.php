<?php
	require_once 'libs/overads.php';
	$overads = new Overads(205);
	$insertRequest = $overads->insertRequest('lead', $_POST["Order"]);
?>




<!DOCTYPE HTML>
<html class="thanks">
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KP9RT5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KP9RT5');</script>
<!-- End Google Tag Manager -->
<head>
<meta charset="utf-8">
<title>Спасибо за обращение!</title>

<link rel="shortcut icon" type="image/x-icon" href="files/favicon.ico">
<link rel="stylesheet" type="text/css" href="files/style.css">
<!--[if lte IE 8]>
<script type="text/javascript" src="files/html5.js"></script>
<![endif]-->

</head>

<body class="thanks">

<div style="display:inline;">
</div>

    <div id="wrapper">
            <div id="main">
            	<div class="inner">
		    <div class="confirm_block">
			<div class="confirm_block_green">Спасибо за ваше обращение.</div>
			<div class="confirm_block_desc">Мы с вами свяжемся в самое ближайшее время<br> и проконсультируем по всем вопросам.</div>
			</div>
		</div>
            </div>
    </div>

</body>
</html>