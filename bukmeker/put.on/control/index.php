<?
#по умолчанию устанавливаем показ формы в true - т.е. она будет отображаться
#когда запускается обработчик, выставляем $form в false, чтобы отключить показ формы
$form = true;

if (isset($_GET['event']) && isset($_GET['outcome'])) {
    
    #принимаем ID-события, на которое ставит пользователь 
    $idEvent = clear($_GET['event']);
    
    #сделаем проверочку на пустоту переменной
    $idEvent = ($idEvent) ? $idEvent : 0;
    
    #ID-пользователя
    $idUser = ID_USER;
    
    #делаем запрос в БД, чтобы узнать: не делал ли пользователь ставку на это событие
    $queryBet = $db -> query("SELECT * FROM betting WHERE idsob = ?i AND who = ?i", $idEvent, $idUser);
    
    #если запрос прошел
    if ($queryBet) {
        #считаем кол-во найденных ставок
        $dataBet = $db -> numRows($queryBet);
        #и если есть хотя бы 1, то выдаем ошибку
        if ($dataBet > 0) fatalError('Вы уже делали ставку на это событие!');
    }
    
	$timeNow = time();
	
    #делаем запрос в БД, чтобы узнать не старое ли это событие, которое уже завершилось
    $quetyOldEvent = $db -> query("SELECT * FROM events WHERE id = ?i", $idEvent);
    $dataOldEvent = $db -> fetch($quetyOldEvent);
    
    #проверяем не старое ли это событие
    if ($dataOldEvent['old'] || $dataOldEvent['timestart'] < $timeNow) fatalError('Это устаревшее событие! Не пытайтесь обмануть систему!');
    
    
    
    #принимаем выбор исхода (1, 2, или 3)
    $idOutCome = clear($_GET['outcome']);
    
    #т.к. исхода только 3 - победа 1, победа 2, ничья, то проверяем, не выбрано ли чего-то "четвертого"
    $idOutCome = ($idOutCome > 0 && $idOutCome <= 3) ? $idOutCome : false;
    
    #если выбранный исход существует, то...
    if ($idOutCome) {  
    
    #записываем ID-события в сессию, чтобы не передавать потом лишних данных
    $_SESSION['idEvent'] = $idEvent;    
    
    
    #выбираем из БД все, что известно про данное событие 
    $queryEvent = $db -> query("SELECT * FROM events WHERE id = ?i ", $idEvent);
    
    #обрабатываем запрос для дальнейшего использования
    $event = $db -> fetch($queryEvent);
    
    
    #проверяем и записываем, на кого поставил пользователь (1 - на первого соперника, 2 - на второго соперника, 3 - на ничью)
    if ($idOutCome == 1) { 
                            #название команды, на которую ставят
                            $outCome = $event['team1'];
                            
                            #запишем в сессию на кого поставили (1,2, или 3)
                            $_SESSION['outCome'] = 1;
                            
                            #записываем коэффициент в сессию
                            $_SESSION['bet'] = $event['factor1'];
                         }
                         
                         
                         
    if ($idOutCome == 2) {
                            #название команды, на которую ставят
                            $outCome = $event['team2'];
                            
                            #запишем в сессию на кого поставили (1,2, или 3)
                            $_SESSION['outCome'] = 2;
                            
                            #записываем коэффициент в сессию
                            $_SESSION['bet'] = $event['factor2'];
                         }
                         
                         
                           
    if ($idOutCome == 3) {  
                            #если ставят на ничью
                            $outCome = 'Ничья';
                            
                            #запишем в сессию на кого поставили (1,2, или 3)
                            $_SESSION['outCome'] = 3;
                            
                            #записываем коэффициент в сессию
                            $_SESSION['bet'] = $event['factor0'];
                         }
                            
    
    #запишем название противоборства (например, Спартак - Зенит)
    $teamWar = $event['team1']." - ".$event['team2'];
    
    
    } else errors('Такого исхода события не существует!');
}

if (isset($_POST['goBet']) && isset($_SESSION['idEvent']) && isset($_SESSION['bet'])) {
    $form = false;
    
   $amount = clear($_POST['amount']); 
   $balance = userBalance(ID_USER);
   
  
 if ($amount && ($balance >= $amount) && ($amount >= $settingsSystem['min_rate']) && ($amount <= $settingsSystem['max_rate'])) {
  
    
    #принимаем из сессии ID-события
    $idEvent = $_SESSION['idEvent'];
    
    #сразу же удаляем ID-события из сессии
    unset($_SESSION['idEvent']);
    
    
    #принимаем из сессии коэффициент
    $bet = $_SESSION['bet'];
    
    #сразу же удаляем коэффициент из сессии
    unset($_SESSION['bet']);
    
   #ID-пользователя
    $who = ID_USER;
    
    #время сейчас
    $timeNow = time();
    
    #вычисляем возможный выигрышь пользователя
    $howPostWin = $amount * $bet;
    
    #на кого поставили
    $outCome = $_SESSION['outCome'];
    #сразу же удаляем значение из сессии
    unset($_SESSION['outCome']);
    
    #добавляем в БД
    $insertBet = $db -> query("INSERT INTO betting (idsob, onwhom, who, how, howwin, time) VALUES (?i, ?i, ?i, ?s, ?s, ?i)", $idEvent, $outCome, $who, $amount, $howPostWin, $timeNow);
    
    #проведем проверку, записалось или нет
    if ($insertBet) {

	$updateBalance = $db -> query("UPDATE users SET balance = balance - ?i WHERE id = ?i", $amount, $who);
	
        show('Ставка принята!<br />
        Ваш максимальный выигрыш: '.$howPostWin.' руб.');
    } else {
        errors('Ошибка записи в БД');
    }
        
} else {
fatalError("Она могла возникнуть по следующим причинам:<br>- На вашем счету недостаточно средств.<br>- Сумма Вашей ставки менее ".$settingsSystem['min_rate']." руб., либо более ".$settingsSystem['max_rate']." руб.");
}
}