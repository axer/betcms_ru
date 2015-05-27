<?
#если события есть, то выводим их
if ($numSections) {
   
   if (!isset($_GET['edit']) && !isset($_GET['delete'])) {
?>
<div class="r1_golov">Редактирование разделов</div>
<div class="r1">Здесь вы можете изменить название раздела или вовсе удалить его.</div>
<?  
    
    while($section = $db -> fetch($allSections)) {

?>
<div class="r1_golov"><?=$section['title']; ?></div>
<div class="r1">
 [<a href="?edit&id=<?=$section['id']; ?>">Изменить</a>] [<a href="?delete&id=<?=$section['id']; ?>">Удалить</a>]
</div>
<?        }
    }
} else {
    echo 'Нет ни одного раздела';
}