<?php
//------------------------------
//create time:2007-5-24
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:星级文章列表
//------------------------------
if("小鱼" != $_COOKIE['username']){
	$html = "由于资源限制，本功能暂时关闭。";	
	exit($html);
}
//-------------新版-------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/starpage.php");
//my_safe_include("class_c2e.php");
//var_dump($arr_tear);
//输出文本
//页面样式
//var_dump($data);
$obj = new c_starpage;
echo $obj->get_html();
exit();
//-----------end 新版-----------

?>