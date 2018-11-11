<?php
//------------------------------
//create time:2006-12-26
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:左侧主菜单
//------------------------------
//if("小鱼" != $_COOKIE['username']){
//	$html = "由于资源限制，本功能暂时关闭。";	
//	exit($html);
//}
require_once("../../class/function.inc.php");
require_once("./fun_global.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/authorize.php");
//var_dump(xml_class());
//exit();
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
$aman = new manbase_2($currentuser,$currentpass);
$str_xml = "";
$str_xml .= get_xml_head("settle_left","");
$str_xml .= "<listview>";
$m_newmsg = $aman->had_newmsg();
//exit("aa");
if($m_newmsg)
	$str_xml .= "<had_newmsg src=\"/mwjx/images/msg.wav\"/>";
$str_xml .= get_settle_left($aman,$m_newmsg);
$str_xml .= "</listview>";
//var_dump($str_xml);
//$str_xml = "<root></root>\r\n\r\n";
print_xml($str_xml);
function get_xml_head($type = "",$style = "")
{
	//返回头部
	//输入:type是数据类型,前置条件要保证type有效
	//输出:xml字符串
	//return  "";
	if("" == $type)
		assert(0); //异常
	$xsl_path = "../include/xsl/".$type.".xsl";
	$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
	//$str_xsl = "";
	if("not_style" == $style)
		$str_xsl = "";
	return "<?xml version=\"1.0\"  encoding=\"gb2312\"?>".$str_xsl;
}
function get_settle_left(&$o,$newmsg=false)
{
	//左连菜单
	//输入:o是用户对象,newmsg(bool)是否有新消息
	//输出:xml字符串
	//$path_main = "../../data/12_20_1.xml";
	//$path = "./data_class.php?cid=12&amp;page=1&amp;per=20";
	$result = "";
	//$result .= "<item text=\"妙文精选\" href=\"".$path."\"></item>\n";
	//$result .= xml_class();
	$obj = new c_authorize;		
	if($o->get_id() > 0){
		$url = "./myhome.php?id=".$o->get_id();
		$result .= "<item text=\"我的妙文\"  href=\"".$url."\"";
		if($newmsg)
			$result .= " newmsg_img=\"/mwjx/images/newmail.gif\" ";
		$result .= ">";		
		$result .= "<item text=\"我的资料\" href=\"".$url."\"/>";
		$url = "./my_power.php?id=".$o->get_id();
		$result .= "<item text=\"我的权限\" href=\"".$url."\"/>";
		$result .= "</item>";
		$result .= "<item text=\"类目管理\" href=\"./data_all_class.php?type=class\">\n";	
		$result .= "<item text=\"类目链接\" href=\"./class_link.php\"></item>\n";	
		$result .= "<item text=\"类目书目\" href=\"./class_dir.php\"></item>\n";	
		$result .= "<item text=\"连载追踪\" href=\"./book_unover.php\"></item>\n";	
		$result .= "</item>\n";	
		$result .= "<item text=\"文章管理\" href=\"./article_manager.php\">";
		if($obj->can_do($o,1,1,12)){
			$result .= "<item text=\"超级发贴\" href=\"./supper_poster.php\"></item>\n";
		}		
		$result .= "</item>\n";
		$result .= "<item text=\"链接管理\" href=\"./link_manager.php\"></item>\n";
	}
	if($obj->can_do($o,1,1,5)){
		$result .= "<item text=\"杂项管理\" href=\"./other_manager.php\">\n";
		if($obj->can_do($o,1,1,5)){
			$result .= "<item text=\"文本替换\" href=\"./text_replacement.php\"></item>\n";
		}
		$result .= "</item>\n";
	}
	if($obj->can_do($o,1,1,17)){
		$result .= "<item text=\"津贴管理\" href=\"./cash_manager.php\"></item>\n";
	}

	if($o->check_super_manager()){ //超级管理员

		
		$result .= "<item text=\"文章排行\" href=\"./garbage_article.php\"></item>\n";
	}
	$name = isset($_COOKIE['username'])?$_COOKIE['username']:"";
	if("" == $name){	//未登录
		$title = "登录/注册";
		$result .= "<item text=\"".$title."\" href=\"../login.php?fun=login\"/>\n";
	
	}
	else{ //可能已登录
		$title = "退出";
		$result .= "<item text=\"".$title."\" href=\"../login.php?fun=logout\"/>\n";

	}
	//$result .= "<button>删除</button>";
	return $result;
}

?>