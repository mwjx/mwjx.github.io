<?php
//------------------------------
//create time:2007-6-15
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:用户消息列表
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/action_queue.php");
my_safe_include("mwjx/msg_dealer.php");
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
$aman = new manbase_2($currentuser,$currentpass);
if($aman->get_id() < 1)
	exit("没有登录，<a href=\"../login.php\">登录</a>");
$m_obj = new c_action_queue;
$m_obj_msg = new c_msg_dealer;
$xsl_path = "../include/xsl/msglist.xsl";
//$xsl_path = "/site838/view/include/xsl/msglist.xsl";
$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
$str_xml = "<?xml version=\"1.0\"  encoding=\"gb2312\"?>\n";
$str_xml .= $str_xsl;
$str_xml .= "<listview>";
$str_xml .= "<action>".$m_obj->xml_list($aman->get_id())."</action>";
$str_xml .= "<msg_receive>".$m_obj_msg->xml_list($aman->get_id(),"A")."</msg_receive>";
$str_xml .= "<msg_send>".$m_obj_msg->xml_list($aman->get_id(),"A",2)."</msg_send>";
$str_xml .= "</listview>";
//设置所有站内消息为已读
$m_obj_msg->set_had($aman->get_id(),"Y");
print_xml($str_xml);
?>