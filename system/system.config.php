<?php

#выключаем показ ошибок
error_reporting(E_ALL);
ini_set("display_errors", 1);

/* if (file_exists('db.config.php')) {

#подключаем настройки сайта
require_once 'settings.php';
} */

require_once 'lib/mail.php';

#id-пользователя (доступна после авторизации)
if (isset($_SESSION['userId'])) {
define('ID_USER', $_SESSION['userId']);
}



#функция для "создания" странички
function page($title,$text){
	echo '<div class="r1_golov">'.$title.'</div><div class="r1">'.$text.'</div>';
}


#функция подсчета событий, которые нужно расчитать
function numEventCalc() {
	global $db;
	
	$timeNow = time();
	
	$queryCalculation = $db -> query("SELECT * FROM events WHERE timestart < $timeNow AND old = 0");
	$numCalculation = $db -> numRows($queryCalculation);
	
	return $numCalculation;	
}


#функция подсчета пользователей запросивших на ввод
function usersInput() {

global $db;

$queryIn = $db -> query("SELECT * FROM input_means WHERE confirm = 0");
$numIn = $db -> numRows($queryIn);

return $numIn;
}


#функция подсчета пользователей запросивших на вывод
function usersOutput() {

global $db;

$queryOut = $db -> query("SELECT * FROM output_means WHERE confirm = 0");
$numOut = $db -> numRows($queryOut);

return $numOut;
}


#общее кол-во пользователей в системе
function numUsers() {
	global $db;
	
	$query = $db -> query("SELECT * FROM users");
	$num = $db -> numRows($query);
	
	return $num;
}


#всего денег в системе
function allMoney() {
	global $db;

	$amount = $db -> getOne("SELECT SUM(balance) FROM users");
	
	return round($amount, 2);
}


#очистка данных. Защита от XSS.
function XSS($var) {
    $var = trim($var);
    $var = htmlspecialchars($var);
    $var = stripslashes($var);
    
    return $var;
}

#очистка числовых данных
function clear($var){
    $var = trim($var);
    $var = abs($var);
    $var = intval($var);
    
    return $var;
}

#функция для вывода ошибок
function errors($text) {
	echo '<div class="r1_golov">Ошибка</div>';
    echo '<div class="r1">';
    echo $text;    
    echo '</div>';
}

#функция для вывода фатальных ошибок (останавливает дальнейшее выпонение сценария)
function fatalError($text) {
    echo '<div class="r1_golov">Ошибка</div>';
    echo '<div class="r1">';
    echo $text;    
    echo '</div>';
    require_once 'footer.php';
    exit();
}

#вывод информации
function show($text) {
	echo '<div class="r1_golov">Информация</div>';
    echo '<div class="r1">';
    echo $text;
    echo '</div>';
}

#функция проверки email
function CheckEmail($email) {
global $db;

$match = 0;

#производим запрос в базу (поиск совпадений)
$query = $db -> query("SELECT `id` FROM `users` WHERE `email` = ?s ", $email);
if ($db -> numRows($query) > 0) 
#если нашли совпадение, то увеличиваем кол-во совпадений
$match++;


#база доменов, которые являются зеркалами
$baseEmail = array('yandex.com', 'yandex.ua', 'yandex.kz', 'yandex.by', 'ya.ru', 'yandex.ru');

#обрезаем E-mail до символа @
$emailShort = explode('@', $email);

#выбираем имя почтового ящика
$nameEmail = $emailShort[0];

#выбираем домен и зону
$domenAndZona = $emailShort[1];

#ищем домен и зону в нашей базе $baseEmail
if (in_array($domenAndZona, $baseEmail)) {
#если нашелся такой домен с зоной в базе, то проверяем,
#не регистрировался ли уже кто-то с этим email

#кол-во совпадений
$match = 0;

#перебираем базу до конца
foreach ($baseEmail as $domenZona) {

#формируем email
$newEmail = $nameEmail.'@'.$domenZona;

#производим запрос в базу (поиск совпадений)
$query = $db -> query("SELECT `id` FROM `users` WHERE `email` = ?s ", $newEmail);
if ($db -> numRows($query) > 0) 
#если нашли совпадение, то увеличиваем кол-во совпадений
$match++;

}

} 

#если уже регистрировались с этим именем почты, то выдаем false, иначе true
if ($match) 
return false;
else
return true;
}



#функция вывода ближайших события (в скобках указывается, кол-во матчей)
function forthcoming_events($count) {
        global $db;
   
   #проверяем больше ли 0 записей мы просим вывести
   $count = ($count > 0) ? $count : 1;
        
   #время сейчас
   $timeNow = time();
   
   #запрос на выборку событий, которые еще не начались
   $queryEvents = $db -> query("SELECT * FROM events WHERE timestart > ?i ORDER BY timestart LIMIT ?i", $timeNow, $count); 
   #кол-во
   $numSob = $db->numRows($queryEvents);
   #выводим события
?>
<div class="r1_golov">Ближайшие события</div>
<div class="r1">Выводится <?=$count?> ближайших события</div>
<?
if ($numSob) {
   while($event = $db -> fetch($queryEvents)) {
    
    #выбираем из базы название "раздела", в котором находится событие
   $querySection = $db->query("SELECT * FROM sections WHERE id = ?i ", $event['section']);
   $dataSection  = $db->fetch($querySection);
?>	
<div class="r1_golov">
<?=$dataSection['title'] ?> <? echo $event['team1'], ' - ', $event['team2']; ?>
</div>
<div class="r1">
Начало: <? echo date('d-m-Y H:i', $event['timestart']), '<br>'; ?>
Коэфф.: 
<? echo '
<a href="put.on/?event='.$event['id'].'&outcome=1">[П.1 - ', $event['factor1'], ']</a> 
<a href="put.on/?event='.$event['id'].'&outcome=3">[Н.X - ', $event['factor0'], ']</a>
<a href="put.on/?event='.$event['id'].'&outcome=2">[П.2 - ', $event['factor2'], ']</a>'; 
?>

<? if (is_admin($_SESSION['userId'])) { ?>
<br>
<a href="/panel/statistic/?id=<?=$event['id']?>">[Статистика события]</a>
<? } ?>

</div>
<?

   }
   } else {
   ?>
   <div class="r1">Событий нет</div>
   <?
   }
   
}



