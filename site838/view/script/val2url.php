<?php
//------------------------------
//create time:2008-6-13
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:����ҳ��ַ�ϳ�ת��
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
	//�γ�����ҳ��ַ
	//����:siteվ��ID�ַ���,val������Ϣ�ַ���
	//���:url��ַ���쳣���ؿ�
	if(null == g_arr_v2u[site])
		return "";
	var url = g_arr_v2u[site];
	return url.replace("`|",val);
	//return url;
}
