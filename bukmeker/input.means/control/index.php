<?

/*
File: bukmeker/input.means/control/index.php
Файл отвечает за обработку запросов на пополнение счета
*/

#проверим, активирован ли модуль
if (!active_module(dirname($_SERVER["SCRIPT_NAME"]))) fatalError('Модуль отключен');

#обрабатываем запрос на пополнение счета
if (isset($_POST['goAmount'])) {
    
    #записываем сколько хочет ввести пользователь
    $amount = clear($_POST['amount']);
    
    
    #если значение не равно пустоте
    if ($amount && ($amount >= $settingsSystem['min_in']) && ($amount <= $settingsSystem['max_in']) ) {
        
        #для удобства, указываем, кто просит ввода средств
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
        
        #запишем время добавления запроса на ввод
        $timeNow = time();
        
        #записываем все в БД
        $insertInput = $db -> query("INSERT INTO input_means (who, how, type, time) VALUES (?i, ?i, ?s, ?i)" , $who, $amount, $type, $timeNow);
        
        #проверяем записалось ли
        if ($insertInput) show('Переведите <b>'.$amount.'</b> руб. на кошелек платежной системы '.$type.'<br />
        <b>Номер кошелька</b>: <b style="color: #f00;">'.$purse.'</b><br>
		В комментарии к переводу укажите свой логин в системе.');
        else
            errors('Ошибка в выполнении запроса.');
        }
    } else errors('Сумма на ввод должна быть не менее '.$settingsSystem['min_in'].' руб. и не должна превышать '.$settingsSystem['max_in'].' руб.');
    
}