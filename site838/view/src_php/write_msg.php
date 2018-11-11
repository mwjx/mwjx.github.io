<?php
//------------------------------
//create time:2007-6-19
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:Ð´Õ¾ÄÚ¶ÌÐÅ
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
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
	exit("Ã»ÓÐµÇÂ¼£¬<a href=\"../login.php\">µÇÂ¼</a>");
$m_reveiver = isset($_GET["receiver"])?$_GET["receiver"]:"-1";
$man_receiver = new manbase_2($m_reveiver);

$xsl_path = "../include/xsl/write_msg.xsl";
$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
$str_xml = "<?xml version=\"1.0\"  encoding=\"gb2312\"?>\n";
$str_xml .= $str_xsl;
$str_xml .= "<listview>";
$str_xml .= "<sender><id>".$aman->get_id()."</id><name>".htmlspecialchars($aman->get_name())."</name></sender>\n";
$str_xml .= "<receiver><id>".$man_receiver->get_id()."</id><name>".htmlspecialchars($man_receiver->get_name())."</name></receiver>\n";
$str_xml .= "<title></title>\n";
$str_xml .= "<content></content>\n";
$str_xml .= "</listview>";
print_xml($str_xml);
?>