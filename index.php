<?php
if (!file_exists('system/db.config.php')) {
?>
<script>
location.href = '/install/';
</script>
<a href="/install">Перейти к установке</a>
<?
}


#подключаем системные файлы
require_once 'system/system.config.php';

#подключаем БД
require_once 'system/db.config.php';

#указываем title-страницы
$title = 'BetCMS - Движок букмекерской конторы';

#подключаем "шапку"
require_once 'system/header.php';

#подключаем обработчик страницы
require_once 'index/control/index.php';

#подключаем html страницы
require_once 'index/view/index.php';

#подключаем "ноги"
require_once 'system/footer.php';

?>