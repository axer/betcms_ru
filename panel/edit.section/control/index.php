<?php

#выбираем все события из БД
$allSections = $db -> query("SELECT * FROM sections");
$numSections = $db -> numRows($allSections);


#удаление события
if (isset($_GET['delete']) && isset($_GET['id'])) {
    
    #принимаем id-события
    $id = clear($_GET['id']);
    
    #удаляем запись из БД
    $delEvent = $db -> query("DELETE FROM sections WHERE id = '?i' ", $id);
    
    #информируем админа
    if ($delEvent) show('Раздел успешно удален!');
    else
        errors('Ошибка удаления');
    
}


#изменение события
if (isset($_GET['edit']) && isset($_GET['id'])) {
    
    #принимаем id-события
    $id = clear($_GET['id']);
    
    #выбираем данные к этой записи
    $editSections = $db -> query("SELECT * FROM sections WHERE id = '?i' ", $id);
    
    #смотрим, есть ли такая запись в базе
    $numSections = $db -> numRows($editSections);
    
    #если нет, выдаем ошибку
    if (!$numSections) errors('Такого раздела не существует!');
    
    #если существует, то...
    else {
        $edSections = $db -> fetch($editSections);
?>      
        <div class="r1_golov">Изменение раздела</div>
        <div class="r1">
        <form action="/panel/edit.section/?update=<? echo $edSections['id']; ?>" method="post">
        Раздел<br/>
        <input type="text" name="section" value="<? echo $edSections['title']; ?>">

        <input type="submit" name="editEvent" value="Сохранить изменения"/>
        </form>
        </div>
        <?
    }
    
}


if (isset($_GET['update'])) {

$id = (clear($_GET['update'])) ? clear($_GET['update']) : false;
$newTitle = (XSS($_POST['section'])) ? XSS($_POST['section']) : false;

if ($id && $newTitle) {

$update = $db -> query("UPDATE sections SET title = ?s WHERE id = ?i", $newTitle, $id);

if ($update) show('Раздел успешно переименован!');
else
errors('Ошибка изменения раздела!');

}


}