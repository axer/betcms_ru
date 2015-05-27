<?php

#считываем названия разделов из БД
$querySections = $db -> query("SELECT * FROM sections");
$numSections = $db -> numRows($querySections);

#парсер событий
if (isset($_GET['parser']) && isset($_POST['grabGo']) && !empty($_POST['link'])) {

#подключаем парсер
if (isset($_POST['name_parser']) && !empty($_POST['name_parser'])) {
$parser = XSS($_POST['name_parser']) ? XSS($_POST['name_parser']) : false;
if ($parser) {
	//echo $parser;
		if (file_exists('control/parser/'.$parser.'.php'))
			include "control/parser/".$parser.".php";
		else
			errors('Такого парсера не существует!');
}			
			}
}
	



if (isset($_POST['addEvent']) || isset($_POST['editEvent'])) {
    
        #очищаем данные
        foreach($_POST as $key=>$value){
            $_POST[$key] = XSS($value);
        }
        
        #обрабатываем данные связанные с датой и временем события        
    	$day = (!empty($_POST['day']) && ($_POST['day'] > 0) && ($_POST['day'] <= 31)) ? (int)$_POST['day'] : false;
		$month = (!empty($_POST['month']) && ($_POST['month'] > 0) && ($_POST['month'] <= 12)) ? (int)$_POST['month'] : false;
		$year = (!empty($_POST['year']) && ($_POST['year'] >= date("Y"))) ? (int)$_POST['year'] : false;
		$hour = (!empty($_POST['hours']) && ($_POST['hours'] >= 0) && ($_POST['hours'] <= 23)) ? (int)$_POST['hours'] : false;
		$min = (!empty($_POST['minute']) && ($_POST['minute'] >= 0) && ($_POST['minute'] <= 59)) ? (int)$_POST['minute'] : false;
        
        #приводим введенную дату к нужному виду
        $date = $year.'-';
		$date .= $month.'-';
		$date .= $day.' ';
		$date .= $hour.':';
		$date .= $min.':';
		$date .= '0';
        
        #преобразуем введенную дату и время в UNIX
        $timeStart = strtotime($date);
        
		#заменим запятую в коэффициенте (если есть) на точку
        $_POST['factor1'] = str_replace(",", ".", $_POST['factor1']);
        $_POST['factor0'] = str_replace(",", ".", $_POST['factor0']);
        $_POST['factor2'] = str_replace(",", ".", $_POST['factor2']);
		
        #обрабатываем коэффициенты
        $factor1 = (!empty($_POST['factor1']) && ($_POST['factor1'] > 0)) ? $_POST['factor1'] : false;
        $factor0 = (!empty($_POST['factor0']) && ($_POST['factor0'] > 0)) ? $_POST['factor0'] : false;
        $factor2 = (!empty($_POST['factor2']) && ($_POST['factor2'] > 0)) ? $_POST['factor2'] : false;
        
        #обрабатываем названия соперников
        $team1 = (!empty($_POST['team1'])) ? $_POST['team1'] : false;
        $team2 = (!empty($_POST['team2'])) ? $_POST['team2'] : false;
        
        #обрабатываем название раздела
        $section = $_POST['sections'];
        
        #если ошибок при вводе не было, то добавляем событие в БД
        if ($timeStart && $factor0 && $factor1 && $factor2 && $team1 && $team2 && $section) {
            
            #если это добавление, а не редактирование
            if (isset($_POST['addEvent']) && !isset($_GET['edit'])) {    
                
            #записываем событие в БД   
            $addEvent = $db -> query("INSERT INTO events (section, team1, team2, timestart, factor0, factor1, factor2, result, old) VALUES (?i, ?s, ?s, ?s, ?s, ?s, ?i, '-1', '0')", $section, $team1, $team2, $timeStart, $factor0, $factor1, $factor2);
            
            #информируем админа о успехе/провале записи в БД
            if ($addEvent) {
			show('Событие успешно добавлено!');
			?>
            <script>location.href = "/panel";</script>
			<?
			}
			else
                errors('Ошибка записи события в БД.');
            }
            
            #если это редактирование, а не добавление записи
            if (isset($_GET['edit'])) {
                
                #принимаем и очищаем id-события
                $id = clear($_GET['edit']);
                
                #обновляем данные
                $updateEvent = $db -> query("UPDATE events SET section = ?i,
                                                                team1 = ?s,
                                                                team2 = ?s,
                                                                timestart = ?i,
                                                                factor0 = ?s,
                                                                factor1 = ?s,
                                                                factor2 = ?s WHERE id = ?i", $section, $team1, $team2, $timeStart, $factor0, $factor1, $factor2, $id);
                                                                
                #проверяем прошел ли запрос
                if ($updateEvent) {
				show('Данные события успешно изменены!');
                ?>
            <script>location.href = "/panel/edit.event/";</script>
			<?
				}
				else
                    errors('Ошибка обновления данных!');
                                                                
            }
            
            
        } else {
            errors('Заполните корректно все поля!<br /><a href="">Повторить</a>');
        }
        
} 
?>

