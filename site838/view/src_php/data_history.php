<?php
//------------------------------
//create time:2007-3-14
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:����Ķ���¼
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//my_safe_include("mwjx/interface.php");
//my_safe_include("lib/fun_global.php");
$m_ip = doubleval(isset($_GET["ip"])?$_GET["ip"]:"0"); //������IP
//$m_ip = 2130706433;
$ip_max = 4294967295; 				
if($m_ip < 1 || $m_ip > $ip_max)
	exit("ip�Ƿ�");
$m_arr = array();
history_read($m_ip,$m_arr);
$html = "<h1>����Ķ���ʷ</h1><br/>";
$len = count($m_arr);
for($i = ($len-1);$i >= 0;--$i){
	$row = $m_arr[$i];
	$url = url_byid(intval($row[0]));
	$html .= "<a href=\"".$url."\" target=\"_blank\">".$row[1]."</a><br/>";
}
/*
foreach($m_arr as $row){
	$url = url_byid(intval($row[0]));
	$html .= "<a href=\"".$url."\" target=\"_blank\">".$row[1]."</a><br/>";
}
*/
echo $html;
function url_byid($id = -1)
{
	//����idת��url
	//����:id����ID
	//���:url�ַ���
	$cid = 12; //��վ
	return  "/mwjx/home.php?main=./src_php/data_article.php&id=".strval($id)."&state=dynamic&r_cid=".strval($cid);
}
function history_read($ip = -1,&$arr)
{
	//��ʷ�Ķ���¼
	//����:ip(double)������IP,arr,����,array(array(id,title))
	//���:��
	$str_sql = "SELECT V.visit_id,A.str_title FROM visit V left join tbl_article A on V.visit_id = A.int_id WHERE V.type = 1 and  V.i_ip = '".strval($ip)."' limit 10;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();	
	$arr = $sql->get_array_rows();
}
//echo "����Ķ���¼";
?>