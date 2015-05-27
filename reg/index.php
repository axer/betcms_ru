<?php

#подключаем системные файлы
require_once '../system/system.config.php';

#подключаем БД
require_once '../system/db.config.php';

#указываем title-страницы
$title = 'Регистрация';

#подключаем "шапку"
require_once '../system/header.php';

#подключаем обработчик страницы
require_once 'control/index.php';

#подключаем html страницы
require_once 'view/index.php';

#подключаем "ноги"
require_once '../system/footer.php';