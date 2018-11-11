<?php
//------------------------------
//create time:
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");

$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //书籍ID
//$m_id = 1; //tests
//下载
$path = book_path($m_id); 
if("" == $path)
	exit("书籍无效：".$m_id);
down_record($m_id); //记录次数

header("Content-type: application/download\r\n");
header("Content-length: ".filesize($path)."\r\n");
//header("Content-disposition-type: attachment\r\n");
//header("Content-disposition: attachment;filename=".time().".csv");
header("Content-disposition:attachment; filename=".substr($path,strrpos($path,"/")+1));
$result = readfile($path);

function book_path($id = -1)
{
	//书籍路径
	//输入:id(int)书籍ID
	//输出:路径字符串,异常返回空字符串
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
	//记录下载次数
	//输入:id(int)书籍ID
	//输出:无
	$str_sql = "update book_down set num=num+1 where id = '".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
}
?>