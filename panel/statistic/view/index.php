<? if ($idEvent && $true) { ?>
<div class="r1_golov">Статистика события</div>
<div class="r1">
<b>Событие:</b> <?=$sob['team1']?> - <?=$sob['team2']?><br>
<b>Время начала:</b> <?=date('d-m-Y H:i', $sob['timestart'])?><br>
<b>Поставило на П1:</b> <?=$numP1?> чел.<br>
<b>Поставило на П2:</b> <?=$numP2?> чел.<br>
<b>Поставило на ничью:</b> <?=$numX?> чел.<br>
<b>Всего ставок на событие:</b> <?=$allNum?><br>
<b>Статус:</b> 

<? if (!$sob['old']) echo 'В игре<br>'; 
else {
echo 'Завершен<br>';
?>
<b>Победитель:</b> <?=$winner?><br>
<b>Заработали на ставке:</b> <?=$summaWin?> руб.<br>
<b>Проиграли на ставке:</b> <?=$summaLose?> руб.<br>
<b><? if ($itog > 0) echo "Прибыль: </b> ".$itog;
else echo "Убыток:</b> ".$itog; ?> руб.<br>
<?
} 
?>
</div>
<? } else { 

errors("События не существует");

 } 