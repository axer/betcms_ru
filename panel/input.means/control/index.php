<?

#смотрим есть ли те, которые просят подтвердить ввод.
$queryIn = $db -> query("SELECT * FROM input_means WHERE confirm = 0");

#посчитаем их кол-во
$numIn = $db -> numRows($queryIn);


#подтверждение перевода
if (isset($_GET['confirm']) && isset($_GET['id'])) {

#принимаем и "чистим от каки" id-запроса
$id = clear($_GET['id']);

if ($id) { 
	
	$queryIn = $db -> query("SELECT * FROM input_means WHERE id = ?i", $id);
	$dataIn = $db -> fetch($queryIn);
	
	#смотрим сколько нужно начислить
	$plus = $dataIn['how'];
	#смотрим кому нужно начислить
	$whom = $dataIn['who'];
	
	#начисляем пользователю средства
	$updateBalance = $db -> query("UPDATE users SET balance = balance + ?s WHERE id = ?i", $plus, $whom);
	
	#устанавливаем на запись метку confirm(подтвержденная)
	$updateIn = $db -> query("UPDATE input_means SET confirm = 1 WHERE id = ?i", $id);
	
	if ($updateBalance) {
	 show('Успешное подтверждение!');
	 ?>
	 <script>location.href = "/panel/input.means/";</script>
	<?
	}
	else
	errors('Ошибка начисления на счет!');
	
} else fatalError('Такого запроса на ввод средств не существует!');

}

#если нажали "не перевел" удаляем запись из БД
 elseif (isset($_GET['delete']) && isset($_GET['id'])) {
	$id = clear($_GET['id']);
		
	if (isset($_GET['ok'])) {
		
		$query = $db -> query("DELETE FROM input_means WHERE id = ?i", $id);
		
		if ($query) {
		show('Успешное удаление');
		?>
		 <script>location.href = "/panel/input.means/";</script>
		<?
		}
		else
		errors('Ошибка удаления');
} else {

	errors('Вы точно хотите удалить запись?<br>
		<a href="?delete&id='.$id.'&ok">ДА</a>
		<a href="/panel/input.means">НЕТ</a>');
}	
	

}

