<div class="r1_golov">Мои ставки</div>
<div class="r1">
Здесь вы можете просмотреть все события, на которые делали ставку.
</div>


<?
$numBet = $db->numRows($queryBets);

if ($numBet) {
while ($dataBet = $db -> fetch($queryBets)) { 
    $queryEvent = $db -> query("SELECT * FROM events WHERE id = ?i", $dataBet['idsob']);
    $event = $db -> fetch($queryEvent);
    
    $itog = '';
	$status = '';
    $bet = '';
	
    if ($dataBet['onwhom'] == 1) $bet = $event['team1'];
    if ($dataBet['onwhom'] == 2) $bet = $event['team2'];
    if ($dataBet['onwhom'] == 3) $bet = 'Ничья';
    
    if ($event['old'] && $dataBet['onwhom'] != $event['result']) $status = 'Проигран';
    if ($event['old'] && $dataBet['onwhom'] == $event['result']) $status = 'Выигран';
    if (!$event['old'] && $event['result'] > 0) 				 $status = 'В игре';
	
	if ($event['result'] < 0 ) 
	{
			$status = 'В игре';
			$itog   = ' - ';
	} else {
 	if ($event['result'] == 3) $itog = 'Ничья';
	if ($event['result'] == 2) $itog = 'Победа П2';
	if ($event['result'] == 1) $itog = 'Победа П1';
}
	

	
    
        #выбираем из базы название "раздела", в котором находится событие
   $querySection = $db -> query("SELECT * FROM sections WHERE id = ?i ", $event['section']);
   $dataSection = $db -> fetch($querySection);
?>

<div class="r1_golov">
<strong>
<?=$dataSection['title']?> <? echo $event['team1'], ' - ', $event['team2']; ?>
</strong>
</div>
<div class="r1">
<strong>Начало: </strong> <? echo date('d-m-Y H:i', $event['timestart']); ?><br />
<strong>Коэфф.: </strong>
<? echo '
[П.1 - ', $event['factor1'], ']
[Н.X - ', $event['factor0'], ']
[П.2 - ', $event['factor2'], ']<br />'; 
?>

<strong>Ваша ставка на: </strong> <? echo $bet; ?><br />
<strong>Сумма ставки: </strong> <? echo $dataBet['how'], ' руб.'; ?> <br />
<strong>Получите при выигрыше: </strong> <? echo $dataBet['howwin'], ' руб.'; ?><br />
<strong>Статус: </strong> <? echo $status; ?><br />
<strong>Результат: </strong> <? echo $itog; ?><br />
</div>

<? 
}
echo $navigation -> navi(); 
} else {
?>
<div class="r1">Ставок нет</div>
<?
}
?>


