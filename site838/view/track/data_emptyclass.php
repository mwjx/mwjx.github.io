<?php
//------------------------------
//create time:2008-6-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:空白类目
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/track.php");
//$m_kw = (isset($_GET["kw"])?$_GET["kw"]:""); //搜索关键词
//tests
//$m_kw = "男友"; //tests
//echo "ff";
$m_lists = (arr_info());
//var_dump($m_lists);
//exit();
$str_xml = "";
$str_xml .= "<?xml version=\"1.0\" encoding=\"gb2312\" ?><lists>";
$len = count($m_lists);
$m_arrflag = arr_track_flag(); //flag=>title
for($i=0;$i < $len; ++$i){
	$title = $m_lists[$i][0];
	$num = intval($m_lists[$i][1]);
	$str_xml .= "<row><title>".htmlspecialchars($title)."</title><num>".$num."</num></row>\n";
}
$str_xml .= "</lists>";
function arr_info()
{
	//列表
	//输入:kw关键词
	//输出:数组array(id,title,site,val)
	$str_sql = "select CI.name,count(A.id) as num from class_info CI left join article A on CI.id=A.cid group by CI.id order by num asc,CI.id DESC limit 10;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();

	return $arr;
}
?>
<?php
print_xml($str_xml);
?>
