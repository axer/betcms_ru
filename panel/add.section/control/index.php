<?php

if (isset($_POST['section'])) {
    $section = XSS($_POST['section']);
    if (!empty($section)) {
        $addSection = $db -> query("INSERT INTO sections (title) VALUES (?s) ", $section);
        
        if ($addSection) show('Раздел успешно добавлен!<br /><a href="/panel/add.event">Добавить событие</a>');
            else
                errors('Ошибка создания раздела!<br /><a href="">Повторить</a>');
    }
}