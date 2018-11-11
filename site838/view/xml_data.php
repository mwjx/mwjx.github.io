<?php
//------------------------------
//create time:2006-6-8
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:妙文精选数据源
//------------------------------
require("../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/interface.php");
my_safe_include("lib/fun_global.php");
//my_safe_include("lib/page_info.php");
$m_type = isset($_GET["type"])?$_GET["type"]:""; //数据类型
$m_fun = isset($_GET["fun"])?$_GET["fun"]:""; //操作
$m_id = isset($_GET["id"])?$_GET["id"]:""; //id
$m_page = isset($_GET["page"])?$_GET["page"]:""; //分页
$m_per = isset($_GET["per"])?$_GET["per"]:""; //每页记录数
$m_style = isset($_GET["style"])?$_GET["style"]:""; //xsl样式文件
//session_start();
//--------test---------------
//$m_style = "not_style"; //不调用xsl文件解析数据
//$m_type = "new_good"; //最新精华推荐列表
//$m_id = "8";
//--------end test-----------
//可以生成的数据类型列表
$m_arr_type = array("new_good");
if(!check_type($m_type,$m_arr_type))
	exit("数据类型无效:".strval($m_type));
//---------分页信息--------
//$m_obj_page = new c_page_info;
//init_page($m_obj_page,intval($m_page),intval($m_per));
//---------end 分页信息--------
$str_xml = get_xml($m_type,$m_fun,$m_id,$m_obj_page,$m_style);
//------------函数----------
function get_xml($type = "",$fun = "",$id = "",&$page,$style)
{
	//返回全部XML文本
	//输入:type是数据类型,fun操作,id用户ID,page是分页信息对象
	//$style是样式文件
	//输出:xml字符串
	$str_xml_fun = "<fun>".$fun."</fun>";
	$obj_face = new c_interface;
	$result = "";
	$result .= get_xml_head($type,$style);
	//$result .= get_xml_head();
	$result .= "<listview>";
	$result .= $str_xml_fun;
	switch($type){
		case "new_good":
			if("" != $_GET["bgcolor"])
				$result .= "<bgcolor>".$_GET["bgcolor"]."</bgcolor>";
			else
				$result .= "<bgcolor>FFFFFF</bgcolor>";
			$result .= get_new_good($obj_face);
			break;
		default:
			assert(0);
			break;
	}
	$result .= "</listview>";
	return $result;
}
//-------------xml数据函数群-------------
function get_new_good(&$face)
{
	//国家总报表
	//输入:face接口代理
	//输出:xml字符串,异常返回空字符串
	return $face->new_vote_article(1);
	//return $face->get_report_total();
}
//-----------------函数群---------------
function get_xml_head($type = "",$style = "")
{
	//返回头部
	//输入:type是数据类型,前置条件要保证type有效
	//输出:xml字符串
	if("" == $type)
		assert(0); //异常
	$xsl_file = "";
	switch($type){
		default:
			$xsl_file = $type;
			break;
	}
	$xsl_path = "include/xsl/".$xsl_file.".xsl";
	$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
	if("not_style" == $style)
		$str_xsl = "";
	return "<?xml version=\"1.0\"  encoding=\"gb2312\"?>".$str_xsl;
}
function check_type($type = "",&$arr)
{
	//检查数据类型是否有效
	//输入:type是数据类型字符串
	//输出:有效返回true,否则返回false
	if(("string" != gettype($type)) || ("" == $type))
		return false;
	//$arr = array("total_view","settle_left");
	foreach($arr as $name){
		if($type == $name)
			return true;
	}
	return false;
}
?>
<?php
print_xml($str_xml);
?>
