<?php
	require_once 'libs/overads.php';
	$overads = new Overads(212, 14);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no">
	<title>Бесплатная юридическая помощь</title>
    <link rel="shortcut icon" type="image/x-icon" href="files/favicon.ico">
	<link rel="stylesheet" type="text/css" href="files/chosen.style.css" />
	<link rel="stylesheet" type="text/css" href="files/style.css" />
	
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	
	<!--[if IE 8]>
		<link href="files/style_ie.css" type="text/css" rel="stylesheet">
	<![endif]-->
	<!--[if lt IE 9]><script src="files/html5.js"></script><![endif]-->

</head>
<body>


	<header>
		<div class="wrapper">

			<a href="#"><img src="files/main_logo_main.png" width="220" height="47" alt=""></a>
			<div class="boxPhone">
				<p><?=$overads->data->phone;?></p>
				<a href="#win_1" class="modal">заказать звонок</a>
			</div>
		</div>
	</header>

	<div class="content">
		<div class="boxInfo1">
			<div class="wrapper">
				<h1><?=$overads->data->title?></h1>
				<div class="columnLeft">
					<h3>УСЛУГИ:</h3>
					<div class="list1">
						<ul>
						
							<li>Исковые заявления в суд</li>
						
							<li>Права собственности</li>
						
							<li>Наследование имущества</li>
						
							<li>Сделки с недвижимостью</li>
						
							<li>Семейные споры</li>
						
							<li>Возмещение ущерба</li>
						
							<li>Права потребителей</li>
						
							<li>Консультации юридических лиц</li>
						
							<li>Вопросы ДТП и ГИБДД</li>
						
							<li>Взыскание алиментов</li>
						
							<li>Взыскание долгов</li>
						
							<li>Уголовные дела</li>
						
						</ul>
					</div>
				</div>
				<div class="columnRight">
					<div class="formFeedback">
						<h3>ЗАДАЙТЕ ВОПРОС ЮРИСТУ</h3>
						<p>ПОЛУЧИТЕ ОТВЕТ В ТЕЧЕНИЕ 15 МИНУТ</p>
						<form class="sform q" method="post" action="thx.php">
							<input type="text" name="Order[fio]" value="" placeholder="Имя*">
							<input class="tel_mask" type="text" name="Order[phone]" value="" placeholder="Телефон*">
							<select class="countrySelect" data-placeholder="Выберите страну..."  name="Order[country_id]" data-live-search="true"></select>
							<select class="citySelect" data-placeholder="Выберите город..."  name="Order[city_id]" data-live-search="true"></select>
							<textarea name="Order[param1]" cols="1" rows="1" placeholder="Кратко опишите Вашу проблему"></textarea>
							<input type="submit" value="ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ">
						</form>
					</div>
					<p class="footnote">В соответствии с Федеральным законом Российской Федерации от 27 июля 2006 г. N 152 «О персональных данных» — мы гарантируем полную анонимность всех консультаций.</p>
				</div>
			</div>
		</div>
		<div class="wrapper">
			<div class="listPartners">
				<h2>ПРОЕКТ ОСУЩЕСТВЛЯЕТСЯ ПРИ ПОДДЕРЖКЕ</h2>
				<ul>
					<li>



						<div class="icon"><img src="files/arms_1.png" width="88" height="108" alt=""></div>
						<p>Федеральное агентство по печати и массовым коммуникациям</p>
					</li>
					<li>
						<div class="icon"><img src="files/arms_2.png" width="97" height="103" alt=""></div>
						<p>Министерство юстиции Российской Федерации</p>
					</li>
					<li class="last">
						<div class="icon"><img src="files/arms_3.png" width="88" height="108" alt=""></div>
						<p>Правительство Москвы</p>
					</li>
				</ul>
			</div>
			<div class="textInfo">
				<h2>ИНФОРМАЦИЯ О ЦЕНТРЕ</h2>
				<p>
				
				  Центр Юридической Помощи
				
				способствует реализации физическими и юридическими лицами своих законных прав с 2006 г. К настоящему времени за бесплатной консультацией в Центр обратилось более 280 000 жителей Москвы и Московской области. Вас консультируют 76 профессиональных юристов и адвокатов, специалистов со значительным опытом в различных областях права.</p>
				<p>Для того чтобы отправить свой вопрос нашему юристу, пожалуйста, внимательно заполните все поля. Мы гарантируем конфеденциальность введенной Вами информации и обеспечиваем полную анонимность консультаций. </p>
				<p>Помимо бесплатной помощи по телефону, специалисты Центра осуществляют <br>квалифицированную защиту интересов граждан и организаций в различных инстанциях, судах, и оказывают весь спектр юридических услуг: ведение дел, составление жалоб, выезд адвоката, составление исковых заявлений, письменные заключения, обжалование решений и прочее.</p>
			</div>
			<div class="listSpecialists">
				<h2>НАШИ ЛУЧШИЕ СПЕЦИАЛИСТЫ</h2>
				<ul>
					<li>
						<div class="img"><img src="files/photo_1.jpg" width="190" height="290" alt=""></div>
						<p class="name">Борисов Олег Викторович</p>
						<p>Юрист по гражданскому <br>и семейному праву, <br>опыт 32 года.</p>
						<a href="#win_1" class="modal">получить консультацию</a>
					</li>
					<li>
						<div class="img"><img src="files/photo_2.jpg" width="190" height="290" alt=""></div>
						<p class="name">Фомин Николай Алексеевич</p>
						<p>Адвокат по уголовным делам, представительство в суде опыт 14 лет.</p>
						<a href="#win_1" class="modal">получить консультацию</a>
					</li>
					<li>
						<div class="img"><img src="files/photo_3.jpg" width="190" height="290" alt=""></div>
						<p class="name">Липатова Мария Викторовна</p>
						<p>Юрист по трудовому праву, защита прав потребителей, опыт 11 лет.</p>
						<a href="#win_1" class="modal">получить консультацию</a>
					</li>
					<li>
						<div class="img"><img src="files/photo_4.jpg" width="190" height="290" alt=""></div>
						<p class="name">Вознесенский Валерий Николаевич</p>
						<p>Юрист по жилищному и земельному праву, <br>опыт 29 лет.</p>
						<a href="#win_1" class="modal">получить консультацию</a>
					</li>
					<li>
						<div class="img"><img src="files/photo_5.jpg" width="190" height="290" alt=""></div>
						<p class="name">Сааков Карен Георгиевич</p>
						<p>Юрист общего профиля, <br>опыт 8 лет.</p>
						<a href="#win_1" class="modal">получить консультацию</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="boxInfo2">
			<div class="wrapper">
				<h2>С НАМИ ВЫГОДНО</h2>
				<div class="columnLeft">
					<div class="list1 option2">
						<ul>
							<li>Каждое дело ведет команда специалистов со знаниями и опытом в различных <br>сферах права.</li>
							<li>Полезные связи. Наши юристы и адвокаты в прошлом сотрудники судов и налоговых органов.</li>
							<li>Получение с ответчика не только реальной стоимости ущерба, но и упущенной выгоды, штрафов, неустоек, процентов и т.д.</li>
							<li>Уплаченное нам вознаграждение и другие судебные расходы мы взыскиваем с ответчика и возвращаем Вам.</li>
						</ul>
					</div>
				</div>
				<div class="columnRight">
					<div class="formFeedback">
						<h3>ЗАДАЙТЕ ВОПРОС ЮРИСТУ</h3>
						<p>ПОЛУЧИТЕ ОТВЕТ В ТЕЧЕНИЕ 15 МИНУТ</p>
						<form class="sform q" method="post" action="thx.php">
							<input type="text" name="Order[fio]" value="" placeholder="Имя*">
							<input class="tel_mask" type="text" name="Order[phone]" value="" placeholder="Телефон*">
							<select class="countrySelect" data-placeholder="Выберите страну..."  name="Order[country_id]" data-live-search="true"></select><select class="citySelect" data-placeholder="Выберите город..."  name="Order[city_id]" data-live-search="true"></select>
							<textarea name="Order[param1]" cols="1" rows="1" placeholder="Кратко опишите Вашу проблему"></textarea>
							<input type="submit" value="ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="wrapper">
			<div class="textInfo2">
				<h2>ПОЧЕМУ БЕСПЛАТНО</h2>
				<p>Бесплатная помощь юриста - это не новинка на рынке юридических услуг. Успешные российские и западные юридические корпорации уже много лет практикуют оказание безвозмездной юридической помощи. </p>
				<p>Благодаря этой практике граждане могут получить информацию и совет по своей проблеме от компетентного лица, разобраться с его помощью во множестве юридических нюансов, в законах, положениях и документах.
