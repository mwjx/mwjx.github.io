<?php
//------------------------------
//create time:2010-12-24
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�Ƿ���С˵�����½ں�̨
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
header("Content-Type: text/html;charset=GBK");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //С˵ID
//exit("N");
exit(check_new($m_id));
function check_new($id = -1)
{
	//�Ƿ���С˵�½�
	//����:id(int)С˵ID
	//���:Y/N
	//1261314
	$str_sql = "select count(TS.id) from track_section TS inner join novels_links NL on NL.id=TS.tid inner join novels N on N.id=NL.novels where N.id='".$id."';";
	//return $str_sql;
	//$str_sql = "select * from novels where id='".$id."';"; 
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_rows();
	$sql->close();
	//var_dump($arr);
	//exit($str_sql);
	$num = intval($arr[0][0]);
	if($num < 1)
		return "N";
	return "Y";
}

?>