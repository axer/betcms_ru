<?
#проверим, активирован ли модуль
//if (!active_module(dirname($_SERVER["SCRIPT_NAME"]))) fatalError('Модуль отключен');

if (isset($_GET['section'])) {
    
    #принимаем ID-раздела
    $sectionId = clear($_GET['section']);
    
    if ($sectionId) {
        
        #время сейчас
        $timeNow = time();
        
        #выбираем все события, которые есть в этом разделе
        $queryEvent = $db -> query("SELECT * FROM events WHERE timestart > ?i AND old = 0 AND section = ?i ", $timeNow, $sectionId);
        
        #смотрим сколько их там
        $numEvent = $db -> numRows($queryEvent);
        
		#запускаем класс навигации
		$countViewEvents = 5;
		$navigation = new Navigator($numEvent, $countViewEvents, '', "?section=$sectionId"); 
        
		#выбираем повторно все события с учетом навигации, которые есть в этом разделе
        $queryEvent = $db -> query("SELECT * FROM events WHERE timestart > ?i AND old = 0 AND section = ?i ORDER BY id LIMIT {$navigation->start()},". $countViewEvents, $timeNow, $sectionId);
		
    } else fatalError('Такого раздела не существует!');
     
} else {
    fatalError('Вы не выбрали ни одного раздела!');
}