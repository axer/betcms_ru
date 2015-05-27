<?php

 #ID-события
 $idEvent = (isset($_GET['id'])) ? clear($_GET['id']) : 0;
 
 if ($idEvent) {
 
 #смотрим, что за событие
 $querySob = $db->query("SELECT * FROM events WHERE id = ?i", $idEvent);
 $sob = $db->fetch($querySob);
 $true = $db->numRows($querySob);
 
 #победитель
 $winner = $sob['result'];
 if ($winner == 1) $winner = $sob['team1'];
 if ($winner == 2) $winner = $sob['team2'];
 if ($winner == 3) $winner = 'Ничья';
 
 if ($true) {
 
 #сколько поставило на П1
 $queryP1 = $db->query("SELECT * FROM betting WHERE idsob = ?i AND onwhom = 1", $idEvent);
 #сколько поставило на П2
 $queryP2 = $db->query("SELECT * FROM betting WHERE idsob = ?i AND onwhom = 2", $idEvent);
 #сколько поставило на ничью
 $queryX  = $db->query("SELECT * FROM betting WHERE idsob = ?i AND onwhom = 3", $idEvent);
 
#считаем кол-воW
 $numP1 = $db->numRows($queryP1);
 $numP2 = $db->numRows($queryP2);
 $numX  = $db->numRows($queryX);
#считаем общее кол-во
 $allNum = $numP1 + $numP2 + $numX;
 
 if ($sob['old']) {
 
 #если событие уже закончилось - считаем статистику
 if ($sob['result'] != -1) {
	
	#сколько пользователей отгадали итог
	$queryItog = $db->query("SELECT * FROM betting WHERE idsob = ?i", $idEvent);
	
	#считаем сумму выигрыща
	$summaWin = 0;
	
	#считаем сумму проигрыша
	$summaLose = 0;
	
	while ($summaWinner = $db->fetch($queryItog)) {
	
	#если выигрышь
	if ($summaWinner['onwhom'] == $sob['result']) 
			$summaWin += $summaWinner['how'];
	#если проигрышь
	else
			$summaLose += $summaWinner['how'];
	
	}
	
 
 }
 
 #итоговая сумма (для рассчета прибыли/убытка)
 $itog = $summaLose - $summaWin; 
 
 } 
 
 }
 
 }