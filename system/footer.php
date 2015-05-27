<? 
#если пользователь авторизован, выводи панельку
if (isset($_SESSION['userId'])) {
?>
<div class="r1_golov" style="text-align: center;">
[<a href="<? echo URL; ?>bukmeker/">Кабинет</a>]
<? 
#если пользователь является администратором, то выводим ссылку на панель управления
if (isset($_SESSION['userAdmin']) && $_SESSION['userAdmin']) {
?>
[<a href="<? echo URL; ?>panel/">Панель управления</a>]
<?  
}
?>
</div>
<? } else { ?>
<div class="r1_golov" style="text-align: center;">
[<a href="<? echo URL; ?>/faq/">FAQ</a>]
[<a href="<? echo URL; ?>/reg/">Регистрация</a>]
[<a href="<? echo URL; ?>/login/">Авторизация</a>]
</div>
<? } ?>

<div class="foot">
Всего пользователей: <? echo numUsers(); ?> <br/>
Всего денег в системе: <? echo allMoney(); ?> руб.<br>
© <a href="http://betcms.ru">Powered BetCMS</a>
</div>
</body>
</html>