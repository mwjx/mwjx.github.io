<?php
//------------------------------
//create time:2007-10-17
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:津贴历史
//------------------------------
if("小鱼" != $_COOKIE['username']){
	$html = "由于资源限制，本功能暂时关闭。";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/cny_history.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);
//$m_id = 200200067; //tests
$obj = new c_cny_history($m_id);
//--------代码------------------------
echo ($obj->get_html());
?>