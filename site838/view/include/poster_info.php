<?php
//------------------------------
//create time:2007-9-26
//creater:zll
//purpose:�����ߵ���
//------------------------------
exit(js_empty());
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //�û�ID
$m_name = (isset($_GET["name"])?$_GET["name"]:""); //�û���
//$m_name = "С��"; //tests
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
if($o_man->get_id() < 1) //�û���Ч
	exit(js_empty());
//�ҵ�������
$obj_my = new c_my_mwjx;
$arr_count = $obj_my->article_count($m_name);
//�ѵ�½
$obj_cash = new c_user_cash($o_man->get_id());
//---------�ֽ���Ϣ--------
$arr = ($obj_cash->cash_info());
//$cash = 0;
$cash = $arr["settled"]+$arr["unsettled"];

$m_js = "";
$m_js .= "document.write('<DIV class=seller style=\"TEXT-ALIGN: left\"><H3>�����ߵ���</H3><img src=\"/mwjx/images/newface/1.bmp\"/><P><LABEL>�û�����</LABEL><A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\">".$o_man->get_name()."</A></P><P><LABEL>���ıң�</LABEL> <A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\" target=_blank>".$o_man->get_money()."</A> </P><P><LABEL>����ң�</LABEL> <A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\" target=_blank>".$cash."</A> </P><P><LABEL>�Ǽ����£�</LABEL> <span class=\"normal-red\">".$arr_count["star"]."</span> </P><P><LABEL>�������£�</LABEL> ".$arr_count["good"]." </P><P><LABEL>����������</LABEL> ".$arr_count["all"]." </P><P><LABEL>���������</LABEL> ".number_format($arr_count["allpv"],0,".",",")." </P><P><LABEL>ע��ʱ�䣺</LABEL>".$o_man->get_reg()."</P><P class=more><A href=\"/mwjx/src_php/myhome.php?id=".$o_man->get_id()."\">�鿴���û��ĸ���ͼ���</A></P><P class=more><A href=\"/mwjx/src_php/write_msg.php?receiver=".$o_man->get_id()."\">�����û���վ�ڶ���</A></P></DIV>');\n";
//$m_js .= "</script>";
//var_dump($m_js);
echo $m_js;
exit();

function js_empty()
{
	//δ��¼���
	return "document.write('<DIV class=seller style=\"TEXT-ALIGN: left\"><H3>�����ߵ���</H3><img src=\"/mwjx/images/newface/1.bmp\"/><P><LABEL>�û�����</LABEL><A href=\"#\">&nbsp;</A></P><P><LABEL>���ıң�</LABEL><A href=\"#\">&nbsp;</A> </P><P><LABEL>����ң�</LABEL><A href=\"#\">&nbsp;</A></P><P><LABEL>�Ǽ����£�</LABEL> 0 </P><P><LABEL>�������£�</LABEL> 0 </P><P><LABEL>����������</LABEL> 0 </P><P><LABEL>���������</LABEL> 0 </P><P><LABEL>ע��ʱ�䣺</LABEL>-</P><P class=more><A href=\"#\">�鿴���û��ĸ���ͼ���</A></P><P class=more><A href=\"#\">�����û���վ�ڶ���</A></P></DIV>');\n";
}
?>