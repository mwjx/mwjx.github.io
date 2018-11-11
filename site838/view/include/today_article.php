<?php
//------------------------------
//create time:2007-11-12
//creater:zll
//purpose:今日更新
//------------------------------
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //类目ID
//$m_id = 170;
if(-1 == $m_id)
	exit(js_empty());
//if("小鱼" != $_COOKIE['username']){

//	exit("document.write('由于资源有限，此功能暂关闭。&nbsp;&nbsp;<a href=\"/mwjx/track/index.php?id=".$m_id."\">书目索引</a>');\n");
//}
//$m_id = 2; //tests
//exit();
//exit(js_empty());
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$d = 4;
$e = date("Y-m-d",time());
$s = date("Y-m-d",(time()-86400*$d));
$str_sql = "select CA.aid,A.str_title from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid ='".$m_id."' and A.enum_active='Y' and A.enum_father='Y' and dte_post BETWEEN '".$s."' and '".$e."' order by A.dtt_change DESC limit 20;";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
if(count($arr) < 1){ //今日没有更新，留空白不好看，用旧的填充
	$str_sql = "select CA.aid,A.str_title from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid ='".$m_id."' and A.enum_active='Y' and A.enum_father='Y' order by A.dtt_change DESC limit 18;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();

}
//var_dump($arr);
//exit();
$len = count($arr);
if($len < 1)
	exit(js_empty());
$m_js = "";
$m_js .= "document.write('<UL>');\n";

$str_ls = "";
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i][0]);
	$title_more = $arr[$i][1];
	//if(strlen($title_more)>22)
	//	$title = msubstr($title_more,0,22)."...";
	//else
	//	$title = $title_more;
	$title = $title_more;
	$url = "/bbs/html/".g_dir_from_id($id).$id.".html";
	$str_ls .= "<LI><A href=\"".$url."\" target=\"_blank\" title=\"".$title_more."\">".$title."&nbsp;</A></LI>";
}
$m_js .= "document.write('".$str_ls."');\n";
$m_js .= "document.write('</UL>');\n";
//$m_js .= "</script>";
//var_dump($m_js);
echo $m_js;
exit();

function js_empty()
{
	//未登录输出
	return "";
}
/*
function dir_from_id($id = 0)
{
	//根据文章ID求出文章所在静态上级目录　
	//输入:id(int)文章ID
	//输出:目录字符串,异常返回空字符串
	$num = 2000; //2000个文件一个目录　
	return strval((intval(($id-1)/$num)+1)*$num)."/"; 
}
*/
?>