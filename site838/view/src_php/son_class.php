<?php
//------------------------------
//create time:2007-7-19
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��Ŀ��ֱ������Ŀ��������Ŀ
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("lib/fun_global.php");
$m_cid = intval(isset($_GET["cid"])?$_GET["cid"]:""); //��ĿID
$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //ҳ��
$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //ÿҳ��¼��
//un/ed(��ѡ/��ѡ) 
$m_type = (isset($_GET["e"])?$_GET["e"]:""); //�����������ַ��������û�ID
//$m_str = (isset($_GET["str"])?$_GET["str"]:""); 
//if("" == $m_str)
//	$m_str = (isset($_POST["str"])?$_POST["str"]:""); 
//$m_str = addslashes($m_str); 
//var_dump($_REQUEST);
//echo $m_str."---";

/*
//------test-----
//-------����Ŀ�б�------
$m_type = "un";
$m_cid = 1;
$m_page = 1;
$m_per = 20;
//-------end test-------
*/

if($m_page < 1 || $m_per < 1 || "" == $m_type)
	exit("�쳣");
if($m_per > 100)
	exit("ÿҳ��¼����������");
$arr = c_class_info::get_arr_per();
if(!isset($arr[$m_per]))
	exit("ÿҳ��¼�����ϸ�");
//exit("ccc");
$str_xml = "";
if($m_cid < 1)
	exit("�쳣");
$obj = new c_class_info($m_cid);
if($obj->get_id() < 1)
	exit("��Ŀ������");
$path_xsl = get_dir_home()."../../mwjx/include/xsl/select_class.xsl";
$str_xml = "";
$str_xml .= "<?xml version=\"1.0\" encoding=\"GB2312\"?>\n";
$str_xml .= "<?xml-stylesheet type=\"text/xsl\" href=\"".$path_xsl."\"?>\n";
$title = ("un"==$m_type)?"��ѡ��":"��ѡ��";
$str_xml .= "<listview title=\"".$title."\">\n";
$str_xml .= ($obj->xml_son_link($m_page,$m_per,2));
$str_xml .= "</listview>\n";
if("" == $str_xml)
	exit("��Ŀ����Ϊ��");
print_xml($str_xml);
//echo "aa";									
?>