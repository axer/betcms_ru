<?php

// ������ ������ ��������, ������������ � �����
$capletters = 'ABCDEFGKIJKLMNOPQRSTUVWXYZ123456789'; 
// ����� ����� 7 ������
$captlen = 5; 

// ������������� ������� �����������
$capwidth = 210; $capheight = 64; 

// ���������� �����
$capfont = 'Highspeed_2.ttf'; 

 // ������ ������ ������
$capfontsize = 23;

// �������������� HTTP ���������, ����� ������� ������ 
// ������� ����������� ����� �� �����, � �����������
header('Content-type: image/png'); 

// ����������� ����������� � ���������� ����� ���������
$capim = imagecreatetruecolor($capwidth, $capheight); 

// ������������� ������������� ���������� ����� ������ (������������)
imagesavealpha($capim, true); 

// ������������� ���� ����, � ����� ������ - ����������
$capbg = imagecolorallocatealpha($capim, 0, 0, 0, 127);

// ������������� ���� ���� �����������
imagefill($capim, 0, 0, $capbg); 

// ������ ��������� �������� �����
$capcha = '';

// ��������� ���� ���������� �����������
for ($i = 0; $i < $captlen; $i++){

// �� ������ ������ ����� ���������� ������ � ��������� � �����
$capcha .= $capletters[rand(0, strlen($capletters)-1) ]; 

// ���������� ��������� ������� �� X ���
$x = ($capwidth - 20) / $captlen * $i + 10;

// ������� ������������ � ��� ���������.
$x = rand($x, $x+5); 

// ������� ��������� �� Y ���
$y = $capheight - ( ($capheight - $capfontsize) / 2 ); 

// ������ ��������� ���� ��� �������.
$capcolor = imagecolorallocate($capim, rand(0, 100), rand(0, 100), rand(0, 100) ); 

// ������ ��� �������
$capangle = rand(-35, 35); 

// ������ ��������� ������, �������� ��� ��������� ���������
imagettftext($capim, $capfontsize, $capangle, $x, $y, $capcolor, $capfont, $capcha[$i]);

} // ��������� ����

// ������� ����������, ���� ����� ��������� �����, 
// � ��� ����� ������������ ��������� ������������� �����
session_start();

$_SESSION['captcha'] = strtolower($capcha);

imagepng($capim); // ������� ��������.

imagedestroy($capim); // ������� ������.

?> 