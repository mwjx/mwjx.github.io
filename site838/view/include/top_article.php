<?php
//------------------------------
//create time:2007-9-26
//creater:zll
//purpose:����ҳ�涥��
//------------------------------
//exit(js_notlogin()); //δ��¼
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
if("" == $currentuser || "" == $currentpass)
	exit(js_notlogin()); //δ��¼
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
//my_safe_include("lib/fun_global.php");
//my_safe_include("mwjx/my_mwjx.php");
//$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //�û�ID
//$m_name = (isset($_GET["name"])?$_GET["name"]:""); //�û���
//---------test---------
//$m_id = 200200068;
//$m_name = "С��";

$man_me = new manbase_2($currentuser,$currentpass);
if($man_me->get_id() < 1) //δ��½
	exit(js_notlogin()); //δ��¼
$m_js = "";
$m_js .= "document.write('<DIV id=\"HeadTop_myalimama_list2\" style=\"BACKGROUND: #FFFFFF\"><UL><LI><SPAN style=\"COLOR: #FFFFFF\">| </SPAN><A href=\"http://www.fish838.com/\">��ҳ</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN> ����! <A href=\"/index.html?id=".$man_me->get_id()."\">".$man_me->get_name()."</A> [<A href=\"/site838/view/login.php?fun=logout\">�˳�</A>]</LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/src_php/msglist.php\" target=\"_blank\">����Ϣ(".$man_me->newmsg_num().")</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/src_php/msglist.php\" target=\"_blank\">�¼�(".$man_me->action_num().")</A> </A></LI></UL></DIV>');\n";
//<LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"http://mwjxhome.3322.org/fish/home.php\" target=_blank>����˫��</A> </LI>
//<LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"#\" onclick=\"javascript:alert(\'�������������\');\">������</A> </LI>
exit($m_js);

function js_notlogin()
{
	//δ��¼���
	return "document.write('<DIV id=\"HeadTop_myalimama_list2\" style=\"BACKGROUND: #FFFFFF\"><UL><LI><SPAN style=\"COLOR: #FFFFFF\">| </SPAN><A href=\"http://www.fish838.com/\">��ҳ</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/reg.php\">ע��</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/login.php\">��¼</A> </A></LI></UL></DIV>');\n";
}
?>
