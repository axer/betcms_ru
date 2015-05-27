<?
error_reporting(0);
function grab($url, $unique_start, $unique_end) {
$code = file_get_contents($url);
//preg_match('/'.preg_quote($unique_start,'/').'(.*)'.preg_quote($unique_end, '/').'/Us', $code, $match);
$code = explode('<div class="hot_live_bet">', $code);
$codeOne = $code[1];
$codeOne = explode('<div id="info_content" class="widget_ajax_area" style="display: none;"></div>', $codeOne);  
//var_dump($codeOne[0]);
return $codeOne[0];
}

function mbStringToArray($string, $encoding = 'UTF-8') 
{ 
$strlen = mb_strlen($string); 
while ($strlen) { 
$array[] = mb_substr($string, 0, 1, $encoding); 
$string = mb_substr($string, 1, $strlen, $encoding); 
$strlen = mb_strlen($string, $encoding); 
} 
return ($array); 
}

$url = XSS($_POST['link']);
$section = clear($_POST['sections']);

$unique_start = '<div class="hot_live_bet">';
$unique_end = '<div id="info_content" class="widget_ajax_area" style="display: none;"></div>';



$d = grab($url, $unique_start, $unique_end); 


$d = str_replace('<div class="hot_table_bet">', '<div class="hot_table_bet">#', $d);
$d = str_replace(' | ', '[TIMEGAME]', $d);
$d = str_replace('<span class="gname hotGameTitle"', '[NAMEGAME]<span class="gname hotGameTitle"', $d);
$d = str_replace('<span title="', '[/TIMEGAME]<span title="', $d);
$d = str_replace('data-type="1"', 'data-type="1">[P1]', $d);
$d = str_replace('data-type="2"', 'data-type="2">[/P1][X]', $d);
$d = str_replace('data-type="3"', 'data-type="3">[/X][P2]', $d);
$d = str_replace('data-type="4"', 'data-type="4">[/P2][/ENDBETS]', $d);
$d = str_replace('<span class="date" style="display: none;"><span>', '[/NAMEGAME] [DATEGAME]', $d);
$d = str_replace('</span></span>', '[/DATEGAME]', $d);

$d = strip_tags($d);
//var_dump($d);

$mas = mbStringToArray($d);

$mas2[] = '';
$i = 0;

foreach ($mas as $k) {
global $i;

	if (!empty($k) || ($k==' ') || $k == 0) $mas2[$i] = $k;
	
	$i++;
}

$all = '';

foreach ($mas2 as $k) {
	$all = $all.$k;
}



#переменная под коэффициенты
$koefP1[] = '';
$koefP2[] = '';
$koefX[] = '';


#переменная для названия команды
$teamName1[] = '';
$teamName2[] = '';

#переменная для хранения времени
$timeStart[] = '';

#счетчик
$j = 0;

$all = explode("[/ENDBETS]", $all);

