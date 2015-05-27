<? 
#проверяем показывать форму или нет.
if ($form && ((isset($_GET['event']) && isset($_GET['outcome'])) || isset($amount)))  { 
?>
<div class="r1_golov">Новая ставка</div>
<div class="r1">
<form action="/bukmeker/put.on/" method="post">
Вы ставите на [<? echo $outCome; ?>] в событии [<? echo $teamWar; ?>]. <br />
Для завершения введите сумму ставки:<br />
<input type="text" name="amount" required><br />
<input type="submit" name="goBet" value="Поставить">
</form>
<? } else {
	errors('Не выбрано событие');
} ?>
</div>