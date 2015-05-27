<?php

#выбираем все события из БД
$allEvents = $db -> query("SELECT * FROM events");
$numEvents = $db -> numRows($allEvents);

#запускаем класс навигации
$countViewEvents = 10;
$navigation = new Navigator($numEvents, $countViewEvents,''); 

$allEvents = $db -> query("SELECT * FROM events ORDER BY timestart DESC LIMIT {$navigation->start()},".$countViewEvents);

#удаление события
if (isset($_GET['delete']) && isset($_GET['id'])) {
    
    #принимаем id-события
    $id = clear($_GET['id']);
    
    #удаляем запись из БД
    $delEvent = $db -> query("UPDATE events SET old = 1 WHERE id = '?i' ", $id);
    
    #информируем админа
    if ($delEvent) show('Событие успешно удалено!');
    else
        errors('Ошибка удаления');
    
}


#изменение события
if (isset($_GET['edit']) && isset($_GET['id'])) {
    
    #принимаем id-события
    $id = clear($_GET['id']);
    
    #выбираем данные к этой записи
    $editEvent = $db -> query("SELECT * FROM events WHERE id = '?i' ", $id);
    
    #смотрим, есть ли такая запись в базе
    $numEvent = $db -> numRows($editEvent);
    
    #если нет, выдаем ошибку
    if (!$numEvent) errors('Такого события не существует!');
    
    #если существует, то...
    else {
        $edEvent = $db -> fetch($editEvent);
        $date = getdate( $edEvent['timestart'] );
?>      
        <div class="r1_golov">Изменение события</div>
        <div class="r1">
        <form action="/panel/add.event/?edit=<? echo $edEvent['id']; ?>" method="post">
        Категория:<br/>
        <select name="sections">
<?      
        #считываем названия разделов из БД
        $querySections = $db -> query("SELECT * FROM sections");
        while($section = $db -> fetch($querySections)) { 
?>
        <option value="<? echo $section['id']; ?>"> <? echo $section['title']; ?></option>
<?
    } 
?>
        </select><br/>
        Хозяева:<br/><input type="text" name="team1" value="<? echo $edEvent['team1']; ?>"/><br/>
        Гости:<br/><input type="text" name="team2" value="<? echo $edEvent['team2']; ?>"/><br/>
        
        Коэффициенты <br />
        <small>(используйте точку для разделения целого числа от десятичного. <br />Например, коэффициент - 1.8): </small>
        <br/>
        П.1 - <input type="text" size="3" name="factor1" value="<? echo $edEvent['factor1']; ?>"/> 
        Н.X - <input type="text" size="3" name="factor0" value="<? echo $edEvent['factor0']; ?>"/> 
        П.2 - <input type="text" size="3" name="factor2" value="<? echo $edEvent['factor2']; ?>"/><br/>

        Дата начала:<br/>
        <input type="text" size="2" name="day" value="<? echo $date['mday']; ?>"/>/
        <input type="text" size="2" name="month" value="<? echo $date['mon']; ?>"/>/
        <input type="text" size="4" name="year" value="<? echo $date['year']; ?>"/><br/>
        
        Время начала:<br>
        Часы: <input type="text" size="2" name="hours" value="<? echo $hour = ($date['hours'] == 0) ? '00' : $date['hours'];  ?>"/> <br />
        Минуты: <input type="text" size="2" name="minute" value="<? echo $min = ($date['minutes'] == 0) ? '00' : $date['minutes']; ?>"/><br/>
        <input type="submit" name="editEvent" value="Сохранить изменения"/>
        </form>
        </div>
        <?
    }
    
}