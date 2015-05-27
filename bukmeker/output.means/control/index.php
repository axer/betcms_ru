<?

/*
File: bukmeker/output.means/control/index.php
Файл отвечает за обработку запросов на вывод средств
*/



#проверим, активирован ли модуль
if (!active_module(dirname($_SERVER["SCRIPT_NAME"]))) fatalError('Модуль отключен');

#обрабатываем запрос на пополнение счета
if (isset($_POST['goAmount'])) {
    
    #для начала проверим, заполнены ли у пользователя реквизиты (т.е. кошельки WebMoney или QIWI)
    checkDetails($_SESSION['userId']);
    
    #теперь проверим есть ли у него столько средств в системе
    $userBalance = userBalance($_SESSION['userId']);
       
    #записываем сколько хочет вывести пользователь
    $amount = clear($_POST['amount']);
    
    #сверяем
    if ($userBalance < $amount) fatalError('У вас недостаточно средств!');
    
    
    #если значение не равно пустоте
    if ($amount && ($amount >= $settingsSystem['min_out']) && ($amount <= $settingsSystem['max_out']) ) {
        
        #для удобства, указываем, кто просит вывода средств
        $who = $_SESSION['userId'];
        
        #записываем через какую систему будет производится оплата
        $type = XSS($_POST['type']);
        
        #проверяем есть ли такая система
        $type = (($type == 'QIWI') || ($type == 'WebMoney') || ($type == 'Visa')) ? $type : false;
        
        #если такой тип платежной системы существует, то
        if ($type) {
            
        #в зависимости от типа платежной системы, выбираем соответствующий ей системный кошелек
        if ($type == 'QIWI') $purse = QIWI;
		elseif ($type == 'WebMoney') $purse = WMR;
		else $purse = Visa;
        
        #запишем время добавления запроса на вывод
        $timeNow = time();
        
        #записываем все в БД
        $insertInput = $db -> query("INSERT INTO output_means (who, how, type, time) VALUES (?i, ?i, ?s, ?i)" , $who, $amount, $type, $timeNow);
        
        #списываем эту сумму со счета пользователя
        $updateBalance = $db -> query("UPDATE users SET balance = balance - ?i WHERE id = ?i ", $amount, $_SESSION['userId']);
        
        #проверяем записалось ли
        if ($insertInput) show('Ваш запрос на выплату принят! Перевод осуществляется в течение суток.');
        else
            errors('Ошибка в выполнении запроса.');
        }
    } else errors('Сумма на разовый вывод должна быть не менее '.$settingsSystem['min_out'].' руб. и не должна превышать '.$settingsSystem['max_out'].' руб.');
    
}