<?php
//------------------------------
//create time:2007-9-26
//creater:zll
//purpose:发布者档案
//------------------------------
exit(js_empty());
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //用户ID
$m_name = (isset($_GET["name"])?$_GET["name"]:""); //用户名
//$m_name = "小鱼"; //tests
if(-1 == $m_id && "" == $m_name)
	exit(js_empty());
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/user_cash.php");
//my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/my_mwjx.php");

$o_man = NULL;
if($m_id > 0)
	$o_man = new manbase_2($m_id);
else
	$o_man = new manbase_2($m_name);
if($o_man->get_id() < 1) //用户无效
	exit(js_empty());
//我的文章数
$obj_my = new c_my_mwjx;
$arr_count = $obj_my->article_count($m_name);
//已登陆
$obj_cash = new c_user_cash($o_man->get_id());
//---------现金信息--------
$arr = ($obj_cash->cash_info());
//$cash = 0;
$cash = $arr["settled"]+$arr["unsettled"];

$m_js = "";
$m_js .= "document.write('<DIV class=seller style=\"TEXT-ALIGN: left\"><H3>发布者档案</H3><img src=\"/mwjx/images/newface/1.bmp\"/><P><LABEL>用户名：</LABEL><A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\">".$o_man->get_name()."</A></P><P><LABEL>妙文币：</LABEL> <A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\" target=_blank>".$o_man->get_money()."</A> </P><P><LABEL>人民币：</LABEL> <A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\" target=_blank>".$cash."</A> </P><P><LABEL>星级文章：</LABEL> <span class=\"normal-red\">".$arr_count["star"]."</span> </P><P><LABEL>精华文章：</LABEL> ".$arr_count["good"]." </P><P><LABEL>文章总数：</LABEL> ".$arr_count["all"]." </P><P><LABEL>文章浏览：</LABEL> ".number_format($arr_count["allpv"],0,".",",")." </P><P><LABEL>注册时间：</LABEL>".$o_man->get_reg()."</P><P class=more><A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\">查看该用户的个人图书馆</A></P><P class=more><A href=\"/mwjx/src_php/write_msg.php?receiver=".$o_man->get_id()."\">给该用户发站内短信</A></P></DIV>');\n";
//$m_js .= "</script>";
//var_dump($m_js);
echo $m_js;
exit();

function js_empty()
{
	//未登录输出
	return "document.write('<DIV class=seller style=\"TEXT-ALIGN: left\"><H3>发布者档案</H3><img src=\"/mwjx/images/newface/1.bmp\"/><P><LABEL>用户名：</LABEL><A href=\"#\">&nbsp;</A></P><P><LABEL>妙文币：</LABEL><A href=\"#\">&nbsp;</A> </P><P><LABEL>人民币：</LABEL><A href=\"#\">&nbsp;</A></P><P><LABEL>星级文章：</LABEL> 0 </P><P><LABEL>精华文章：</LABEL> 0 </P><P><LABEL>文章总数：</LABEL> 0 </P><P><LABEL>文章浏览：</LABEL> 0 </P><P><LABEL>注册时间：</LABEL>-</P><P class=more><A href=\"#\">查看该用户的个人图书馆</A></P><P class=more><A href=\"#\">给该用户发站内短信</A></P></DIV>');\n";
}
?>