<?php
//------------------------------
//create time:2007-7-20
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�������þ�������
//------------------------------
//���ļ�ʹ��ǰҪinclude�����������ļ������ݿ������ļ�

function batch_good($str = "")
{
	//�������þ�������
	//����:str(string)��Ϣ,��ʽ:
	//"Y_id,id...;N_id,id..."(Y����,N�Ǿ���)
	//���:true�ɹ�,����ȫ�ɹ������ַ���˵��
	//return $str;
	//exit();
	$arr = explode(";",$str);
	if(($len = count($arr)) != 2)
		return "�ύ�б��ʽ�쳣";
	for($i = 0;$i < $len;++$i){
		$row = explode("_",$arr[$i]);
		if(2 != count($row))
			continue;
		if("" == $row[1])
			continue;
		$good = (("Y"==$row[0])?"Y":"N");
		$str_sql = "update tbl_article set enum_good = '".$good."' where int_id in (".$row[1].");";
		//echo ($str_sql)."<br/>";
		$sql=new mysql;
		$sql->query($str_sql);
		$sql->close();
			
	}
	return true;
}

/*
//-------------tests-----------
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//----------��������-------
$info = "Y_7506;N_";
var_dump(batch_good($info));
//exit("aaaa");
*/
?>