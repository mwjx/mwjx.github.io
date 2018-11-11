<?php
//------------------------------
//create time:2007-11-25
//creater:zll
//purpose:影视在线看
//------------------------------
if("小鱼" != $_COOKIE['username']){
	$html = "由于资源限制，本功能暂时关闭。";	
	exit($html);
}
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //类目ID,0为全站
//$m_id = 1; //tests
//exit(js_empty());
if(-1 == $m_id)
	exit(js_empty());
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");

$str_sql = "select id,name from class_info where fid ='".$m_id."' and enable='Y' order by last DESC limit 10;";

//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
//var_dump($arr);
//exit();
$m_js = "";
$m_js .= "document.write('<DIV class=\"movie\" style=\"TEXT-ALIGN: left\"><br/><H3>影视在线看</H3>');\n";
$len = count($arr);
$str_ls = "";
$title_max = 32;
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i][0]);
	$title_more = $arr[$i][1];
	if(strlen($title_more)>$title_max)
		$title = msubstr($title_more,0,$title_max)."...";
	else
		$title = $title_more;
	//$url = "/mwjx/src_php/data_article.php?id=".$id."&state=dynamic&r_cid=".$m_id;
	$url = "/data/".$id.".html";

	$str_ls .= "<A href=\"".$url."\" target=\"_blank\" title=\"".$title_more."\">".$title."&nbsp;</A><br/>";
}
$m_js .= "document.write('<P>".$str_ls."</P>');\n";
$m_js .= "document.write('</DIV>');\n";
//$m_js .= "</script>";
//var_dump($m_js);
echo $m_js;
exit();

function js_empty()
{
	//未登录输出
	return "document.write('<DIV class=\"last_article\" style=\"TEXT-ALIGN: left\"><H3>影视在线看</H3>".html_ad()."</DIV>');\n";
}
function html_ad()
{
	return "";
}
?>