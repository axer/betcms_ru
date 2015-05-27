<?php
#подключаем системные файлы
require_once '../system/system.config.php';

if (file_exists('../system/db.config.php')) {
#подключаем системные файлы
require_once '../system/db.config.php';
} else {
#путь к скрипту
define('DIR', $_SERVER['DOCUMENT_ROOT']);
}

#подключаем библиотеку для работы с БД
include_once '../system/lib/mysqli.class.php';

#указываем title-страницы
$title = 'Установка BetCMS';

#подключаем "шапку"
require_once '../system/header.php';

$mode = (isset($_GET['step'])) ? XSS($_GET['step']) : 0;

switch($mode):

case '1':

if (isset($_POST['Connect'])) {

$DB_SERVER = XSS($_POST['serverBD']);
$DB_BASE = XSS($_POST['nameBD']);
$DB_USER = XSS($_POST['userBD']);
$DB_PASS = XSS($_POST['passBD']);

$errors = false;
                
            if (empty($DB_SERVER)) $errors .= 'Укажите MySQL сервер<br />';

            if (empty($DB_USER)) $errors .= 'Укажите имя пользователя базы MySQL<br />';

            if (empty($DB_BASE)) $errors .= 'Укажите имя базы данных<br />';

            if (empty($DB_PASS)) $errors .= 'Укажите адрес сайта<br />';


if (!$errors) {

if (@$db = new SafeMySQL(array('user' => $DB_USER, 'pass' => $DB_PASS,'db' => $DB_BASE, 'charset' => 'utf8'))) {

$sql = file_get_contents('db.sql');

$quer = explode('#####################################', $sql);
$err = false;
               	foreach($quer as $query) {

				$query = trim($query);
				
                $queryGo  = $db -> query($query);
               	if (!$queryGo) $err = true;
				}
				
	if (!$err) {
show('Успешное соединение с БД!<br>
<a href="?step=2">Продолжить установку</a>');	
				
				# Создаем файл конфигурации системы
                $config_data = file_get_contents('db.config.txt');
                $config_data = str_replace('[HOST]', $DB_SERVER, $config_data);
                $config_data = str_replace('[USER]', $DB_USER, $config_data);
                $config_data = str_replace('[PASS]', $DB_PASS, $config_data);
                $config_data = str_replace('[BASE]', $DB_BASE, $config_data);

                $dir = DIR.'/system';
				chmod ($dir, 0777);
				
                file_put_contents(DIR.'/system/db.config.php', $config_data);		
			
				chmod ($dir, 0755);
				
} else fatalError('Ошибки при выполнении дампа!');				

} else fatalError('Ошибка соединения с БД. Проверьте правильность введенных данных!');

}


} else {

page('Шаг 1. Соединение с базой данных', '
<form action="" method="post">
<b>Сервер MySQL</b>:<br>
<input type="text" name="serverBD" value="localhost"><br>

<b>Имя базы данных (БД)</b>:<br>
<input type="text" name="nameBD"><br>

<b>Имя пользователя БД:</b><br>
<input type="text" name="userBD"><br>

<b>Пароль пользователя БД</b><br>
<input type="password" name="passBD"><br>

<input type="submit" name="Connect" value="Соединение">');
}
break;


case '2':

if (isset($_POST['Create'])) {


$login = (XSS($_POST['login'])) ? XSS($_POST['login']) : false;
$pass1 = (XSS($_POST['pass1'])) ? XSS($_POST['pass1']) : false;
$pass2 = (XSS($_POST['pass2'])) ? XSS($_POST['pass2']) : false;

$visa = (XSS($_POST['visa'])) ? XSS($_POST['visa']) : false;
$wm = (XSS($_POST['wm'])) ? XSS($_POST['wm']) : false;
$qiwi = (XSS($_POST['qiwi'])) ? XSS($_POST['qiwi']) : false;

$email = (XSS($_POST['email'])) ? XSS($_POST['email']) : false;
$password = ($pass1 == $pass2) ? md5(sha1(md5($pass1))) : false;
$sait = (XSS($_POST['sait'])) ? XSS($_POST['sait']) : false;


if ($login && $password && $sait && $email && ($visa || $wm || $qiwi)) {

$insert = $db -> query("INSERT INTO users (login, password, email, admin, webmoney, qiwi, visa) VALUES (?s, ?s, ?s, 1, ?s, ?s, ?s)",	$login, $password, $email, $wm, $qiwi, $visa);


$min_out = 10;
$max_out = 300;
$min_in = 10;
$max_in = 1000;
$icon_size = 102400;
$icon_height = 64;
$icon_width = 64;
$max_rate = 300;
$min_rate = 10;
$num_msg_chat = 10;

			
$insert_settings = $db->query("INSERT INTO `settings` (`chat_close`, `num_msg_chat`, `min_out`, `max_out`, `min_in`, `max_in`, `admin_qiwi`, `admin_webmoney`, `admin_visa`, `icon_size`, `icon_width`, `icon_height`, `max_rate`, `min_rate`) VALUES
(?i, ?i, ?i, ?i, ?i, ?i, ?s, ?s, ?s, ?i, ?i, ?i, ?i, ?i)", 0, $num_msg_chat, $min_out, $max_out, $min_in, $max_in, $qiwi, $wm, $visa, $icon_size, $icon_width, $icon_height, $max_rate, $min_rate);
						
				# Создаем файл конфигурации системы
                $config_data = file_get_contents('settings.txt');
                $config_data = str_replace('[NAME]', $sait, $config_data);

                file_put_contents('../system/settings.php', $config_data);


				
				
if ($insert && $insert_settings) show('Установка завершена!<br>Не забудьте удалить папку <b>install</b> из корня вашего сайта!<br><a href="../">На главную</a>');
else fatalError('Ошибка создания админа!');											

}
else fatalError('Заполните логин, пароль, email, и хотя бы один реквизит!');


} else {
page('Шаг 2. Создание админа', '
<form action="" method="post">

<b>Название сайта:</b><br>
<input type="text" name="sait"><br>

<b>Логин:</b><br>
<input type="text" name="login"><br>

<b>Пароль:</b><br>
<input type="password" name="pass1"><br>

<b>Пароль еще раз:</b><br>
<input type="password" name="pass2"><br>

<b>Email:</b><br>
<input type="text" name="email"><br>

<b>Кошелек WebMoney:</b><br>
<input type="text" name="wm"><br>

<b>Номер карты VISA:</b><br>
<input type="text" name="visa"><br>

<b>Кошелек QIWI:</b><br>
<input type="text" name="qiwi"><br>

<input type="submit" name="Create" value="Создать">');
}

break;


default:
page('Установка BetCMS', '
<strong>Что это?</strong><br>
BetCMS - это бесплатный движок для управления букмекерской конторой, с помощью которого вы запросто можете открыть свою букмекерскую контору и начать зарабатывать на ней.<br><br>

<strong>Лицензионное соглашение</strong><br>
1. Система управления букмекерской конторой, далее "BetCMS", распространяется как есть, никакой ответственности за последствия использования Вами данного скрипта мы не несем.<br>
2. "BetCMS" является полностью бесплатной и свободной для распространения.<br>
3. Запрещено продавать данную систему.<br>
4. Запрещено снимать копирайт без согласования с автором "BetCMS".<br>
5. Разрешено продавать написанные Вами дополнения.<br>
6. Разрешено продавать модифицированную Вами версию "BetCMS", не присваивая при этом авторского права, и не снимая нашего копирайта.<br><br>

<p style="color: #f00; font-family: Calibri; font-size: 20px;">
Так как движок является бесплатным,запрещается убирать/прятать и т.п. ссылку на официальный сайт.
Чтобы получить возможность снять ссылку, переведите 100 рублей на один из кошельков указанных ниже, а в комментариях к переводу напишите адрес своего сайта, на котором установлен движок БК.
</p>

Если вы хотите помочь развитию проекта, то переведите произвольную сумму на один из кошельков:<br>

<strong>WMR: R101072178745<br>
QIWI: 8-920-352-42-95
</strong><br>

<a href="?step=1">Перейти к установке</a>
');
break;

endswitch;

?>
<div class="foot">
© <a href="http://betcms.ru">Powered BetCMS</a><br>
2014-2015
</div>
</body>
</html>