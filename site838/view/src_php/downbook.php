<?php
//------------------------------
//create time:
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");

$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //�鼮ID
//$m_id = 1; //tests
//����
$path = book_path($m_id); 
if("" == $path)
	exit("�鼮��Ч��".$m_id);
down_record($m_id); //��¼����

header("Content-type: application/download\r\n");
header("Content-length: ".filesize($path)."\r\n");
//header("Content-disposition-type: attachment\r\n");
//header("Content-disposition: attachment;filename=".time().".csv");
header("Content-disposition:attachment; filename=".substr($path,strrpos($path,"/")+1));
$result = readfile($path);

function book_path($id = -1)
{
	//�鼮·��
	//����:id(int)�鼮ID
	//���:·���ַ���,�쳣���ؿ��ַ���
	$str_sql = "select filename from book_down where id = '".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	if(1 != count($arr))
		return "";
	return "../../data/up_book/".$arr[0][0];
}
function down_record($id = -1)
{
	//��¼���ش���
	//����:id(int)�鼮ID
	//���:��
	$str_sql = "update book_down set num=num+1 where id = '".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
}
?>