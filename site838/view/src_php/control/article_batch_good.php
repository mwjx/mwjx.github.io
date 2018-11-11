<?php
//------------------------------
//create time:2007-7-20
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:批量设置精华文章
//------------------------------
//本文件使用前要include基本函数库文件，数据库连接文件

function batch_good($str = "")
{
	//批量设置精华文章
	//输入:str(string)信息,格式:
	//"Y_id,id...;N_id,id..."(Y精华,N非精华)
	//输出:true成功,不完全成功返回字符串说明
	//return $str;
	//exit();
	$arr = explode(";",$str);
	if(($len = count($arr)) != 2)
		return "提交列表格式异常";
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
//----------归类文章-------
$info = "Y_7506;N_";
var_dump(batch_good($info));
//exit("aaaa");
*/
?>