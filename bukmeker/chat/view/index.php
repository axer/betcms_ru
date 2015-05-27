<? 
if (is_admin($_SESSION['userId'])) {

$num = (clear($settingsSystem['num_msg_chat'])) ? clear($settingsSystem['num_msg_chat']) : 0; 
$close = (clear($settingsSystem['chat_close'])) ? clear($settingsSystem['chat_close']) : 0;
?>
<div class="r1_golov" onclick='settings_chat();'>Настройки чата</div>
<div class="r1" id="open_sett" onclick='settings_chat();'>Нажмите, чтобы открыть настройки</div>
<div class="r1" id="close_sett" onclick='settings_chat();' style="display:none;">Нажмите, чтобы скрыть настройки</div>
<div class="r1" id="settings_chat" style="display:none;">
<form action="" method="post">
Сообщений на странице:<br>
<input type="text" name="num_msg" value="<?=$num?>"><br>
<input type="submit" name="save_settings_chat" value="Сохранить"><br>
<a href="?clear">Очистить чат</a><br>
<? if ($close) echo '<a href="?open">Открыть чат</a>'; else echo '<a href="?close">Закрыть чат</a>'; ?>
</div>
<?
} 
?>

<div class="r1_golov">Мини-чат</div>
<div class="r1">
<? if (!$settingsSystem['chat_close'] || is_admin($_SESSION['userId'])) { ?>

<form action="" method="post">
<textarea name="msg"></textarea><br>
<input type="submit" name="msgGo" value="Написать">
</form>
<? } else { ?>
Чат закрыт.
<? } ?>
</div>
<?
if ($countMsg) {
while ($printMsg = $db->fetch($viewMsg)) {
?>
<div class="r1_golov"><?=$printMsg['id']?>. <b><?=userLogin($printMsg['who'])?></b> [<?=date('d.m.Y H:i', $printMsg['times'])?>] 
<? if (is_admin($_SESSION['userId'])) {?><a href="?delete&id=<?=$printMsg['id']?>">[Удалить]</a><? } ?></div>
<div class="r1">
<?=nl2br($printMsg['msg'])?>
</div>
<?
}
echo $navigation -> navi();
} else {
?>
<div class="r1">
Сообщений нет
</div>
<?
}