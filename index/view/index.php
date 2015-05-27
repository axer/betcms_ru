<div class="r1_golov">Меню</div>
<div class="r1">

<?
if (isset($_SESSION['userAdmin']) && $_SESSION['userAdmin']) {
?>
<a href="/panel">Панель управления</a><br />
<?
}
if (!isset($_SESSION['userId'])) { 
?>
<a href="reg">Регистрация</a><br />
<a href="login">Авторизация</a><br />
<? } else { ?>
<script>location.href = "/bukmeker/";</script>
<? } ?>
<!--<a href="news">Новости</a><br>-->
<a href="faq">FAQ</a><br>
</div>