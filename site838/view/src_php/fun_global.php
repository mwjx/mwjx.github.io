<?php
//------------------------------
//create time:2005-12-1
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:���ú���
//------------------------------
function get_xml_pagelist($page_info = NULL,$path = "")
{
	//���ط�ҳXML��Ϣ
	//����:page_inf��ҳ��Ϣ����,$pathҪ��ת���ĵ�ַ�����?��&amp;
	//���:xml�ַ���
	if("" == $path)
		assert(0);
	$str_per_list = "<per_list>";
	$str_per_list .= "<per_page><name>10</name><num>10</num></per_page>";
	$str_per_list .= "<per_page><name>20</name><num>20</num></per_page>";
	$str_per_list .= "<per_page><name>30</name><num>30</num></per_page>";
	$str_per_list .= "<per_page><name>50</name><num>50</num></per_page>";
	$str_per_list .= "<per_page><name>100</name><num>100</num></per_page>";
	//$str_per_list .= "<per_page><name>ȫ��</name><num>900000</num></per_page>";
	$str_per_list .= "</per_list>";

	$result = "<pagelist>";
	$result .= "<count>".strval($page_info->int_count)."</count>";
	$result .= "<current>".strval($page_info->int_page)."</current>";
	$result .= "<num_per_page>".strval($page_info->int_per)."</num_per_page>";
	$result .= "<path>".strval($path)."</path>";
	$result .= $page_info->get_xml_link();
	$result .= $str_per_list;
	$result .= "</pagelist>";
	return $result;
}
function get_user_id()
{
	//�����û�ID
	//����:��,Ҫ��ȡsessionֵ
	//���:ID����,�쳣����false
	//ʹ�ñ�����Ҫѡsession_start,���������ݿ������ļ�
	if(intval($_SESSION["uid"]) > 0)
		return intval($_SESSION["uid"]);
	my_safe_include("class_user.php");
	$obj_user = new userbase;
	$obj_user->load_byname($_SESSION["username"]);
	if(!$obj_user->check_build())
		return false;
	return intval($obj_user->get_id());
}
function xml_class($type = 1)
{
	//������Ŀ�б�
	//����:type����:1/2(����/������Ϣ)
	//���:xml�ַ���
	my_safe_include("mwjx/class_info.php");
	$str = "";
	//$id = 12; //mwjx���ڵ�
	$id = 4; //mwjx���ڵ�
	class_son($id,$str);
	return $str;
}
function class_son($id = -1,&$xml)
{
	//����Ŀ,ǰ�ñ�֤����class_info.php
	//����:id(int)��ĿID,xml��Ŀ�ַ���
	//���:��
	if($id < 1)
		return;
	$obj = new c_class_info($id);				
	//$path = "./data_class.php?cid=".strval($obj->get_id())."&amp;page=1&amp;per=20";
	$path = "./class_homepage.php?cid=".$obj->get_id();
	$xml .= "<item text=\"".htmlspecialchars($obj->get_name())."\" href=\"".$path."\" id=\"".strval($obj->get_id())."\">\n";	
	$arr_tmp = $obj->son_class();
	if(count($arr_tmp) < 1){
		$xml .= "</item>\n";
		return;
	}
	foreach($arr_tmp as $row)
		class_son(intval($row[0]),$xml);
	$xml .= "</item>\n";
}

?>