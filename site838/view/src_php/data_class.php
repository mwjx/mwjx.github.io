<?php
//------------------------------
//create time:2006-12-29
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��̬��Ŀ����
//------------------------------
//if("С��" != $_COOKIE['username']){
//	$html = "������Դ���ƣ���������ʱ�رա�";	
//	exit($html);
//}
//if("" == $_COOKIE['username']){
//	$html = "������Դ���ƣ�������ֻ��ע���Աʹ�á�ע������ѵģ������Ե������ľ�ѡ����ҳ����ע�ᡣ";	
//	$html .= "<br/><a href=\"http://www.mwjx.com/\"><b>�������ľ�ѡ</b></a>";
//	exit($html);
//}
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("lib/fun_global.php");
$m_cid = intval(isset($_GET["cid"])?$_GET["cid"]:""); //��ĿID
$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //ҳ��
$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //ÿҳ��¼��
//����ʹ��������:list/manager(�����б�/���¹���)
$m_type = (isset($_GET["type"])?$_GET["type"]:"list"); 
//�����������ַ��������û�ID
$m_str = trim(isset($_GET["str"])?$_GET["str"]:""); 
//if("" == $m_str)
//	$m_str = (isset($_POST["str"])?$_POST["str"]:""); 
$m_str = addslashes($m_str); 
//var_dump($_REQUEST);
//echo $m_str."---";

/*
//------test-----
//-------��Ŀ�����б�------
//$m_type = "manager";
//$m_cid = 1;
//$m_page = 1;
//$m_per = 20;
//-------��ѯ------
$m_type = "list";
$m_str = addslashes("ë��"); //"posteqtoday";//addslashes("ë��");
$m_cid = 1;
$m_page = 1;
$m_per = 20;
$_GET["show_type"] = "dynamic";
//-------�û�����������-------
//$m_type = "user_article";
//$m_str = addslashes("200200067");
//-------end test-------
*/

if($m_page < 1 || $m_per < 1)
	exit("�쳣");
if($m_per > 100)
	exit("ÿҳ��¼����������");
$arr = c_class_info::get_arr_per();
if(!isset($arr[$m_per]))
	exit("ÿҳ��¼�����ϸ�");
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
if("" == $str_xml)
	exit("��Ŀ����Ϊ��");
print_xml($str_xml);
//echo "aa";									
?>