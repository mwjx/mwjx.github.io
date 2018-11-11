<?php
//------------------------------
//create time:2006-12-29
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:动态类目数据
//------------------------------
//$_COOKIE['username'] = "";
if("" == $_COOKIE['username']){
	$html = "由于资源限制，本功能只限注册会员使用。注册是免费的，您可以到《妙文精选》首页申请注册。";	
	//$m_id = intval(isset($_GET["id"])?$_GET["id"]:"");
	//$m_id = 1999;
	//$dir = g_dir_from_id($m_id);
	//$url = "/bbs/html/".$dir.$m_id.".html";
	$html .= "<br/><a href=\"http://www.mwjx.com/\"><b>返回妙文精选</b></a>";
	exit($html);
}
require("../../class/function.inc.php");
require_once("./fun_global.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("lib/fun_global.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/authorize.php");
//数据使用者:class/article/article_ed/post
//(类目管理/文章管理待选/文章管理选中/发布文章的类目选择)
$m_type = (isset($_GET["type"])?$_GET["type"]:"class"); 
$m_cid = intval(isset($_GET["id"])?$_GET["id"]:""); //类目ID
$m_aid = intval(isset($_GET["aid"])?$_GET["aid"]:-1); //文章ID，编辑
//$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //页数
//$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //每页记录数
//header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
//header("Content-Type: text/html;charset=GBK");
//$m_type = "post"; //tests
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) < 1){
	$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
	$str_xml .= "<msg>当前用户无效,请登录重试</msg>";
	print_xml($str_xml);		
	exit();
}
/*
$obj = new c_authorize;		
if(!$obj->can_do($obj_man,1,1,3)){
	$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
	$str_xml .= "<msg>无权创建类目</msg>";
	print_xml($str_xml);		
	exit();
}
*/
/*
//------test-----
$m_type = "class_link";
//$m_aid = 6811;
//$m_cid = 1;
//$m_page = 1;
//$m_per = 20;
*/
$str_xml = "";
$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>\n";
//$path_xsl = "../mwjx/include/xsl/index_class.xsl";
$path_xsl = "";
if("class" == $m_type){
	$path_xsl = get_dir_home()."view/include/xsl/all_class.xsl";	
}
else if("post" == $m_type){
	$path_xsl = get_dir_home()."view/include/xsl/post.xsl";
	//$path_xsl = "";
}
else{
	$path_xsl = get_dir_home()."view/include/xsl/class_tree.xsl";
}
if("" != $path_xsl){
	$str_xml .= "<?xml-stylesheet type=\"text/xsl\" href=\"".$path_xsl."\"?>\n";
}
if("article" == $m_type){
	$str_xml .= "<listview title=\"待选区\">\n";
}
else if("article_ed" == $m_type){
	$str_xml .= "<listview title=\"选中区\">\n";
}
else if("post" == $m_type){
	$str_xml .= "<listview title=\"选择要将文章发布到的类目\">\n";
	//exit("ccc");
	if($m_aid > 0)
		$str_xml .= xml_article_content($m_aid);
}
else{
	$str_xml .= "<listview>\n";
}
$str_xml .= xml_class();
$str_xml .= "</listview>";
print_xml($str_xml);
//echo "aa";									
function xml_article_content($id = -1)
{
	//文章内容
	//输入:id(int)文章ID
	//输出:xml字符串，异常返回空字符串
	if($id < 1)
		return "";
	my_safe_include("class_article.php");
	$obj = new articlebase($id,"","Y"); 
	if($obj->get_id() < 1)
		return "";		
	$xml = "<article>";
	$xml .= "<id>".$id."</id>";
	$xml .= "<title>".htmlspecialchars($obj->get_title())."</title><content>".htmlspecialchars($obj->get_txt())."</content>";
	$xml .= "</article>";
	//exit("ggg");
	return $xml;
}
?>