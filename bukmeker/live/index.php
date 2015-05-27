<?php
#подключаем системные файлы
require_once '../../system/system.config.php';

#подключаем БД
require_once '../../system/db.config.php';
$title = 'BetCMS - LIVE - Результаты';

#подключаем "шапку"
require_once '../../system/header.php';

#проверим, активирован ли модуль
if (!active_module(dirname($_SERVER["SCRIPT_NAME"]))) fatalError('Модуль отключен');


$file=file_get_contents('http://mobilesports.ru/copyright/live/results.php'.$_SERVER['QUERY_STRING']);
$file=str_replace('<div class="logo"><img src="style/logo.png" alt="" /></div>','<div class="head"><img src="/style/default/imgs/big_buk_ru.png" alt="" /></div>',$file);
$file=str_replace('Live Результаты','Live-результаты',$file);
$file=str_replace('http://mobilesports.ru/theme/default/style.css','../style/default/style.css',$file);
$file=str_replace('<img src="http://mobilesports.ru/theme/default/images/logo.png" alt=""/>','',$file);
$file=str_replace('<link rel="alternate" type="application/rss+xml" title="RSS  Новости спорта" href="http://mobilesports.ru/rss/news.php" />', '', $file);
$file=str_replace('<link rel="alternate" type="application/rss+xml" title="RSS  Статьи" href="http://mobilesports.ru/rss/articles.php" />', '', $file);
$file=str_replace('<div style="text-align:center"></div>', '', $file);
$file=str_replace('На главную','',$file);
$file=str_replace('Вход','',$file);
$file=str_replace('Регистрация','',$file);
$file=str_replace('|','',$file);
$file=str_replace('<br />','',$file);
$file=str_replace('Обновить','',$file);
$file=str_replace('<a href="http://mobilesports.ru/dv/">ДругВокруг - Java-приложение для знакомств и общения!</a>','',$file);
$file=str_replace('<a href="http://vk.com/share.php?url=http://mobilesports.ru"><img src="http://mobilesports.ru/img/vk.png"/></a>','',$file);
$file=str_replace('<a href="http://facebook.com/sharer.php?u=http://mobilesports.ru"><img src="http://mobilesports.ru/img/fb.png"/></a>','',$file);
$file=str_replace('<a href="http://twitter.com/home?status=mobilesports.ru"><img src="http://mobilesports.ru/img/tw.png"/></a>','',$file);
$file=str_replace('<a href="http://connect.mail.ru/share?share_url=http://mobilesports.ru"><img src="http://mobilesports.ru/img/mr.png"/></a>','',$file);
$file=str_replace('<a href="http://odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=http://mobilesports.ru"><img src="http://mobilesports.ru/img/ok.png"/></a>','',$file);
$file=str_replace('<div class="hdr">','<div class="r1_golov">',$file);
$file=str_replace('http://mobilesports.ru/theme/default/images/back.png','',$file);
$file=str_replace('<div class="phdr">','<div class="r1_golov">',$file);
$file=str_replace('<div class="logo"><a href="/"><img src="http://mobilesports.ru/theme/default/images/2.png" alt=""/></a></div><ul class="tmn"><li class="on"><a href="/"><img src="http://mobilesports.ru/theme/default/images/tmn_left_on.png" alt=""/>Главная</a></li><li><a href="http://mobilesports.ru/login.php"></a></li><li><a href="http://mobilesports.ru/registration.php"><img src="http://mobilesports.ru/theme/default/images/tmn_right_off.png" alt=""/>Рега.</a>','',$file);
$file=str_replace('<div class="bmenu">','<div class="r1">',$file);
$file = preg_replace('/<div class="footer">(.*?)<\/html>/si','',$file);
$file=str_replace('<div class="d1">Результаты online</div> <div class="r1">','<div class="r1_golov">Результаты Онлайн</div>',$file);
echo $file;

#подключаем "ноги"
require_once '../../system/footer.php';
?>
