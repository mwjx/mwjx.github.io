<?php
//------------------------------
//create time:2007-1-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:ȡ����������
//------------------------------
function unlink_article($cid = -1,$id = -1)
{
	//ȡ����������
	//����:cid(int)��ĿID,id(int)����ID
	//���:true�ɹ�,ʧ�ܷ����ַ���˵��
	if($cid < 1 || $id < 1) //cidΪ0�������������
		return "��Ŀ������ID��Ч";
	my_safe_include("mwjx/class_info.php");
	$obj = new c_class_info($cid);
	if($obj->get_id() < 1)
		return "��Ŀ��Ч";
	if($obj->unlink_article($id))
		return true;
	//���²�����Ŀ��
	return "ȡ����������ʧ�ܣ����������²����ڻ�����Ŀ��";
}
/*
//-------------tests-----------
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//----------ȡ����������---------
var_dump(unlink_article(1,1));
//exit("aaaa");
*/
?>