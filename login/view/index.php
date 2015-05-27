<? if (!isset($_POST['captcha'])) { ?>
<div class="r1_golov">Авторизация</div>
<div class="r1">

<form action="" method="post">

Логин:<br />
<input type="text" name="login" value="<? echo $log = (isset($_SESSION['login'])) ? $_SESSION['login'] : ''; ?>"><br />

Пароль:<br />
<input type="password" name="password"><br />

<img src="../captcha/captcha.php" width="170px" height="50px"><br />
Символы с картинки:<br />
<input type="text" name="captcha"><br>

<input type="submit" name="autOn" value="Войти">

</form>
<? } ?>
</div>