</p>
				<p class="top">Все консультации осуществляются опытными практикующими юристами и адвокатами, в рамках исполнения Федерального закона от 21.11.2011 N 324-ФЗ «О бесплатной юридической помощи в Российской Федерации» и Государственной Программы Юридической поддержки населения.</p>
			</div>
			<div class="boxComments">
				<h2>НАМ ДОВЕРЯЮТ</h2>
				<ul>
					<li>
						<div class="photo"><img src="files/photo_6.jpg" width="150" height="150" alt=""></div>
						<div class="comment">
							<p class="name">Елисеев Серафим Богданович, Москва</p>
							<p>Очень приятно, что юристы вашей компании не боятся признавать ошибки. За 10 минут исправили формулировку в претензии к страховой компании. После 10 дней рассмотрений страховая компания так и не выплатила всю сумму по ОСАГО. После чего мы составили исковое заявление в суд. Спустя два месяца  выиграли 189 000 руб, вместо 70 000 руб. необходымых на ремонт моего автомобиля. Юристы включили все издержки на ведение дела в суде. В итоге я не потратил на правовую помощь ни копейки своих денег.</p>
						</div>
					</li>
					<li class="right">
						<div class="photo"><img src="files/photo_7.jpg" width="150" height="150" alt=""></div>
						<div class="comment">
							<p class="name">Белякова Мария Владимировна, Москва</p>
							<p>Обращалась в данную компанию по совету друзей, которые раньше уже имели место с данной фирмой. Обращаюсь в подобные организации впервые, поэтому не знаю всех тонкостей бизнеса и как сравинвать с другими компаниями. Мне же все услуги были оказаны в соответствии с договором: представили в суде мои интересы и получили положительное решение. Наверное, это показатель, хотя не знаю, с чем сравнивать. Просто делюсь опытом работы с данной компанией, может, кому-то поможет..</p>
						</div>
					</li>
					<li>
						<div class="photo"><img src="files/photo_8.jpg" width="150" height="150" alt=""></div>
						<div class="comment">
							<p class="name">Мироненко Алексей Федорович, Москва</p>
							<p>Я обратился за юридической помощью, когда к моей фирме был предъявлен иск лизинговой компанией на 1,8 млн. рублей. Я был уверен, что выиграть дело невозможно. К моему изумлению специалисты компании нашли нестандартное решение и подали встречный иск. Результат — мировое соглашение на 5 млн. в мою пользу. Правовой центр сдержал свое обещание, что выигрывают дела в суде. Хочу выразить свою признательность коллективу компании и лично адвокату Вознесенскому В.Н.</p>
						</div>
					</li>
					<li class="right">
						<div class="photo"><img src="files/photo_9.jpg" width="150" height="150" alt=""></div>
						<div class="comment">
							<p class="name">Лазарева Марианна Магомедовна, Москва</p>
							<p>Я очень благодарна вашей компании! Была ответчицей по делу в гражданском суде, который длился с февраля до конца марта. Дело было сложным, но мы выиграли. Адвокат Мещерский С. П. подошел к делу с высоким профессионализмом и переживал не меньше моего об исходе дела. Я очень рада, что в непростой период моей жизни за юридической помощью я обратилась именно к вам!</p>
						</div>
					</li>
					<li>
						<div class="photo"><img src="files/photo_10.jpg" width="150" height="150" alt=""></div>
						<div class="comment">
							<p class="name">Мокрохин Михаил Олегович, Москва</p>
							<p>Ходил за консультацией по делу, где все адвокаты твердили что дело выиграшное, только заплатите нам столько то денег (дело по взысканию долга без расписки). Уже даже готов был дать одной из них. Но слава Богу пришел в Московский правовой центр, где сказали, что и как. Сказали, что шансы есть, но не большие. И дали возможность думать самому, а это важно. </p>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="boxInfo3">
			<div class="wrapper">
				<h2>ОСТАЛИСЬ ВОПРОСЫ?</h2>
				<div class="columnLeft">
					<p><span></span></p>
				</div>
				<div class="columnRight">
					<div class="formFeedback option2">
						<h3>ЗАКАЖИТЕ ЗВОНОК</h3>
						<form class="sform" method="post" action="thx.php">
							<input type="text" name="Order[fio]" value="" placeholder="Имя*">
							<input  class="tel_mask" type="text" name="Order[phone]" value="" placeholder="Телефон*">
							<select class="countrySelect" data-placeholder="Выберите страну..."  name="country_iid" data-live-search="true"></select><select class="citySelect" data-placeholder="Выберите город..."  name="city_id" data-live-search="true"></select>
							<input type="submit" value="ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ">
						</form>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</div>



	<div class="mask"></div>
	<div class="windowOpen" id="win_1">
		<div class="windowCont">
			<a class="closeWindow"></a>
			<div class="formFeedback">
				<h3>ЗАКАЖИТЕ ЗВОНОК <br>ЮРИСТА</h3>
				<p>ПЕРЕЗВОНИМ В ТЕЧЕНИЕ 15 МИНУТ</p>
				<form class="sform" method="post" action="thx.php">
					<input type="text" name="Order[fio]" value="" placeholder="Имя*">
					<input class="tel_mask" type="text" name="Order[phone]" value="" placeholder="Телефон*">
					<select class="countrySelect" data-placeholder="Выберите страну..."  name="Order[country_id]" data-live-search="true"></select>
							<select class="citySelect" data-placeholder="Выберите город..."  name="Order[city_id]" data-live-search="true"></select>
					<input type="submit" value="ЗАКАЗАТЬ ЗВОНОК">
				</form>
			</div>
		</div>
	</div>

    <script type="text/javascript" src="files/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="files/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="files/jquery.inputmask.js"></script>
    <script type="text/javascript" src="files/custom.js"></script>
	<script src="files/chosen.jquery.js" type="text/javascript"></script>
	<script src="files/prism.js"></script>

	<script src="<?=$overads->script_url;?>/landing.js?hash=<?=$overads->hash;?>&goal_id=<?=$overads->goalId;?>"></script>


<p class="footer text-center">
<a href="policy.html">Согласие на обработку данных и политика конфидециальности.</a>
<br>
<noindex>ООО "Овертим" ИНН 7716966302, ОГРН 1127600059485 Москва, Варшавское шоссе, д.28 A.</noindex>
</p>

</body>
</html>

