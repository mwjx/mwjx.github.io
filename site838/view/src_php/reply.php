<?php
//------------------------------
//create time:2007-3-28
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�����б�
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/reply.php");
my_safe_include("page_info.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:""); //��������ID
$m_page = intval(isset($_GET["page"])?$_GET["page"]:"1"); //ҳ��
$m_per = intval(isset($_GET["per"])?$_GET["per"]:"10"); //ÿҳ��¼��
//��������C/A(��Ŀ/����)//δ���,2007-8-10
$m_gtype = isset($_GET["gtype"])?$_GET["gtype"]:"A"; 
if($m_page < 1)
	$m_page = 1;
if($m_per < 1)
	$m_per = 1;
if($m_per > 500)
	$m_per = 500;
//--------test---------
//$m_gtype = "C";
//$m_id = 12; //6811	
//------end test-------
$m_obj_pg = new c_page_info($m_page,$m_per,0);
$m_obj = new c_reply;
if("C"==$m_gtype)
	$m_arr = $m_obj->reply_list_2(1,$m_obj_pg,$m_id); //δ���
else
	$m_arr = $m_obj->reply_list_article($m_obj_pg,$m_id);
//var_dump($m_id);
//exit();
print_xml(reply_xml($m_arr,$m_obj_pg,$m_id,$m_gtype));

function reply_xml(&$arr,&$pg,$id = -1,$gt="A")
{
	//�����б�תΪxml
	//����:arr(array)�б�����,pg(object)��ҳ����,id(int)����ID
	//gt(string)��������C/A(��Ŀ/����)
	//���:xml�ַ���
	$path_xsl = get_dir_home()."../../mwjx/include/xsl/reply.xsl";
	$xml = "";
	$xml .= "<?xml version=\"1.0\" encoding=\"GB2312\"?>\n";
	$xml .= "<?xml-stylesheet type=\"text/xsl\" href=\"".$path_xsl."\"?>\n";
	$xml .= "<listview>";
	$xml .= "<gid>".strval($id)."</gid>";	
	$xml .= "<gt>".strval($gt)."</gt>";	
	$xml .= "<reply>";
	foreach($arr as $row){
		$xml .= "<item><id>".$row["int_id"]."</id><time>".$row["modify"]."</time><content>".htmlspecialchars($row["content"])."</content><name>".htmlspecialchars($row["name"])."</name><old_new>".$row["old_new"]."</old_new></item>";
	}
	$xml .= "</reply>";
	$xml .= get_xml_pagelist($pg);
	$xml .= "</listview>";
	return $xml;
}
function get_xml_pagelist(&$page_info)
{
	//���ط�ҳXML��Ϣ
	//����:page_inf��ҳ��Ϣ����
	//���:xml�ַ���
	$str_per_list = "<per_list>";
	$str_per_list .= "<per_page><name>10</name><num>10</num></per_page>";
	$str_per_list .= "<per_page><name>20</name><num>20</num></per_page>";
	$str_per_list .= "<per_page><name>30</name><num>30</num></per_page>";
	$str_per_list .= "<per_page><name>50</name><num>50</num></per_page>";
	$str_per_list .= "<per_page><name>100</name><num>100</num></per_page>";
	$str_per_list .= "</per_list>";

	$result = "<pagelist>";
	$result .= "<count>".strval($page_info->get_count())."</count>";
	$result .= "<current>".strval($page_info->get_page())."</current>";
	$result .= "<num_per_page>".strval($page_info->get_per())."</num_per_page>";
	$result .= $page_info->get_xml_link();
	$result .= $str_per_list;
	$result .= "</pagelist>";
	return $result;
}
//echo "aaa";
?>