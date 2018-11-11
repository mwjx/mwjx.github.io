<?php
//------------------------------
//create time:2008-5-15
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:提取页面内容规则调试
//------------------------------
/*$txt  = "<div id=\"content\"><div class=\"divimage\"><img src=\"http://www.huaxiazw.com/bbs/files/article/attachment/67/67040/941633/701829.gif\" border=\"0\" class=\"imagecontent\" alt=\"调教初唐 第649章 鸡冠头\"></div><div class=\"divimage\"><img src=\"http://www.huaxiazw.com/bbs/files/article/attachment/67/67040/941633/701830.gif\" border=\"0\" class=\"imagecontent\" alt=\"调教初唐 第649章 鸡冠头\"></div></div>


<span id='banner_1'>
";
$line = stripslashes("preg_replace`|/<img(.*?)src=\"(.*?)\"(.*?)>/is`|[img width=540]\\2[/img]\r\n");
$row = explode("`|",$line);
$a = $row[1]; //"/<img(.*?)src=\"(.*?)\"(.*?)>/is";
$b = $row[2]; //"[img width=540]\\2[/img]\r\n";
$txt = preg_replace($a,$b,$txt);
var_dump($txt);
exit();
*/
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/track.php");
my_safe_include("mwjx/rules.php");
my_safe_include("class_man.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(200200067 != $obj_man->get_id())
	exit("无权限");
$m_file = isset($_GET["file"])?$_GET["file"]:""; //文件
$m_site = intval(isset($_GET["site"])?$_GET["site"]:-1);
$m_t = intval(isset($_GET["t"])?$_GET["t"]:-1); //规则类型

//--------tests----------
/*$m_file = "1/00ea73179364858f1608955550083b07.html";
$m_site = 1;
$m_t = 27;
*/

if($m_site < 1 || $m_t < 1 || "" == $m_file)
	exit("参数无效");
echo "目录：data/update_track/[search/]"."<br/>\n";
echo "site=".$m_site.",m_t=".$m_t.",file=".$m_file."<br/>\n";
//$path = "../../../data/update_track/";
$str_dir = get_dir_home();
$dir = $str_dir."../data/update_track/";		
$path = $dir; 
$path .= $m_file;
$url = $m_file;
if(27 == $m_t || 28 == $m_t || 47 == $m_t || 48 == $m_t){
	my_safe_include("mwjx/search_source.php");
	my_safe_include("mwjx/rules.php");
	$t = 21;
	if(47 == $m_t || 48 == $m_t)
		$t = 41;
	$obj = new c_search_source($m_site,true,$dir,$t);
	if(27 == $m_t || 28 == $m_t)
		$path = $dir."search/".$m_file;
	else
		$path = $dir."newbook/".$m_file;
	//exit($path);
	$obj->deal_file($path);
	exit();
}
$id = (11==$m_t)?"title":((12==$m_t)?"content":"author");
//$obj = new c_html(readfromfile($path),$m_site,true);
$html = readurl($url);
//var_dump(strlen($html));
//exit();
$obj = new c_html($html,$m_site,true);
$obj->txt_div($id);

?>