<?php
//------------------------------
//create time:2007-5-24
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�Ǽ������б�
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
//-------------�°�-------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/starpage.php");
//my_safe_include("class_c2e.php");
//var_dump($arr_tear);
//����ı�
//ҳ����ʽ
//var_dump($data);
$obj = new c_starpage;
echo $obj->get_html();
exit();
//-----------end �°�-----------

?>