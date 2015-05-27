<?
#если события есть, то выводим их
if ($numEvents) {
   
   if (!isset($_GET['edit']) && !isset($_GET['delete'])) {
?>
<div class="r1_golov">Изменение события</div>
<div class="r1">В этом разделе вы можете изменить уже существующее событие, посмотреть его статистику, либо удалить это событие.</div>
<?  
    
    while($event = $db -> fetch($allEvents)) {
?>
<div class="r1_golov"><? echo $event['team1'], ' - ', $event['team2']; ?></div>
<div class="r1">
Начало: <? echo date('d-m-Y H:i', $event['timestart']), '<br>'; ?>
Коэфф.: 
<? echo 'П.1 - ', $event['factor1'], '; Н.X - ', $event['factor0'], '; П.2 - ', $event['factor2']; ?>
<br />
[<a href="../statistic/?id=<?=$event['id']?>">Статистика</a> ] [<a href="?edit&id=<? echo $event['id']; ?>">Изменить</a> ] [<a href="?delete&id=<? echo $event['id']; ?>">Удалить</a> ]
</div>
<?        }
echo $navigation -> navi();
    }
} else {
    echo 'Нет ни одного события';
}