<?
if ($numOut > 0) {
?>

<div class="r1_golov">Просят вывода</div>

<?
while ($dataOut = $db -> fetch($queryOut)) {
$info = $db->query("SELECT * FROM users WHERE id = ?i", $dataOut['who']);
$user = $db->fetch($info);

if ($dataOut['type'] == "QIWI") $rekvisit = $user['qiwi'];
elseif ($dataOut['type'] == "WebMoney") $rekvisit = $user['webmoney'];
else $rekvisit = $user['visa'];

?>
<div class="r1">
<strong>Пользователь:</strong> <? echo userLogin($dataOut['who']); ?><br>
<strong>Просит вывести:</strong> <? echo $dataOut['how']; ?> руб. <br>
<strong>Платежка:</strong> <? echo $dataOut['type']; ?> <br>
<strong>Номер счета:</strong> <? echo $rekvisit; ?> <br>
<strong>Дата:</strong> <? echo date('d-m-Y H:i', $dataOut['time']); ?> <br>
<a href="?confirm&id=<? echo $dataOut['id']; ?>">[Подтвердить вывод]</a> <br>
<a href="?return&id=<? echo $dataOut['id']; ?>">[Вернуть деньги на личный счет]</a>
</div>





<?
 }  
} else show('Нет запросов на вывод средств');
?>