<?
#проверим, активирован ли модуль
if (!active_module(dirname($_SERVER["SCRIPT_NAME"]))) fatalError('Модуль отключен');


$idUser = ID_USER;
$queryBets = $db -> query("SELECT * FROM betting WHERE who = ?i ORDER BY id", $idUser);
$numBets = $db -> numRows($queryBets);

#запускаем класс навигации
$countViewBets = 5;
$navigation = new Navigator($numBets, $countViewBets); 

$queryBets = $db -> query("SELECT * FROM betting WHERE who = ?i ORDER BY id DESC LIMIT {$navigation->start()},".$countViewBets, $idUser);


