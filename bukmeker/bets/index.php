<?php

#подключаем БД
require_once '../../system/db.config.php';

#подключаем системные файлы
require_once '../../system/system.config.php';

#закрываем доступ всем не авторизованным
require_once '../close.php';

#указываем title-страницы
$title = 'Мои ставки';

#подключаем "шапку"
require_once '../../system/header.php';

#подключаем обработчик страницы
require_once 'control/index.php';

#подключаем html страницы
require_once 'view/index.php';

#подключаем "ноги"
require_once '../../system/footer.php';

?>