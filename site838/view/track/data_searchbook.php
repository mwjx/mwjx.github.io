<?php
//------------------------------
//create time:2008-5-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:搜索小说来源URL
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/track.php");
$m_kw = (isset($_GET["kw"])?$_GET["kw"]:""); //搜索关键词
//tests
//$m_kw = "男友"; //tests
//echo "ff";
$m_lists = (arr_info($m_kw));
//var_dump($m_lists);
//exit();
$str_xml = "";
$str_xml .= "<?xml version=\"1.0\" encoding=\"gb2312\" ?><lists>";
$len = count($m_lists);
$m_arrflag = arr_track_flag(); //flag=>title
for($i=0;$i < $len; ++$i){
	$id = $m_lists[$i][0];
	$title = $m_lists[$i][1];
	$site = intval($m_lists[$i][2]);
	$val = $m_lists[$i][3];
	//$url = val2url($site,$val);
	$sitename = "";
	if(isset($m_arrflag[$site]))
		$sitename = $m_arrflag[$site];
	$str_xml .= "<row><title>".htmlspecialchars($title)."</title><sitename>".htmlspecialchars($sitename)."</sitename><val>".htmlspecialchars($val)."</val><site>".$site."</site><id>".$id."</id></row>\n";
}
$str_xml .= "</lists>";
function arr_info($kw="")
{
	//列表
	//输入:kw关键词
	//输出:数组array(id,title,site,val)
	if("" == $kw)
		return array();
	//$str_sql = "select NL.id,N.title,NL.sou,NL.val from novels N left join novels_links NL on N.id=NL.novels where N.title like '%".$kw."%';";
	$str_sql = "select NL.id,N.title,NL.sou,NL.val from novels N left join novels_links NL on N.id=NL.novels left join novels_last LT on NL.id=LT.lid where N.title = '".$kw."' order by LT.last desc limit 50;";
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
