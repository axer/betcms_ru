<? if (!isset($_POST['captcha'])) { ?>
<div class="r1_golov">Регистрация</div>
<div class="r1">

<form action="" method="post">

Логин:<br />
<input type="text" name="login" value="<? echo $log = (isset($_SESSION['login'])) ? $_SESSION['login'] : ''; ?>" required><br />

E-mail:<br />
<input type="email" name="email" value="<? echo $em = (isset($_SESSION['email'])) ? $_SESSION['email'] : ''; ?>"  required><br />

Пароль:<br />
<input type="password" name="pas1"  required><br />

Пароль еще раз:<br />
<input type="password" name="pas2"  required><br />


<img src="../captcha/captcha.php" width="170px" height="50px"><br />
Символы с картинки:<br />
<input type="text" name="captcha"  required><br>

<input type="submit" name="regOn" value="Регистрация">

</form>
<? } ?>
</div>