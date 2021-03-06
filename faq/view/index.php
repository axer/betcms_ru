<?
if (isset($_GET['mode'])){
$mode = XSS($_GET['mode']);

switch($mode):

case('stavka'):
echo page('Как сделать ставку?','Для того, чтобы сделать ставку, вам нужно авторизоваться под своим логином в системе '.NameSait.'. Имея положительный баланс на своем
счету, вы можете сделать ставку на любой матч представленный в системе.<br>
Выбрав интересующее вас событие, выберите команду на которую хотите сделать ставку (либо на ничью), а затем следуйте подсказкам на экране.');
break;

case('vvod'):
echo page('Как пополнить баланс?','Авторизуйтесь в системе '.NameSait.', перейдите в раздел "Ввод средств", следуйте подсказкам на экране.');
break;

case('vivod'):
echo page('Как обналичить счет?','Авторизуйтесь в системе '.NameSait.', перейдите в раздел "Вывод средств", следуйте подсказкам на экране.');
break;

case('tikets'):
echo page('Тикеты','Если у вас возникли какие-либо вопросы и они не были озвучены в разделе "Помощь", вы можете задать их администрации сайта, воспользовавшись
тикет-системой.<br>
Для того, чтобы задать вопрос администрации, авторизуйтесь в системе и выберите пункт "Тикеты", дальше следуйте подсказкам на экране.');
break;

case('rules'):
echo page('Правила','
<b><u>Общие положения:</u></b><br>
1. Букмекерская контора '.NameSait.', принимает ставки на спортивные события в соответствии с данными Правилами.<br>
2. Ставки на события и зачисления на счет принимаются у лиц, достигших 18 лет. Ответственность за нарушение данного пункта несет пользователь.<br>
3. Ставки принимаются у лиц, ознакомившихся и согласных с данными Правилами. Размещение ставки означает согласие с Правилами.<br>
<br><b><u>Учетная запись:</u></b><br>
1. Для того, чтобы начать делать ставки, пользователь должен зарегистрировать учетную запись в системе '.NameSait.'. <br>
Каждому пользователю присваивается персональный игровой логин. <br>
При открытии счета необходимо указывать реальные данные. Несоблюдение этого условия может послужить причиной отказа в выплате.<br>
2. '.NameSait.' гарантирует неразглашение данных клиента сотрудниками '.NameSait.'.<br>
3. '.NameSait.' сохраняет за собой право проверить достоверность информации, предоставленной клиентом. По запросу пользователь должен предоставить копию любого документа, идентифицирующего его личность (должны быть видны фотография, имя, фамилия, адрес, подпись). <br>
Если в случае проверки выяснилось, что пользователь предоставил '.NameSait.' заведомо неверную информацию, '.NameSait.' сохраняет за собой право прекратить прием ставок у этого пользователя.<br>
4. Пользователь лично отвечает за сохранность деталей своей учетной записи, в частности, логина и пароля.<br>
5. Регистрируя учетную запись, пользователь должен подтвердить, что он достиг совершеннолетнего возраста. Ответственность за нарушение данного пункта несет ПОЛЬЗОВАТЕЛЬ.<br>
6. '.NameSait.' оставляет за собой право отказать в приеме ставок любому лицу без объяснения причин. В этом случае игровой счет закрывается, а средства на счету подлежат выплате на банковский счет, открытый на имя игрока.<br>
7. Мы не являемся системой обмена денежных средств. Поэтому перед запросом вывода денежных средств, Вы обязаны сделать ставку, как минимум на 50% вводимых средств. В противном случае в выплате может быть отказано!<br>
8. Регистрация одним и тем же пользователем нескольких аккаунтов ЗАПРЕЩЕНО, в случае выявления данного факта Мы имеем право отказать Вам в выплатах.<br>
<br>
<b><u>Расчет матчей:</u></b><br>
1. Расчет ставок осуществляется в течение 24 часов.<br>
2. Сумма выигрыша зачисляется на учетную запись победителей во время расчета.<br>
3. Выигрыш рассчитывается по правилу: Коэффициент x Сумма ставки = Выигрыш.<br>
4. Если матч не состоялся, был прерван и не доигран в течение 30 часов, все ставки на него подлежат возврату.<br>
');
break;

default:
echo page('Ошибка','Данного раздела не существует');
break;

endswitch;
echo '
<div class="r1"><a href="/faq/">Помощь</a></div>';
}
else {echo page('Помощь','
<a href="?mode=stavka">Как сделать ставку?</a><br>
<a href="?mode=vvod">Как пополнить баланс?</a><br>
<a href="?mode=vivod">Как обналичить счет?</a><br>
<!--<a href="?mode=tikets">Тикеты</a><br>-->
<a href="?mode=rules">Правила</a><br>
');
echo'
<div class="r1"><a href="/bukmeker">В кабинет</a></div>';
}