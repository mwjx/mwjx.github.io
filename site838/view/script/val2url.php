<?php
//------------------------------
//create time:2008-6-13
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:索引页地址合成转换
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$str_sql = "select site,val from track_pass  where t = '15' order by id desc;";
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
$len = count($arr);
//$js = "<script language=\"javascript\">\n";
$js .= "g_arr_v2u = Array();\n";
for($i = 0;$i < $len; ++$i){
	$id = $arr[$i][0];
	$val = $arr[$i][1];
	$js .= "g_arr_v2u['".$id."'] = '".$val."';\n";
}
//$js .= "</script>\n";
echo $js;
?>
function val2url(site,val)
{
	//形成索引页地址
	//输入:site站点ID字符形,val索引信息字符形
	//输出:url地址，异常返回空
	if(null == g_arr_v2u[site])
		return "";
	var url = g_arr_v2u[site];
	return url.replace("`|",val);
	//return url;
}
