<?
/*
File: panel/add.event/view/index.php
Файл отвечает за отображение на странице элементов управления:
- списков
- полей для ввода информации
- кнопок и т.д.
*/

if (isset($_GET['parser'])) {
?>

<div class="r1_golov">Парсить события</div>
<div class="r1">
<form action="?parser" method="post">
Выбери парсер:<br/>
<select name="name_parser">
<option value="football">Футбол</option>
</select><br>
Категория чемпионата:<br/>
<select name="sections">
<?
while($section = $db -> fetch($querySections)) { 
?>
<option value="<? echo $section['id']; ?>"> <? echo $section['title']; ?></option>
<?
    }
?>
</select><br>
Ссылка:<br>
<input type="text" name="link"><br>
<input type="submit" name="grabGo" value="Парсить">
</form>
</div>
<?	
} else {
?>
 

<div class="r1_golov">Новое событие</div>

<?
#если есть категории
if ($numSections > 0) { 
?>
<div class="r1">
<a href="?parser">Добавить через парсер</a>
<form action="" method="post">

Категория:<br/>
<select name="sections">
<?
while($section = $db -> fetch($querySections)) { 
?>
<option value="<? echo $section['id']; ?>"> <? echo $section['title']; ?></option>
<?
    } 
?>
</select><br/>
Хозяева:<br/><input type="text" name="team1"/><br/>
Гости:<br/><input type="text" name="team2"/><br/>

Коэффициенты <br />
<small>(Например, коэффициент - 1.8):
</small>
<br/>
П.1 - <input type="text" size="3" name="factor1"/> 
Н.X - <input type="text" size="3" name="factor0"/> 
П.2 - <input type="text" size="3" name="factor2"/><br/>

Дата начала:<br/>
<input type="text" size="2" name="day"/>/
<input type="text" size="2" name="month"/>/
<input type="text" size="4" name="year" value="<? echo date("Y"); ?>"/><br/>
Время начала:<br>
Часы: <input type="text" size="2" name="hours"/> <br />
Минуты: <input type="text" size="2" name="minute"/><br/>
<input type="submit" name="addEvent" value="Добавить матч"/>
</form>
<? 
#если нет ни одной категории - просим создать
} else {
errors('Нет ни одного раздела!<br /> <a href="/panel/add.section">Создать раздел</a>');    
}
}
?>
</div>