<?
#проверим, активирован ли модуль
if (!active_module(dirname($_SERVER["SCRIPT_NAME"]))) fatalError('Модуль отключен');

#показ формы - вкл.
$formActive = true;

#запросим уже имеющиеся данные
$queryDataUser = $db -> query("SELECT * FROM users WHERE id = ?i", $_SESSION['userId']);
#обрабатываем данные
$data = $db -> fetch($queryDataUser);

if (isset($_POST['save'])) {

	#показ формы - выкл.
	$formActive = false;
	
	#принимаем и обрабатываем wmr-кошелек
	$wmr = XSS($_POST['wmr']);
	
	#принимаем и обрабатываем qiwi-кошелек
	$qiwi = XSS($_POST['qiwi']);
	
	#принимаем и обрабатываем карту VISA
	$visa = XSS($_POST['visa']);
	
	#если заполнен хотя бы 1 реквизит, то обновляем данные
	if ($wmr || $qiwi || $visa) {
	
		$updata = $db -> query("UPDATE users SET webmoney = ?s, qiwi = ?s, visa = ?i WHERE id = ?i", $wmr, $qiwi, $visa,  $_SESSION['userId']);
		
		if ($updata) show('Данные успешно сохранены');
		else
		errors('Ошибка сохранения');
	
	#если не заполнен ни один реквизит, то выдаем ошибку
	} else fatalError('Заполните хотя бы один реквизит!');
}