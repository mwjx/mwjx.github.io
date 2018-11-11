<?php
//------------------------------
//create time:2006-12-29
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:动态类目数据
//------------------------------
//if("小鱼" != $_COOKIE['username']){
//	$html = "由于资源限制，本功能暂时关闭。";	
//	exit($html);
//}
//if("" == $_COOKIE['username']){
//	$html = "由于资源限制，本功能只限注册会员使用。注册是免费的，您可以到《妙文精选》首页申请注册。";	
//	$html .= "<br/><a href=\"http://www.mwjx.com/\"><b>返回妙文精选</b></a>";
//	exit($html);
//}
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("lib/fun_global.php");
$m_cid = intval(isset($_GET["cid"])?$_GET["cid"]:""); //类目ID
$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //页数
$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //每页记录数
//数据使用者类型:list/manager(文章列表/文章管理)
$m_type = (isset($_GET["type"])?$_GET["type"]:"list"); 
//可能是搜索字符串或是用户ID
$m_str = trim(isset($_GET["str"])?$_GET["str"]:""); 
//if("" == $m_str)
//	$m_str = (isset($_POST["str"])?$_POST["str"]:""); 
$m_str = addslashes($m_str); 
//var_dump($_REQUEST);
//echo $m_str."---";

/*
//------test-----
//-------类目文章列表------
//$m_type = "manager";
//$m_cid = 1;
//$m_page = 1;
//$m_per = 20;
//-------查询------
$m_type = "list";
$m_str = addslashes("毛泽东"); //"posteqtoday";//addslashes("毛泽东");
$m_cid = 1;
$m_page = 1;
$m_per = 20;
$_GET["show_type"] = "dynamic";
//-------用户发布的文章-------
//$m_type = "user_article";
//$m_str = addslashes("200200067");
//-------end test-------
*/

if($m_page < 1 || $m_per < 1)
	exit("异常");
if($m_per > 100)
	exit("每页记录数超出限制");
$arr = c_class_info::get_arr_per();
if(!isset($arr[$m_per]))
	exit("每页记录数不合格");
if("search" == $m_type){
	my_safe_include("mwjx/search.php");
	$flag = 2;
	if(isset($_GET["show_type"]) && "dynamic" == $_GET["show_type"])
		$flag = 0;
	$obj = new c_search;
	$str_xml = ($obj->search($m_str,$m_page,$m_per,$flag));
}
else if("user_article" == $m_type){
	my_safe_include("mwjx/search.php");
	$flag = 2;
	if(isset($_GET["show_type"]) && "dynamic" == $_GET["show_type"])
		$flag = 0;
	$obj = new c_search;
	$str_xml = ($obj->user_article($m_str,$m_page,$m_per,$flag));
}
else{
	if($m_cid < 1)
		exit("异常");
	$obj = new c_class_info($m_cid);
	if($obj->get_id() < 1)
		exit("类目不存在");
	$all = ("list" == $m_type)?0:2;
	$str_xml = ($obj->data_class($m_page,$m_per,$all));
}
if("" == $str_xml)
	exit("类目数据为空");
print_xml($str_xml);
//echo "aa";									
?>