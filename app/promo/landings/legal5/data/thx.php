<?php
	require_once 'libs/overads.php';
	$overads = new Overads({GOAL_ID});
	$insertRequest = $overads->insertRequest('lead', $_POST["Order"]);
?>


<!DOCTYPE html>
<html class="html" lang="ru-RU">
 <head>

  <script type="text/javascript">
   if(typeof Muse == "undefined") window.Muse = {}; window.Muse.assets = {"required":["jquery-1.8.3.min.js", "museutils.js", "jquery.watch.js", "tnx.css"], "outOfDate":[]};
</script>
  
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="2015.0.1.310"/>
  <link rel="shortcut icon" href="files/a-master-favicon.ico?4218426246"/>
  <title>Спасибо за заявку. Мы с вами свяжемся</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="files/site_global.css?4052507572"/>
  <link rel="stylesheet" type="text/css" href="files/master_a-master.css?4221067954"/>
  <link rel="stylesheet" type="text/css" href="files/tnx.css?4102734447" id="pagesheet"/>
  <!--[if lt IE 9]>
  <link rel="stylesheet" type="text/css" href="files/iefonts_tnx.css?248418709"/>
  <![endif]-->
  <!-- Other scripts -->
  <script type="text/javascript">
   document.documentElement.className += ' js';
var __adobewebfontsappname__ = "muse";
</script>
  <!-- JS includes -->
  <script type="text/javascript">
   document.write('\x3Cscript src="' + (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//webfonts.creativecloud.com/pt-sans:n7,n4:default.js" type="text/javascript">\x3C/script>');
</script>
   </head>
 <body>

  <div class="clearfix" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <div class="browser_width colelem" id="u75-bw">
     <div id="u75"><!-- group -->
      <div class="clearfix" id="u75_align_to_page">
       <div class="clip_frame grpelem" id="u92"><!-- image -->
        <img class="block" id="u92_img" src="files/logo1.png" alt="" width="104" height="104"/>
       </div>
       <div class="clip_frame grpelem" id="u87"><!-- image -->
        <img class="block" id="u87_img" src="files/logo2.png" alt="" width="104" height="104"/>
       </div>
       <div class="clip_frame grpelem" id="u81"><!-- image -->
        <img class="block" id="u81_img" src="files/logo3.png" alt="" width="104" height="104"/>
       </div>
       <div class="clip_frame grpelem" id="u99"><!-- image -->
        <img class="block" id="u99_img" src="files/pasted%20image%2013x127-crop-u99.jpg" alt="" width="6" height="111"/>
       </div>
       <div class="clearfix grpelem" id="u107-7"><!-- content -->
        <p><span id="u107">БЕСПЛАТНАЯ</span> юридическая консультация</p>
        <p>При поддержке Правительства РФ</p>
       </div>
      </div>
     </div>
    </div>
    <div class="clearfix colelem" id="u214-4"><!-- content -->
     <p>Ваша заявка принята!</p>
    </div>
    <div class="clearfix colelem" id="u210-4"><!-- content -->
     <p>Как только наш юрист увидит вашу вашу заявку - он сразу с вами свяжется и проконсультирует вас. Спасибо за использование нашего сервиса!</p>
    </div>
    <div class="verticalspacer"></div>
    <div class="clearfix colelem" id="pu161"><!-- group -->
     <div class="browser_width grpelem" id="u161-bw">
      <div id="u161"><!-- simple frame --></div>
     </div>
     <div class="browser_width grpelem" id="u162-8-bw">
      <div class="clearfix" id="u162-8"><!-- content -->
       <p id="u162-3"><a class="nonblock" href="/policy.html"><span id="u162">Согласие на обработку данных и политика конфидециальности.</span></a></p>
       <p id="u162-5">ООО &quot;Овертим&quot; ИНН 7716966302, ОГРН 1127600059485 Москва, Варшавское шоссе, д.28 A.</p>
       <p id="u162-6">&nbsp;</p>
      </div>
     </div>
    </div>
   </div>
  </div>
  <!-- JS includes -->
  <script type="text/javascript">
   if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script type="text/javascript">
   window.jQuery || document.write('\x3Cscript src="files/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script src="files/museutils.js?334180058" type="text/javascript"></script>
  <script src="files/jquery.watch.js?293013060" type="text/javascript"></script>
  <!-- Other scripts -->
  <script type="text/javascript">
   $(document).ready(function() { try {
(function(){var a={},b=function(a){if(a.match(/^rgb/))return a=a.replace(/\s+/g,"").match(/([\d\,]+)/gi)[0].split(","),(parseInt(a[0])<<16)+(parseInt(a[1])<<8)+parseInt(a[2]);if(a.match(/^\#/))return parseInt(a.substr(1),16);return 0};(function(){$('link[type="text/css"]').each(function(){var b=($(this).attr("href")||"").match(/\/?css\/([\w\-]+\.css)\?(\d+)/);b&&b[1]&&b[2]&&(a[b[1]]=b[2])})})();(function(){$("body").append('<div class="version" style="display:none; width:1px; height:1px;"></div>');
for(var c=$(".version"),d=0;d<Muse.assets.required.length;){var f=Muse.assets.required[d],g=f.match(/([\w\-\.]+)\.(\w+)$/),k=g&&g[1]?g[1]:null,g=g&&g[2]?g[2]:null;switch(g.toLowerCase()){case "css":k=k.replace(/\W/gi,"_").replace(/^([^a-z])/gi,"_$1");c.addClass(k);var g=b(c.css("color")),h=b(c.css("background-color"));g!=0||h!=0?(Muse.assets.required.splice(d,1),"undefined"!=typeof a[f]&&(g!=a[f]>>>24||h!=(a[f]&16777215))&&Muse.assets.outOfDate.push(f)):d++;c.removeClass(k);break;case "js":k.match(/^jquery-[\d\.]+/gi)&&
typeof $!="undefined"?Muse.assets.required.splice(d,1):d++;break;default:throw Error("Unsupported file type: "+g);}}c.remove();if(Muse.assets.outOfDate.length||Muse.assets.required.length)c="Some files on the server may be missing or incorrect. Clear browser cache and try again. If the problem persists please contact website author.",(d=location&&location.search&&location.search.match&&location.search.match(/muse_debug/gi))&&Muse.assets.outOfDate.length&&(c+="\nOut of date: "+Muse.assets.outOfDate.join(",")),d&&Muse.assets.required.length&&(c+="\nMissing: "+Muse.assets.required.join(",")),alert(c)})()})();
/* body */
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.resizeHeight()/* resize height */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
} catch(e) { if (e && 'function' == typeof e.notify) e.notify(); else Muse.Assert.fail('Error calling selector function:' + e); }});
</script>
   </body>
</html>