#баланс пользователя, в аргументах передается ID-пользователя
function userBalance($id) {
    global $db;
    
    $query = $db -> query("SELECT * FROM users WHERE id = ?i", $id);
    $fetch = $db -> fetch($query);
    
    return round($fetch['balance'], 2);
}


#логин пользователя, в аргументах передается ID-пользователя
function userLogin($id) {
	global $db;
	
	$query = $db -> query("SELECT * FROM users WHERE id = ?i", $id);
	$fetch = $db -> fetch($query);
	
	return $fetch['login'];
}

#вывод всех существующих турниров
function all_tournaments() {
    global $db;
    
    ?>
    <div class="r1_golov">Все турниры</div>
	<div class="r1">
    <?
    $query = $db -> query("SELECT * FROM sections");
	$numTurnir = $db -> numRows($query);
	
	if ($numTurnir) {
	$timeNow = time();
    while ($tournament = $db -> fetch($query)) {
	$queryEv = $db->query("SELECT * FROM events WHERE section = ?i AND old = 0 AND timestart > ?i", $tournament['id'], $timeNow);
	$numEv = $db->numRows($queryEv);
 ?>       
        
        <?if ($numEv > 0) { ?>
		<a href="events/?section=<?=$tournament['id']; ?>">
		<img width="15px" height="15px" src="../style/default/imgs/gl3.png"> <?=$tournament['title']; ?>
        </a> [<?=$numEv;?>]<br>
		<?}?>
        
 <?       
    }
	?>
	</div>
	<?
	} else {
	?>
	<div class="r1">Турниров не найдено</div>
	<?
	}
    
}


#функция проверки заполнения реквизитов (в аргементах ID-пользователя)
function checkDetails($id) {
    
    global $db;
    
    $queryDetails = $db -> query("SELECT * FROM users WHERE id = ?i", $id);
    $dataDetails = $db -> fetch($queryDetails);
    
    #проверяем на заполненность
    if (!$dataDetails['webmoney'] && !$dataDetails['qiwi'] && !$dataDetails['visa']) {
        fatalError('У вас не заполнено ни одного реквизита!');
    }
    
}


#проверяем на заполненность wmr
function checkWMR($id) {
    
    global $db;
    
    $queryWMR = $db -> query("SELECT * FROM users WHERE id = ?i", $id);
    $dataWMR = $db -> fetch($queryWMR);
    
        #проверяем заполненность wmr
    if (!$dataWMR['webmoney']) 
    return false;
    else
    return true;
}


#проверяем на заполненность qiwi
function checkQIWI($id) {
    
    global $db;
    
    $queryQIWI = $db -> query("SELECT * FROM users WHERE id = ?i", $id);
    $dataQIWI = $db -> fetch($queryQIWI);
    
        #проверяем заполненность wmr
    if (!$dataQIWI['qiwi']) 
    return false;
    else
    return true;
}


#проверяем на заполненность visa
function checkVisa($id) {
    
    global $db;
    
    $queryVisa = $db -> query("SELECT * FROM users WHERE id = ?i", $id);
    $dataVisa = $db -> fetch($queryVisa);
    
        #проверяем заполненность wmr
    if (!$dataVisa['visa']) 
    return false;
    else
    return true;
}






#функция для проверки пользователя на привилегии админа
function is_admin($id) {

$id = clear($id);
global $db;

if (!$id) fatalError('Такого пользователя не существует!');

$query = $db->query("SELECT * FROM users WHERE id = ?i", $id);
$user = $db->fetch($query);

if (($user['admin'] == 1) && isset($_SESSION['userAdmin']) && !empty($_SESSION['userAdmin'])) 
return true;
else
return false;


}



#вывод модулей
function view_modules() {
global $db;
$select = $db->query("SELECT * FROM modules ORDER BY id");


while ($modules = $db->fetch($select)) {
if ($modules['active']) {
	?>
<img width="15px" height="15px" src="../style/default/imgs/<?=$modules['icon']?>"><a href="<?=$modules['link']?>"><?=$modules['name']?></a><br>
	<?
						}
}

}

#проверка модуля на активацию
function active_module($link) {
global $db;

$select = $db->query("SELECT * FROM modules WHERE link = ?s", $link);
$module = $db->fetch($select);

if ($module['active']) return true;
						   else
					   return false;
}



function genRnd($number)  
  {  
    $arr = array('a','b','c','d','e','f',  
                 'g','h','i','j','k','l',  
                 'm','n','o','p','r','s',  
                 't','u','v','x','y','z',  
                 'A','B','C','D','E','F',  
                 'G','H','I','J','K','L',  
                 'M','N','O','P','R','S',  
                 'T','U','V','X','Y','Z',  
                 '1','2','3','4','5','6',  
                 '7','8','9','0');  
    // Генерируем пароль  
    $pass = "";  
    for($i = 0; $i < $number; $i++)  
    {  
      // Вычисляем случайный индекс массива  
      $index = rand(0, count($arr) - 1);  
      $pass .= $arr[$index];  
    }  
    return $pass;  
  } 