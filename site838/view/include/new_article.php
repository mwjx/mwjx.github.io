<?php
//------------------------------
//create time:2007-10-15
//creater:zll
//purpose:类目最新文章
//------------------------------
//exit(js_empty());
exit("document.write('<script type=\"text/javascript\">google_ad_client = \"pub-6913943958182517\";google_ad_slot = \"6043945310\";google_ad_width = 468;google_ad_height = 60;</script><script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>');\n");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //类目ID,0为全站
//$m_id = 0; //tests
//exit(js_empty());
if(-1 == $m_id)
	exit(js_empty());
//$_COOKIE['username'] = "";
if("" == $_COOKIE['username']){
	exit("document.write('<script type=\"text/javascript\">google_ad_client = \"pub-6913943958182517\";google_ad_slot = \"6043945310\";google_ad_width = 468;google_ad_height = 60;</script><script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>');\n");
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
if(0 == $m_id){
	$str_sql = "select int_id,str_title from tbl_article where enum_active='Y' and enum_father='Y' order by dtt_change DESC limit 20;";
}
else{
	$str_sql = "select CA.aid,A.str_title from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid ='".$m_id."' and A.enum_active='Y' and A.enum_father='Y' order by A.dtt_change DESC limit 20;";

}

//exit();
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
//var_dump($arr);
//exit();
$m_js = "";
$m_js .= "document.write('<h2>类目最新</h2><div id=\"class_newarticle\"><UL>');\n";
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
	return "document.write('<h2>类目最新</h2><div id=\"class_newarticle\"><UL></UL></div>');\n";
	//return "document.write('<DIV class=\"last_article\" style=\"TEXT-ALIGN: left\"><H3>最新文章</H3></DIV>');\n";
}
?>