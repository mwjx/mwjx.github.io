<?php
//------------------------------
//create time:2007-11-14
//creater:zll
//purpose:类目热门文章
//------------------------------
exit(js_empty());
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //类目ID,0为全站
//$m_id = 0; //tests
//exit(js_empty());
if(-1 == $m_id)
	exit(js_empty());
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
if(0 == $m_id){
	$str_sql = "select int_id,str_title from tbl_article where enum_active='Y' and enum_father='Y' order by int_click DESC limit 20;";
}
else{
	$str_sql = "select CA.aid,A.str_title from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid ='".$m_id."' and A.enum_active='Y' and A.enum_father='Y' order by A.int_click DESC limit 20;";
}
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
//var_dump($arr);
//exit();
$m_js = "";
$m_js .= "document.write('<h2>类目最热</h2><div id=\"class_hotarticle\"><UL>');\n";
$len = count($arr);
$str_ls = "";
$title_max = 48;
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i][0]);
	$title_more = $arr[$i][1];
	if(strlen($title_more)>$title_max)
		$title = msubstr($title_more,0,$title_max)."...";
	else
		$title = $title_more;
	//$url = "/mwjx/src_php/data_article.php?id=".$id."&state=dynamic&r_cid=".$m_id;
	$url = "/bbs/html/".g_dir_from_id($id).$id.".html";

	$str_ls .= "<LI><A href=\"".$url."\" target=\"_blank\" title=\"".$title_more."\">".$title."&nbsp;</A></LI>";
}
$m_js .= "document.write('".$str_ls."');\n";
$m_js .= "document.write('</UL></div>');\n";
//$m_js .= "</script>";
//var_dump($m_js);
echo $m_js;
exit();

function js_empty()
{
	//未登录输出
	return "document.write('<UL class=\"i2 cb\"></UL>');\n";
	//return "document.write('<DIV class=\"last_article\" style=\"TEXT-ALIGN: left\"><H3>热门文章</H3></DIV>');\n";
}
?>