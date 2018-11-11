<?php
//------------------------------
//create time:2008-4-23
//creater:zll
//purpose:最新入库
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$m_site = isset($_GET["site"])?$_GET["site"]:"fish838";
$num = 16;
//没有章节的不要显示
$str_sql = "select I.* from class_info I inner join article A on I.id = A.cid group by A.cid order by I.id DESC limit ".$num.";";
//exit($str_sql);
$sql = new mysql("fish838");
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();
//形成字符串
$m_js = "";
$m_js .= "document.write('<UL>');\n";

$ls = "";
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	$title = $arr[$i]["name"];
	//$url = "/data/".$arr[$i]["id"].".html";
	$id = intval($arr[$i]["id"]);
	//$url = $this->get_url_dynamic(-1,$id,7);
	if("mwjx" == $m_site){
		$url = "http://book.mwjx.com/site838/view/track/index.php?id=".$id;
	}
	else{
		$url = "http://www.fish838.com/site838/view/track/index.php?id=".$id;
	}
	$ls .= "<LI><A   href=\"".$url."\"   target=_blank>".$title."</A></LI>";
}

$m_js .= "document.write('".$ls."');\n";
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
?>