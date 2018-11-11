<?php
//------------------------------
//create time:2008-4-25
//creater:zll
//purpose:今日统计
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$m_site = isset($_GET["site"])?$_GET["site"]:"fish838";
//没有章节的不要显示
$str_sql = "select count(*) from class_info;";		
//exit($str_sql);
$sql = new mysql("fish838");
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();			
$all = intval($arr[0][0]);

$dtt = date("Y-m-d 00:00:00",time());
$str_sql = "select count(*) from article where last > '".$dtt."';";	
$sql = new mysql("fish838");
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();			
$today = intval($arr[0][0]);

$str_sql = "select A.cid,C.name,count(A.id) as num from article A left join class_info C on A.cid = C.id where A.last > '".date("Y-m-d",time()-2*86400)."' group by A.cid order by num DESC limit 30;";
//exit($str_sql);
$sql=new mysql("fish838");
$sql->query($str_sql);
$sql->close();				
$arr = $sql->get_array_array();		
//形成字符串
//<H3>今日统计</H3><P>本站共有小说&nbsp;<a href=\"/bbs/html/index.html\" target=\"_blank\"><b>".$all."</b></a>&nbsp;部&nbsp;&nbsp;&nbsp;&nbsp;今日更新章节&nbsp;<a href=\"/site838/view/src_php/data_class.php?type=search&str=posteqtoday&page=1&per=20&show_type=dynamic\" target=\"_blank\"><b>".$today."</b></a>&nbsp;篇</P>".$this->html_lastclass()."
$m_js = "";
$m_js .= "document.write('<H3>今日统计</H3><P>本站共有小说&nbsp;<a href=\"/bbs/html/index.html\" target=\"_blank\"><b>".$all."</b></a>&nbsp;部&nbsp;&nbsp;&nbsp;&nbsp;今日更新章节&nbsp;<a href=\"/site838/view/src_php/data_class.php?type=search&str=posteqtoday&page=1&per=20&show_type=dynamic\" target=\"_blank\"><b>".$today."</b></a>&nbsp;篇</P>');\n";

$html = "";
$html .= "<DIV id=\"lastclass\"><UL>";
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	$cid = intval($arr[$i][0]);
	$num = intval($arr[$i][2]);
	$title = "（".$num."）".$arr[$i][1];
	$url = id2url_dynamic($cid,$m_site);
	$html .= "<LI><A href=\"".$url."\" target=_blank title=\"".$title."\">".$title."</A></LI>";
}
$html .= "</UL></DIV>";
$m_js .= "document.write('".$html."');\n";
//$m_js .= "document.write('</UL>');\n";
//$m_js .= "</script>";
//var_dump($m_js);
echo $m_js;
exit();

function id2url_dynamic($id=-1,$site="fish838")
{
	//得到地址
	//输入:id类目ID
	//输出:url字符串
	if("mwjx" == $site){
		return "http://book.mwjx.com/site838/view/track/index.php?id=".$id;
	}
	return "http://www.fish838.com/site838/view/track/index.php?id=".$id;
}
?>