<?php
//------------------------------
//create time:2007-6-15
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:用户消息列表
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//my_safe_include("class_man.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/action_queue.php");
$m_obj = new c_action_queue;
$xsl_path = "../include/xsl/action_result.xsl";
$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
$str_xml = "<?xml version=\"1.0\"  encoding=\"gb2312\"?>\n";
$str_xml .= $str_xsl;
$str_xml .= "<listview>";
$str_xml .= "<action>".$m_obj->xml_list_guest()."</action>";
$str_xml .= "</listview>";
print_xml($str_xml);
?>