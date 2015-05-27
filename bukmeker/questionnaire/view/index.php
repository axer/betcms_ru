<? if ($formActive) { ?>
<div class="r1_golov">Ваша анкета</div>

<div class="r1">

<form action="" method="post">
Ваш WMR-кошелек:<br>
<input type="text" name="wmr" value="<? echo $wmr = ($data['webmoney']) ? $data['webmoney'] : 0; ?>" require><br>
Ваш QIWI-кошелек:<br>
<input type="text" name="qiwi" value="<? echo $qiwi = ($data['qiwi']) ? $data['qiwi'] : 0; ?>" require><br>
Ваша карта VISA:<br>
<input type="text" name="visa" value="<? echo $visa = ($data['visa']) ? $data['visa'] : 0; ?>" require><br>
<input type="submit" name="save" value="Сохранить"> 
</form>
<? } ?>

</div>