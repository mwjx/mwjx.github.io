<?php
//------------------------------
//create time:2007-8-14
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:����ɾ�����£��߼�ɾ��
//------------------------------
//���ļ�ʹ��ǰҪinclude�����������ļ������ݿ������ļ�

function batch_del($str = "")
{
	//�������þ�������
	//����:str(string)����ID�б�,��ʽ:"id,id..."
	//���:true�ɹ�,����ȫ�ɹ������ַ���˵��
	//return $str;
	//exit();
	if("" == $str)
		return "ɾ���б���Ϊ��";
	//return true;
	$str_sql = "update tbl_article set enum_active = 'N' where int_id in (".$str.");";
	//echo ($str_sql)."<br/>";
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	return true;
}

/*
//-------------tests-----------
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//----------��������-------
$info = "18,22,23";
var_dump(batch_del($info));
//exit("aaaa");
*/
?>