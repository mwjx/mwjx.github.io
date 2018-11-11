<?php
//------------------------------
//create time:2007-3-8
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:垃圾文章
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");  
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/interface.php");
$obj_face = new c_interface;
$arr = $obj_face->top(2,500);

$m_html = "被建议删除的文章<br/>";
$cid = 12;
foreach($arr as $row){
	$fid = $row[0];
	$url = "/mwjx/home.php?main=./src_php/data_article.php&id=".strval($fid)."&state=dynamic&r_cid=".strval($cid);
	$m_html .= ("[票:".strval($row[1])."]"." <a href=\"".$url."\" target=\"_blank\">".strval($row[2])."</a><br/>");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312"/>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<script type="text/javascript" src="../include/script/url.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
</script>
</HEAD>
<BODY>
</BODY>
<?php
echo $m_html;
?>
</HTML>
