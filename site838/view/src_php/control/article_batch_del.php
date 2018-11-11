<?php
//------------------------------
//create time:2007-8-14
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:批量删除文章，逻辑删除
//------------------------------
//本文件使用前要include基本函数库文件，数据库连接文件

function batch_del($str = "")
{
	//批量设置精华文章
	//输入:str(string)文章ID列表,格式:"id,id..."
	//输出:true成功,不完全成功返回字符串说明
	//return $str;
	//exit();
	if("" == $str)
		return "删除列表不能为空";
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
//----------归类文章-------
$info = "18,22,23";
var_dump(batch_del($info));
//exit("aaaa");
*/
?>