<div class="r1_golov">Пополнение счета</div>

<div class="r1">
<form action="" method="post">

Система оплаты:<br />
<select name="type">
<? if (WMR) { ?> <option value="WebMoney">WebMoney</option> <? } ?>
<? if (QIWI) { ?><option value="QIWI">QIWI</option> <? } ?>
<? if (Visa) { ?><option value="Visa">Visa</option> <? } ?>
</select>

<br />
Введите сумму:<br />
<input type="text" name="amount" required><br />
<input type="submit" name="goAmount" value="Подтвердить">
</form>
</div>