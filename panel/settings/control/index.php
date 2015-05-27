<?php
#сохранение настроек
if (isset($_POST['save'])) {

foreach($_POST as $key=>$value){
$_POST[$key] = XSS($_POST[$key]);
}

#различные настройки
$bonus_reg = $_POST['bonus_reg'];

#системные счета
$admin_qiwi     = $_POST['admin_qiwi'];
$admin_webmoney = $_POST['admin_webmoney'];
$admin_visa     = $_POST['admin_visa'];

#минимальная/максимальная сумма на вывод
$min_out	    = $_POST['min_out'];
$max_out 		= $_POST['max_out'];

#минимальная/максимальная сумма на ввод
$min_in 		= $_POST['min_in'];
$max_in 		= $_POST['max_in'];

#минимальная/максимальная сумма ставки
$max_rate 		= $_POST['max_rate'];
$min_rate 		= $_POST['min_rate'];

#размер иконки в КВ/ширина/высота
$icon_size      = $_POST['icon_size'] * 1024;
$icon_width     = $_POST['icon_width'];
$icon_height    = $_POST['icon_height'];

if ($admin_webmoney || $admin_qiwi || $admin_visa) {

$update = $db->query("UPDATE settings SET admin_webmoney = ?s,
										  admin_qiwi = ?s,
										  admin_visa = ?s,
										  min_out = ?i,
										  max_out = ?i,
										  min_in = ?i,
										  max_in = ?i,
										  icon_size = ?i,
										  icon_height = ?i,
										  icon_width = ?i,
										  max_rate = ?i,
										  min_rate = ?i,
										  bonus_reg = ?i",
$admin_webmoney, $admin_qiwi, $admin_visa, $min_out, $max_out, $min_in, $max_in, $icon_size, $icon_height, $icon_width, $max_rate, $min_rate, $bonus_reg);

if ($update) {
?>
<script>
location.href = "/panel/settings/";
</script>
<?
} else errors("Ошибка сохранения данных. Попробуйте снова.");
} else errors('Настройки не могут быть сохранены. Укажите хотя бы 1 реквизит.');
}