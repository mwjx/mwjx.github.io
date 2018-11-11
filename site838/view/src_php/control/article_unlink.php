<?php
//------------------------------
//create time:2007-1-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:取消文章链接
//------------------------------
function unlink_article($cid = -1,$id = -1)
{
	//取消文章链接
	//输入:cid(int)类目ID,id(int)文章ID
	//输出:true成功,失败返回字符串说明
	if($cid < 1 || $id < 1) //cid为0可能是搜索结果
		return "类目或文章ID无效";
	my_safe_include("mwjx/class_info.php");
	$obj = new c_class_info($cid);
	if($obj->get_id() < 1)
		return "类目无效";
	if($obj->unlink_article($id))
		return true;
	//文章不在类目中
	return "取消文章链接失败，可能是文章不存在或不在类目中";
}
/*
//-------------tests-----------
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//----------取消文章链接---------
var_dump(unlink_article(1,1));
//exit("aaaa");
*/
?>