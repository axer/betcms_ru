<?php
class Navigator
{
function __construct($all,$pnumber,$query='', $add_adress = ''){
$this->all = $all;
$this->pnumber = $pnumber;
$this->query = $query;
$this->add_adress = $add_adress;

$this->p=isset($_GET['page']) ? (int)$_GET['page'] : 1;
if(isset($_POST['page'])){
$this->p=(int)$_POST['page'];}
}

function start()
{
$this->num_ps=ceil($this->all/$this->pnumber);
if (isset($_GET['last']))
$this->p=$this->num_ps;
$this->start=$this->p*$this->pnumber-$this->pnumber;
if ($this->p > $this->num_ps || $this->p < 1)
{
$this->p=1;
$this->start=0;
}
return $this->start;
}
function navi()
{		
if ($this->num_ps<2)
return '';
$buff='<div class="r1_golov">
Страницы:
</div>';

if($this->p>1){
$n=$this->p;
$n--;
//$buff.= '<span class="out"><a href="'.$_SERVER['PHP_SELF'].'?page='.$n.'&amp;'.$this->query.'"><<Назад</a></span>';
}

if(($this->p>1) && ($this->p != $this->num_ps)){$buff.= '  ';}

if($this->p != $this->num_ps){
$p=$this->p;
$p++;
//$buff.= '<span class="out"><a href="'.$_SERVER['PHP_SELF'].'?page='.$p.'&amp;'.$this->query.'" >Вперед>></a></span>';
}

$buff.='<div class="r1">';
for($pr = '', $i =1; $i <= $this->num_ps; $i++){
if (empty($this->add_adress)) {
$buff.= 
$pr=(($i == 1 || $i == $this->num_ps || abs($i-$this->p) < 2) ? ($i == $this->p ? " [".$i."]" : ' <a href="'.$_SERVER['SCRIPT_NAME'].'?page='.$i.'&amp;'.$this->query.'">'.$i.'</a>') : (($pr == ' .. ' || $pr == '')? '' : ' .. '));
} else {
$buff.= 
$pr=(($i == 1 || $i == $this->num_ps || abs($i-$this->p) < 2) ? ($i == $this->p ? " [".$i."]" : ' <a href="'.$_SERVER['SCRIPT_NAME'].$this->add_adress.'&page='.$i.'&amp;'.$this->query.'">'.$i.'</a>') : (($pr == ' .. ' || $pr == '')? '' : ' .. '));
}


}
$buff.= "</div>";
if($this->num_ps>5){
$buff.= '</div>
<div class="r1">
<form action="'.$_SERVER['PHP_SELF'].'?'.$this->query.'" method="get">
<input type="text" size="3" name="page" value="'.$this->p.'">
<INPUT type="submit" name="" value="Перейти">
</div>';}
return $buff.'</div>';
}
}
?>