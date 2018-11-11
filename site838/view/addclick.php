<?php
//------------------------------
//create time:2007-7-30
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:ндуб╪фйЩ
//------------------------------
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);
if($m_id < 1)
	exit();
require("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$str_sql = "update article set click=click+1 where id='".$m_id."';";
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
?>