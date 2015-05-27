<?
#проверим, активирован ли модуль
if (!active_module(dirname($_SERVER["SCRIPT_NAME"]))) fatalError('Модуль отключен');

#считаем кол-во сообщений в чате
$Msg = $db->query("SELECT * FROM mini_chat");
$countMsg = $db->NumRows($Msg);


//$num_msg = $db->query("SELECT * FROM settings");
//$num = $db->fetch($num_msg);

#устанавливаем кол-во выводимых собщений на странице
$countViewMsg = (clear($settingsSystem['num_msg_chat'])) ? clear($settingsSystem['num_msg_chat']) : 10;

#запускаем класс навигации
$navigation = new Navigator($countMsg, $countViewMsg,''); 

#выбираем что выводить первоначально
$viewMsg = $db->query("SELECT * FROM `mini_chat` ORDER BY id DESC LIMIT {$navigation->start()},".$countViewMsg); 



###################################################################################################################


#проверяем не отправлено ли сообщение
if (isset($_POST['msg']) && isset($_POST['msgGo']) && $_POST['msg'] && (!$settingsSystem['chat_close'] || is_admin($_SESSION['userId']))) {

#принимаем и чистим сообщение
$msg = XSS($_POST['msg']);

if ($msg) {

#записываем время отправки
$times = time();

#записываем сообщение в базу
$newMsg = $db->query("INSERT INTO mini_chat (who, msg, times) VALUES (?i, ?s, ?i)", $_SESSION['userId'], $msg, $times);

if ($newMsg) {
?>
<script>
location.href='/bukmeker/chat/index.php';
</script>
<?
} else errors('Ошибка отправки сообщения. Попробуйте снова.');

} else errors('Сообщение не может быть пустым!'); 

}


#######################################################################################################################

#сохранение настроек чата
if (isset($_POST['save_settings_chat']) && isset($_POST['num_msg']) && is_admin($_SESSION['userId'])) {

#проверим значение
$num = (clear($_POST['num_msg'])) ? clear($_POST['num_msg']) : 10;

#запишем в базу
$query = $db->query("UPDATE settings SET num_msg_chat = ?i", $num);

if ($query) {
show('Настройки чата сохранены');
?>
<script>
location.href = "/bukmeker/chat/";
</script>
<?
}
else
	errors('Ошибка сохранения настроек чата. Повторите снова');
}


########################################################################################################################

#очистка чата
if (isset($_GET['clear']) && is_admin($_SESSION['userId'])) {

if (isset($_GET['yes'])) {
#удаляем сообщения из чата
$delete = $db->query("TRUNCATE TABLE `mini_chat`");

if ($delete) show('Чат очищен!');
?>
<script>
location.href = "../chat/";
</script>
<?
} else {
?>
<div class="r1_golov">Подвтерждение действия</div>
<div class="r1">
Вы действительно хотите очистить чат?<br><br>
<a href="?clear&yes"><button>Да</button></a>  <a href="../chat/"><button>Нет</button></a>
</div>
<?
		}
}

############################################################################################################################

#закрытие чата
if (isset($_GET['close']) && is_admin($_SESSION['userId'])) {

$close = $db->query("UPDATE settings SET chat_close = ?i", 1);

if ($close) {
show('Чат закрыт');
?>
<script>
location.href = "../chat/";
</script>
<?
} else {
errors('Ошибка закрытия чата');
}

}


#открытие чата
if (isset($_GET['open']) && is_admin($_SESSION['userId'])) {

$close = $db->query("UPDATE settings SET chat_close = ?i", 0);

if ($close) {
show('Чат открыт');
?>
<script>
location.href = "../chat/";
</script>
<?
} else {
errors('Ошибка открытия чата');
}

}



########################################################################################################

#удаление сообщениия

if (isset($_GET['delete']) && isset($_GET['id']) && !empty($_GET['id']) && is_admin($_SESSION['userId'])) {


$id = (clear($_GET['id'])) ? clear($_GET['id']) : 0;

if (!isset($_GET['yes'])) {

if ($id) {
?>
<div class="r1_golov">Подтверждение действия</div>
<div class="r1">
Вы действительно хотите удалить сообщение с номером <?=$id?>?<br><br>
<a href="?delete&id=<?=$id?>&yes"><button>Да</button></a>  <a href="../chat/"><button>Нет</button></a>
</div>

<?
}
} else {

$deleteMsg = $db->query("DELETE FROM mini_chat WHERE id = ?i", $id);

if ($deleteMsg) {
show('Сообщение удалено');
?>
<script>
location.href = "../chat/";
</script>
<?
} else errors("Ошибка удаления. Повторите снова");

}

}