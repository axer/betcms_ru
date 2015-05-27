<?php

#подключаем системные файлы
require_once '../system/system.config.php';

#подключаем БД
require_once '../system/db.config.php';

#указываем title-страницы
$title = 'Вас приветствует установщик модулей!';

#подключаем "шапку"
require_once '../system/header.php';

?>
<div class="r1_golov">Вас приветствует установщик модулей!</div>
<div class="r1">
Скопируйте все файлы модуля в папку install_mod и перейдите по адресу:<br>
ваш_сайт/install_mod/install_название модуля.php
</div>

<?

#подключаем "ноги"
require_once '../system/footer.php';