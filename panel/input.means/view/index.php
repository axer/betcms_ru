<?
if ($numIn > 0) {
?>

<div class="r1_golov">Просят ввода</div>

<?
while ($dataIn = $db -> fetch($queryIn)) {
?>
<div class="r1">
<strong>Пользователь:</strong> <? echo userLogin($dataIn['who']); ?><br>
<strong>Перевел:</strong> <? echo $dataIn['how']; ?> руб. <br>
<strong>Платежка:</strong> <? echo $dataIn['type']; ?> <br>
<strong>Комментарий к переводу:</strong> <? echo userLogin($dataIn['who']); ?><br>
<strong>Дата:</strong> <? echo date('d-m-Y H:i', $dataIn['time']); ?> <br>
<a href="?confirm&id=<? echo $dataIn['id']; ?>">[Пользователь перевел деньги]</a><br>
<a href="?delete&id=<? echo $dataIn['id']; ?>">[Пользователь не перевел деньги]</a>
</div>





<?
 }  
} else show('Нет запросов на ввод средств');
?>