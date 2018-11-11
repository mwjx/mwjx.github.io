<?php
//------------------------------
//create time:2007-3-14
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:最近阅读记录
//------------------------------
if("小鱼" != $_COOKIE['username']){
	$html = "由于资源限制，本功能暂时关闭。";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//my_safe_include("mwjx/interface.php");
//my_safe_include("lib/fun_global.php");
$m_ip = doubleval(isset($_GET["ip"])?$_GET["ip"]:"0"); //浮点形IP
//$m_ip = 2130706433;
$ip_max = 4294967295; 				
if($m_ip < 1 || $m_ip > $ip_max)
	exit("ip非法");
$m_arr = array();
history_read($m_ip,$m_arr);
$html = "<h1>最近阅读历史</h1><br/>";
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
	//根据id转成url
	//输入:id文章ID
	//输出:url字符串
	$cid = 12; //网站
	return  "/mwjx/home.php?main=./src_php/data_article.php&id=".strval($id)."&state=dynamic&r_cid=".strval($cid);
}
function history_read($ip = -1,&$arr)
{
	//历史阅读记录
	//输入:ip(double)浮点形IP,arr,数组,array(array(id,title))
	//输出:无
	$str_sql = "SELECT V.visit_id,A.str_title FROM visit V left join tbl_article A on V.visit_id = A.int_id WHERE V.type = 1 and  V.i_ip = '".strval($ip)."' limit 10;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();	
	$arr = $sql->get_array_rows();
}
//echo "最近阅读记录";
?>