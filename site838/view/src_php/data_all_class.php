<?php
//------------------------------
//create time:2006-12-29
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��̬��Ŀ����
//------------------------------
//$_COOKIE['username'] = "";
if("" == $_COOKIE['username']){
	$html = "������Դ���ƣ�������ֻ��ע���Աʹ�á�ע������ѵģ������Ե������ľ�ѡ����ҳ����ע�ᡣ";	
	//$m_id = intval(isset($_GET["id"])?$_GET["id"]:"");
	//$m_id = 1999;
	//$dir = g_dir_from_id($m_id);
	//$url = "/bbs/html/".$dir.$m_id.".html";
	$html .= "<br/><a href=\"http://www.mwjx.com/\"><b>�������ľ�ѡ</b></a>";
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
//����ʹ����:class/article/article_ed/post
//(��Ŀ����/���¹����ѡ/���¹���ѡ��/�������µ���Ŀѡ��)
$m_type = (isset($_GET["type"])?$_GET["type"]:"class"); 
$m_cid = intval(isset($_GET["id"])?$_GET["id"]:""); //��ĿID
$m_aid = intval(isset($_GET["aid"])?$_GET["aid"]:-1); //����ID���༭
//$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //ҳ��
//$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //ÿҳ��¼��
//header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
//header("Content-Type: text/html;charset=GBK");
//$m_type = "post"; //tests
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) < 1){
	$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
	$str_xml .= "<msg>��ǰ�û���Ч,���¼����</msg>";
	print_xml($str_xml);		
	exit();
}
/*
$obj = new c_authorize;		
if(!$obj->can_do($obj_man,1,1,3)){
	$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
	$str_xml .= "<msg>��Ȩ������Ŀ</msg>";
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
	$str_xml .= "<listview title=\"��ѡ��\">\n";
}
else if("article_ed" == $m_type){
	$str_xml .= "<listview title=\"ѡ����\">\n";
}
else if("post" == $m_type){
	$str_xml .= "<listview title=\"ѡ��Ҫ�����·���������Ŀ\">\n";
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
	//��������
	//����:id(int)����ID
	//���:xml�ַ������쳣���ؿ��ַ���
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