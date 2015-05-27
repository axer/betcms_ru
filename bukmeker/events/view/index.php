<?

if ($numEvent > 0) {
    
#выбираем из базы название "раздела", в котором находится событие
   $querySection = $db -> query("SELECT * FROM sections WHERE id = ?i ", $sectionId);
   $dataSection = $db -> fetch($querySection);
 ?>
 
<div class="r1_golov"><? echo $dataSection['title']; ?></div>
<div class="r1">Все матчи в этом разделе</div>
<?
while ($event = $db -> fetch($queryEvent)) {
    
?>   
<div class="r1_golov">
<? echo $event['team1'], ' - ', $event['team2']; ?>
</div>

<div class="r1">
Начало: <? echo date('d-m-Y H:i', $event['timestart']), '<br>'; ?>
Коэфф.: 
<? echo '
<a href="/bukmeker/put.on/?event='.$event['id'].'&outcome=1">[П.1 - ', $event['factor1'], ']</a> 
<a href="/bukmeker/put.on/?event='.$event['id'].'&outcome=3">[Н.X - ', $event['factor0'], ']</a>
<a href="/bukmeker/put.on/?event='.$event['id'].'&outcome=2">[П.2 - ', $event['factor2'], ']</a>'; 
?>
<? if (isset($_SESSION['userAdmin']) && $_SESSION['userAdmin']) { ?>
<br>
<a href="../../panel/statistic/index.php?id=<?=$event['id']?>">[Статистика события]</a>
<? } ?>
</div>
<?   
}
echo $navigation -> navi(); 
} else {
    errors('В данном разделе нет ни одного события!');
}