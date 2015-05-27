<?php

#выбираем все матчи, которые уже прошли.
$timeNow = time();
$queryCalculation = $db -> query("SELECT * FROM events WHERE timestart < $timeNow AND old = 0");
$numCalculation = $db -> numRows($queryCalculation);

if (isset($_POST['calculate'])) {
    
    #ID-события, которое расчитываем
    $idEvent = clear($_GET['id']);
    
    #обрабатываем данные
    $_POST['winner'] = clear($_POST['winner']);
    
    #запоминаем победителя (возможно и ничья)
    $winner = (!empty($_POST['winner'])) ? $_POST['winner'] : false;
    
    if ($winner) {
        
        #обновим данные в таблице events
        $update = $db -> query("UPDATE events SET result = ?i, old = 1 WHERE id = ?i", $winner, $idEvent);
        
        #выбираем всех, кто поставил на это событие и оказался победителем
        $querySelectBet = $db -> query("SELECT * FROM betting WHERE idsob = ?i AND onwhom = ?i", $idEvent, $winner);
        
        #посчитаем, сколько победителей
        $numBetWin = $db -> numRows($querySelectBet);
        
        
        #если победители есть, то начисляем им деньги
        if ($numBetWin > 0) {
        
        #заведем переменную, которая будет хранить кол-во выплаченных денег победителям по данной ставке
        $amountWin = 0;
        
        #перебирая всех победителей, начисляем им на баланс
        while ($winBet = $db -> fetch($querySelectBet)) {
            
            
            #запоминаем сколько выиграл пользователь
            $how = $winBet['howwin'];
            
            #увеличиваем кол-во выплаченных денег
            $amountWin += $how;
            
            #запоминаем id победителя
            $who = $winBet['who'];
            
            #обновляем баланс
            $updateBalance = $db -> query("UPDATE users SET balance = balance + ?s WHERE id = ?i", $how, $who);
            
        }
        
            #показываем что все успешно расчиталось и выводим сумму всех выигрышей
            show('Ставка успешно расчитана!<br />Сумма выплат составила: '.$amountWin.' руб.');
			?>
			<script type="text/javascript">
  setTimeout('location.replace("/panel/calculation/")', 3000);
			</script>
			<?
        
        } else {
		
		errors('Победителей нет.');
		?>
       	<script type="text/javascript">
  setTimeout('location.replace("/panel/calculation/")', 3000);
			</script>
			<?
	   } 
        
        
    }
    
}