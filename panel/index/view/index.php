<? 
if (!$_SESSION['userAdmin']) die('Доступ закрыт'); 
    else {
?>

<div class="r1_golov">Управление событиями</div>
<div class="r1">
<a href="add.event">Добавить событие вручную</a><br />
<a href="add.event?parser">Добавить события парсером</a><br />
<a href="edit.event">Изменить событие</a><br />
<a href="calculation">Расчитать событие [<? echo numEventCalc(); ?>]</a>
</div>

<div class="r1_golov">Управление разделами</div>
<div class="r1">
<a href="add.section">Добавить раздел</a><br />
<a href="edit.section">Изменить раздел</a>
</div>

<div class="r1_golov">Управление средствами</div>
<div class="r1">
<a href="input.means">Просят ввода средств [<? echo usersInput(); ?>]</a><br />
<a href="output.means">Просят вывода средств [<? echo usersOutput(); ?>]</a>
</div>


<div class="r1_golov">Системные настройки</div>
<div class="r1">
<a href="modules">Управление модулями</a><br>
<a href="settings">Настройки системы</a><br>
</div>

<? } ?>
