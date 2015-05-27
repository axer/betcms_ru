<?php
#выбираем все модули
$selectModules = $db->query("SELECT * FROM modules ORDER BY id");


#включение модуля
if (isset($_GET['enable']) && !empty($_GET['enable'])) {

$idModule = clear($_GET['enable']);

if ($idModule) {

$update = $db->query("UPDATE modules SET active = 1 WHERE id = ?i", $idModule);

if ($update) {
?>
<script>
location.href = "/panel/modules/";
</script>
<?
} else {
errors("Ошибка включения модуля. Попробуйте снова.");
}

} else {
errors("Не указан ID-модуля.");
}

}



#отключение модуля
if (isset($_GET['disable']) && !empty($_GET['disable'])) {

$idModule = clear($_GET['disable']);

if ($idModule) {

$update = $db->query("UPDATE modules SET active = 0 WHERE id = ?i", $idModule);

if ($update) {
?>
<script>
location.href = "/panel/modules/";
</script>
<?
} else {
errors("Ошибка отключения модуля. Попробуйте снова.");
}

} else {
errors("Не указан ID-модуля.");
}

}




#меняем позицию - вверх
if (isset($_GET['up']) && !empty($_GET['up'])) {

$idModule = clear($_GET['up']);

if ($idModule) {

$selectUp0 = $db->query("SELECT * FROM modules WHERE id = ?i", $idModule - 1);

if ($db->numRows($selectUp0)) {

$selectUp1 = $db->query("UPDATE modules SET id = -1 WHERE id = ?i", $idModule-1);
$insertUp = $db->query("UPDATE modules SET id = ?i WHERE id = ?i", $idModule-1, $idModule);
$selectUp2 = $db->query("UPDATE modules SET id = ?i WHERE id = -1", $idModule);


if ($selectUp1 && $selectUp2 && $insertUp) {
?>
<script>
location.href = "/panel/modules/";
</script>
<?
} else { errors("Ошибка изменения позиции."); }
							}
			}
}



#меняем позицию - вниз
if (isset($_GET['down']) && !empty($_GET['down'])) {

$idModule = clear($_GET['down']);

if ($idModule) {

$selectDown0 = $db->query("SELECT * FROM modules WHERE id = ?i", $idModule + 1);

if ($db->numRows($selectDown0)) {
$selectDown1 = $db->query("UPDATE modules SET id = -1 WHERE id = ?i", $idModule+1);
$insertDown = $db->query("UPDATE modules SET id = ?i WHERE id = ?i", $idModule+1, $idModule);
$selectDown2 = $db->query("UPDATE modules SET id = ?i WHERE id = -1", $idModule);


if ($selectDown1 && $selectDown2 && $insertDown) {
?>
<script>
location.href = "/panel/modules/";
</script>
<?
} else {
errors("Ошибка изменения позиции.");
}

}

}
}


#редактирование названия и пути
if (isset($_POST['saveModule']) && isset($_GET['idmod']) && !empty($_GET['idmod'])) {

$link = XSS($_POST['link']);
$name = XSS($_POST['name']);
$id = clear($_GET['idmod']);

if ($name && $link && $id) {

$updateMod = $db->query("UPDATE modules SET name = ?s, link = ?s WHERE id = ?i", $name, $link, $id);

if ($updateMod) {
?>
<script>
location.href = "/panel/modules/";
</script>
<?
} else {
errors('Ошибка сохранения данных модуля. Попробуйте снова.');
}
}
}



########################################################################################

#изменение иконки
if (isset($_FILES['file']) && !empty($_FILES['file']['name'])  && is_uploaded_file($_FILES['file']['tmp_name']) && isset($_POST['saveIcon']) && isset($_GET['editicon']) && !empty($_GET['editicon'])) {

$idEditIcon = clear($_GET['editicon']);

if ($idEditIcon) {
	require_once 'upload.img.php';
}

}