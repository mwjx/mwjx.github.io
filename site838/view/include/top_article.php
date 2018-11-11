<?php
//------------------------------
//create time:2007-9-26
//creater:zll
//purpose:所有页面顶部
//------------------------------
//exit(js_notlogin()); //未登录
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
if("" == $currentuser || "" == $currentpass)
	exit(js_notlogin()); //未登录
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
//my_safe_include("lib/fun_global.php");
//my_safe_include("mwjx/my_mwjx.php");
//$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //用户ID
//$m_name = (isset($_GET["name"])?$_GET["name"]:""); //用户名
//---------test---------
//$m_id = 200200068;
//$m_name = "小鱼";

$man_me = new manbase_2($currentuser,$currentpass);
if($man_me->get_id() < 1) //未登陆
	exit(js_notlogin()); //未登录
$m_js = "";
$m_js .= "document.write('<DIV id=\"HeadTop_myalimama_list2\" style=\"BACKGROUND: #FFFFFF\"><UL><LI><SPAN style=\"COLOR: #FFFFFF\">| </SPAN><A href=\"http://www.fish838.com/\">首页</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN> 您好! <A href=\"/index.html?id=".$man_me->get_id()."\">".$man_me->get_name()."</A> [<A href=\"/site838/view/login.php?fun=logout\">退出</A>]</LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/src_php/msglist.php\" target=\"_blank\">短消息(".$man_me->newmsg_num().")</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/src_php/msglist.php\" target=\"_blank\">事件(".$man_me->action_num().")</A> </A></LI></UL></DIV>');\n";
//<LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"http://mwjxhome.3322.org/fish/home.php\" target=_blank>废墟双城</A> </LI>
//<LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"#\" onclick=\"javascript:alert(\'聪明人无需帮助\');\">帮助？</A> </LI>
exit($m_js);

function js_notlogin()
{
	//未登录输出
	return "document.write('<DIV id=\"HeadTop_myalimama_list2\" style=\"BACKGROUND: #FFFFFF\"><UL><LI><SPAN style=\"COLOR: #FFFFFF\">| </SPAN><A href=\"http://www.fish838.com/\">首页</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/reg.php\">注册</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/login.php\">登录</A> </A></LI></UL></DIV>');\n";
}
?>
