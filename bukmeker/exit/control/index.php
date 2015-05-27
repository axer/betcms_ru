<?
$formActive = true;
if (isset($_SESSION['userId'])) {
    
	if (isset($_GET['yes'])) { 
	$formActive = false;
    unset($_SESSION['userId']);
    unset($_SESSION['userAdmin']);
    session_destroy();
    
    show('Вы успешно вышли из системы!');
	?>
	<script>location.href = "/";</script>
	<?
	}
} else fatalError('Доступ закрыт! Авторизуйтесь!<br />
<a href="/login">Авторизация</a>');