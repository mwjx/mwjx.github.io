<?php
//------------------------------
//create time:2007-10-17
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ֽ����
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/cnypage.php");

$obj = new c_cnypage;
//--------����------------------------
echo ($obj->get_html());

?>