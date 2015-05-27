<?
if ($numCalculation > 0) {

while($event = $db -> fetch($queryCalculation)) {
?>
<div class="r1">
<form action="?id=<? echo $event['id']; ?>" method="post">
Матч: <? echo $event['team1'], ' - ', $event['team2'], '<br>'; ?>
Начало: <? echo date('d-m-Y H:i', $event['timestart']), '<br>'; ?>
Коэфф.: 
<? echo 'П.1 - ', $event['factor1'], '; Н.X - ', $event['factor0'], '; П.2 - ', $event['factor2']; ?>
<br />
<select name="winner">
<option value="1">Победа 1</option>
<option value="2">Победа 2</option>
<option value="3">Ничья</option>
</select>
<input type="submit" name="calculate" value="Расчитать">
</div>
</form>
<?   
}     
} else {
    show('Нет ни одного события для расчета!');
}