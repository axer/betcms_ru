<?
if (isset($_GET['edit']) && !empty($_GET['edit'])) {

$idModule = clear($_GET['edit']);

if ($idModule) {

$editModule = $db->query("SELECT * FROM modules WHERE id = ?i", $idModule);
$module = $db->fetch($editModule);
?>
<div class="r1_golov">Редактирование модуля</div>
<div class="r1">
<form action="?idmod=<?=$idModule?>" method="post">
Название модуля (выводится на главной):<br>
<input type="text" name="name" value="<?=$module['name']?>"><br>
Путь к модулю (без необходимости не менять!):<br>
<input type="text" name="link" value="<?=$module['link']?>"><br>
<input type="submit" name="saveModule" value="Сохранить">
</form>
</div>

<? } 
} elseif(isset($_GET['editicon']) && !empty($_GET['editicon'])) {
$idModule = clear($_GET['editicon']);

if ($idModule ) {

$select = $db->query("SELECT * FROM modules WHERE id = ?i", $idModule);
$param = $db->fetch($select);

?>
<div class="r1_golov">Редактирование иконки модуля</div>
<div class="r1">
<form action="?editicon=<?=$idModule?>" method="post" enctype="multipart/form-data">
<b>Модуль:</b> <?=$param['name']?><br>
<b>Иконка сейчас:</b> <img width="15px" height="15px" src="../../style/default/imgs/<?=$param['icon']?>"><br>
<b>Выбрать другую:</b><br>
(Разрешенный размер иконки <?=$settingsSystem['icon_size']/1024?> KB, шириной - <?=$settingsSystem['icon_width']?> px. и высотой - <?=$settingsSystem['icon_height']?> px.)<br>
<input type="file" name="file" /><br />
<input type="submit" name="saveIcon" value="Сохранить">
</form>
</div>
<?
		}
} else {
?>
<div class="r1_golov">Установленные модули</div>
<div class="r1">Здесь вы можете включать/отключать модули, а также редактировать их.</div>
<? while ($view_module = $db->fetch($selectModules)) { ?>

<div class="r1_golov">
<form action="" method="post">
<?=$view_module['name']?>
</div>

<div class="r1">
<b>Иконка:</b> <img width="15px" height="15px" src="../../style/default/imgs/<?=$view_module['icon']?>"> <br>
<a href="?editicon=<?=$view_module['id']?>">[Изменить иконку]</a><br>
<b>Расположение:</b> <br><a href="?up=<?=$view_module['id']?>">[Разместить выше]</a><br>
<a href="?down=<?=$view_module['id']?>">[Разместить ниже]</a><br>
<b>Параметры: </b> <br><? if ($view_module['active']) { ?> <a href="?disable=<?=$view_module['id']?>">[Отключить модуль]</a><br>
<? } else  {?> <a href="?enable=<?=$view_module['id']?>">[Включить]</a><br> <? } ?>
<a href="?edit=<?=$view_module['id']?>">[Редактировать]</a>
</form>
</div>
<? 
} 
}
?>