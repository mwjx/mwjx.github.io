<?php
//------------------------------
//create time:2007-5-14
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�����������
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/link.php");
my_safe_include("class_article.php");
my_safe_include("lib/fun_global.php");
$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //ҳ��
$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //ÿҳ��¼��
$m_id = intval(isset($_GET["id"])?$_GET["id"]:"0");  //����ID

/*
//------test-----
//-------��Ŀ�����б�------
//$m_type = "manager";
$m_id = 16583;
$m_page = 1;
$m_per = 20;
//-------end test-------
*/
//exit("�����������:".strval($m_id));

if($m_page < 1 || $m_per < 1)
	exit("�쳣");
if($m_per > 100)
	exit("ÿҳ��¼����������");
$arr = c_class_info::get_arr_per();
if(!isset($arr[$m_per]))
	exit("ÿҳ��¼�����ϸ�");

$obj_article = new articlebase($m_id,"","N"); 
if($obj_article->get_id() < 1)
	exit("������Ч");
//var_dump($obj_article->get_id());
//var_dump($obj_article->get_title());
$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>\n";
//$path_xsl = "../mwjx/include/xsl/data_links.xsl";
$path_xsl = get_dir_home()."../../mwjx/include/xsl/data_links.xsl";
//exit($path_xsl);
$str_xml .= "<?xml-stylesheet type=\"text/xsl\" href=\"".$path_xsl."\"?>\n";
$str_xml .= "<listview>\n";
$str_xml .= ("<info><id>".strval($obj_article->get_id())."</id><title>".htmlspecialchars($obj_article->get_title())."</title>"); 
$str_xml .= "</info>\n";
//�����б�
$obj_links = new c_link;
$arr_links = ($obj_links->links($m_id));
//var_dump($arr_links);
//exit();
//$str_xml .= "<links>\n";
foreach($arr_links as $row){
	if(NULL == $row[0])
		continue;
	$str_xml .= "<item><id>".strval($row[0])."</id><title>".htmlspecialchars($row[1])."</title></item>\n";
}
//$str_xml .= "</links>\n";
$str_xml .= "</listview>\n";
//exit();
/*
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
		exit("�쳣");
	$obj = new c_class_info($m_cid);
	if($obj->get_id() < 1)
		exit("��Ŀ������");
	$all = ("list" == $m_type)?0:2;
	$str_xml = ($obj->data_class($m_page,$m_per,$all));
}
*/
//$obj = new c_class_info;
//return $obj->list2xml($arr,$pg,$flag);
if("" == $str_xml)
	exit("��Ŀ����Ϊ��");
print_xml($str_xml);
//echo "aa";									
?>