foreach ($all as $a) {
global $j;


$name_game = explode("[NAMEGAME]", $a);
$end_name_game = explode("[/NAMEGAME]", $name_game[1]);
$teams = explode(" - ", $end_name_game[0]);

#первая команда
$team1 = $teams[0];
#вторая команда
$team2 = $teams[1];

$date = explode("[/DATEGAME]", $end_name_game[1]);
$date[0] = str_replace("[DATEGAME]", "", $date[0]);

#дата [день.месяц.год]
$date_game = $date[0];

$time = explode("[TIMEGAME]", $date[1]);
$time = explode("[/TIMEGAME]", $time[1]);


#время матча
$time_game = $time[0];

$koef = explode("[P1]", $time[1]);
$dkoef = explode("[/P1]", $koef[1]);

#коэффициент П1
$koef_p1 = $dkoef[0];
$koef_p1 = explode('>', $koef_p1);
//echo '<hr>'.$koef_p1 = $koef_p1[1];
$koef_p1 = $koef_p1[1];

$dkoef = explode("[P2]", $dkoef[1]);
$dkoef[0] = str_replace("[X]", "", $dkoef[0]);
$dkoef[0] = str_replace("[/X]", "", $dkoef[0]);

#коэффициент X
$koef_x = $dkoef[0];
$koef_x = explode('>', $koef_x);
//$koef_x = $koef_x[1];
$koef_x = $koef_x[1];

#коэффициент П2
$dkoef[1] = str_replace("[/P2]", "", $dkoef[1]);
$koef_p2 = $dkoef[1];
$koef_p2 = explode('>', $koef_p2);
//echo '<hr>'.$koef_p2 = $koef_p2[1];
$koef_p2 = $koef_p2[1];


#удалим лишние пробелы
#команды
$team1 = trim($team1);
$team2 = trim($team2);

#дата (день, месяц, год)
$date_game = trim($date_game);

#время матча (час, минута)
$time_game = trim($time_game);

#коэффициенты
$koef_p1 = trim($koef_p1);
$koef_x = trim($koef_x);
$koef_p2 = trim($koef_p2);

#приведем дату в нужный формат день, месяц, год
$date_game = explode(".", $date_game);

$correct_time = explode(':', $time_game);

#здесь задаем часовой пояс(+3)
$time_hour = $correct_time[0] + 3;
$time_min  = $correct_time[1];

echo $number_day = cal_days_in_month(CAL_GREGORIAN, $date_game[1], $date_game[0]);

#date_game[2] - год
#date_game[1] - месяц
#date_game[0] - день

#если перевалило на другие сутки, увеличиваем день
if ($time_hour >= 24)
{
	$time_raz = $time_hour - 24;
	$time_hour = '0'.$time_raz;
		
	$date_game[0]++;
	
	#если дней стало больше, чем дней в месяце, увеличиваем цифру месяца
	if ($date_game[0]>$number_day)
	{
		$date_game[0] = '01';
		$date_game[1]++;
	}
	
	#если месяцев больше, чем 12 увеличиваем год
	if ($date_game[1]>12)
	{
		$date_game[1] = '01';
		$date_game[2]++;
	}
	
}

$time_game = $time_hour.':'.$time_min;


#приводим введенную дату к нужному виду
    $date = $date_game[2].'-';
	$date .= $date_game[1].'-';
	$date .= $date_game[0].' ';
	$date .= $time_game.':';
	$date .= '0';

		#переменная для названия команды
		$teamName1[$j] = $team1;
		$teamName2[$j] = $team2;
        #преобразуем введенную дату и время в UNIX
        $timeStart[$j] = strtotime($date);
		
		#переменная под коэффициенты
		$koefP1[$j] = $koef_p1*1;
		$koefX[$j] = $koef_x*1;
		$koefP2[$j] = $koef_p2*1;
		
		$j++;

}


$err = false;
for ($i = 0; $i <= $j; $i++) {

//echo $section, $teamName1[$i], $teamName2[$i], $timeStart[$i], $koefX[$i], $koefP1[$i], $koefP2[$i].'<br>';

	if ($teamName1[$i] && $teamName2[$i] && $timeStart[$i] && $koefX[$i] && $koefP1[$i] && $koefP2[$i]) {
            global $err;
			#записываем событие в БД   
            $addEvent = $db -> query("INSERT INTO events (section, team1, team2, timestart, factor0, factor1, factor2, result, old) VALUES (?i, ?s, ?s, ?s, ?s, ?s, ?s, '-1', '0')", $section, $teamName1[$i], $teamName2[$i], $timeStart[$i], $koefX[$i], $koefP1[$i], $koefP2[$i]);
            
            #информируем админа о успехе/провале записи в БД
            if ($addEvent) {
			?>
            <script>location.href = "/panel";</script>
			<?
			}
			else  $err = true;
		}
	
 }
 
 if ($err == false) show('События добавлены!');
