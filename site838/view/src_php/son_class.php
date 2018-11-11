<?php
//------------------------------
//create time:2007-7-19
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:类目的直接子类目及链接类目
//------------------------------
if("小鱼" != $_COOKIE['username']){
	$html = "由于资源限制，本功能暂时关闭。";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("lib/fun_global.php");
$m_cid = intval(isset($_GET["cid"])?$_GET["cid"]:""); //类目ID
$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //页数
$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //每页记录数
//un/ed(待选/已选) 
$m_type = (isset($_GET["e"])?$_GET["e"]:""); //可能是搜索字符串或是用户ID
//$m_str = (isset($_GET["str"])?$_GET["str"]:""); 
//if("" == $m_str)
//	$m_str = (isset($_POST["str"])?$_POST["str"]:""); 
//$m_str = addslashes($m_str); 
//var_dump($_REQUEST);
//echo $m_str."---";

/*
//------test-----
//-------子类目列表------
$m_type = "un";
$m_cid = 1;
$m_page = 1;
$m_per = 20;
//-------end test-------
*/

if($m_page < 1 || $m_per < 1 || "" == $m_type)
	exit("异常");
if($m_per > 100)
	exit("每页记录数超出限制");
$arr = c_class_info::get_arr_per();
if(!isset($arr[$m_per]))
	exit("每页记录数不合格");
//exit("ccc");
$str_xml = "";
if($m_cid < 1)
	exit("异常");
$obj = new c_class_info($m_cid);
if($obj->get_id() < 1)
	exit("类目不存在");
$path_xsl = get_dir_home()."../../mwjx/include/xsl/select_class.xsl";
$str_xml = "";
$str_xml .= "<?xml version=\"1.0\" encoding=\"GB2312\"?>\n";
$str_xml .= "<?xml-stylesheet type=\"text/xsl\" href=\"".$path_xsl."\"?>\n";
$title = ("un"==$m_type)?"待选区":"已选区";
$str_xml .= "<listview title=\"".$title."\">\n";
$str_xml .= ($obj->xml_son_link($m_page,$m_per,2));
$str_xml .= "</listview>\n";
if("" == $str_xml)
	exit("类目数据为空");
print_xml($str_xml);
//echo "aa";									
?>