<?php
//------------------------------
//create time:2007-10-17
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:������ʷ
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/cny_history.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);
//$m_id = 200200067; //tests
$obj = new c_cny_history($m_id);
//--------����------------------------
echo ($obj->get_html());
?>