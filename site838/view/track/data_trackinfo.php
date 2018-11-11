<?php
//------------------------------
//create time:2008-6-20
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:来源信息
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/track.php");
$m_ls = (isset($_GET["ls"])?$_GET["ls"]:""); //来源ID列表,形如:1,2,3
//tests
//$m_ls = "147,148,149,150"; //tests
//echo "ff";
//writetofile("../../../html/xxx.txt",$m_ls);
$m_lists = (arr_info($m_ls));
//var_dump($m_lists);
//exit();
$str_xml = "";
$str_xml .= "<?xml version=\"1.0\" encoding=\"gb2312\" ?><lists>";
$len = count($m_lists);
$m_arrflag = arr_track_flag(); //flag=>title
for($i=0;$i < $len; ++$i){
	$id = $m_lists[$i]["id"];
	$cid = $m_lists[$i]["cid"];
	$site = $m_lists[$i]["flag"];
	$title = $m_lists[$i]["name"];
	$url = ($m_lists[$i]["url"]);
	$str_xml .= "<row><id>".$id."</id><cid>".$cid."</cid><site>".$site."</site><title> ".htmlspecialchars($title)." </title><url>".htmlspecialchars($url)."</url></row>\n";
}
$str_xml .= "</lists>";
function arr_info($ls="")
{
	//列表
	//输入:ls来源ID列表,形如:"1,2,3"
	//输出:数组array(id,cid,c_title(name),site(flag),url)
	if("" == $ls)
		return array();
	$str_sql = "select UT.id,UT.cid,UT.flag,UT.url,CI.name from update_track UT left join class_info CI on UT.cid=CI.id where UT.id in (".$ls.");";
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
