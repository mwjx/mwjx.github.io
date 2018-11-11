<?php
//------------------------------
//create time:2008-1-18
//creater:zll,liang_0735@21cn.com
//purpose:更新追踪
//------------------------------
if("" == $_COOKIE['username']){
	exit("无权限");
}
exit();
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
//$m_id = 581; //572
//$m_html = "";

function html_lists()
{
	//小说类目列表
	//输入:无
	//输出:html字符串
	//$obj = new c_class_info($id);
	//if($obj->get_id() < 1)
	//	return "";
	//$arr = $obj->son_link_class();
	$html = "";
	$sou = arr_sou();
	$arrc = arr_class();
	//var_dump($arrc);
	//exit();
	$ls = "";
	/*foreach($sou as $row){
		$len = count($row);
		for($i = 0;$i < $len; ++$i){
			if("" != $ls)
				$ls .= ",";
			$ls .= $row[$i][0];
		}
	}
	*/
	$js_ls = "<script language=\"javascript\">\n"; //来源ID列表,js数组
	$js_ls .= "var m_arr_name = Array();\n";
	foreach($sou as $cid=>$row){
		//$cid = intval($arr[$i][0]);
		if(!isset($arrc[$cid]))
			continue;
		$title = $arrc[$cid];
		$html .= "<dl id=\"dl_".$cid."\" class=\"dl_book\">";
		$html .= "<dt><a href=\"/data/".$cid.".html\" target=\"_blank\">".$title."</a></dt>";
		$html .= "<dd><ul>";
		$len = count($row);
		for($i = 0;$i < $len; ++$i){
			$id = $row[$i][0];
			$js_ls .= "m_arr_name['".$id."'] = Array('".$title."','".$cid."');\n";
			if("" != $ls)
				$ls .= ",";
			$ls .= $id;

			$html .= "<li><a href=\"".$row[$i][2]."\" target=\"_blank\">".$row[$i][1]."</a><img src=\"../images/delete.gif\" alt=\"清空此来路，清除记录及文件\" style=\"cursor:hand;\" onclick=\"javascript:rm_sou('".$id."');\"/>&nbsp;<span id=\"spn_new_".$id."\"></span><span id=\"spn_load_".$id."\"></span></li>";
		}
		$html .= "</ul></dd>";
		$html .= "</dl>";
	}
	/*$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$cid = intval($arr[$i][0]);
		$title = $arr[$i][1];
		$html .= "<dl class=\"dl_book\">";
		$html .= "<dt><a href=\"/data/".$cid.".html\" target=\"_blank\">".$title."</a></dt>";
		$html .= "<dd><ul>";
		if(isset($sou[$cid])){
			$len2 = count($sou[$cid]);
			for($j = 0;$j < $len2; ++$j){
				$id = $sou[$cid][$j][0];
				if("" != $ls)
					$ls .= ",";
				$ls .= $id;

				$html .= "<li><a href=\"".$sou[$cid][$j][2]."\" target=\"_blank\">".$sou[$cid][$j][1]."</a>&nbsp;<span id=\"spn_new_".$id."\"></span><span id=\"spn_load_".$id."\"></span></li>";
			}
		}
		$html .= "</ul></dd>";
		$html .= "</dl>";

	}
	*/
	$js_ls .= "var m_arr_ls = Array(".$ls.");\n";
	$js_ls .= "</script>\n";
	return $js_ls."<DIV id=\"div_main\">".$html."</DIV>";
}
function arr_class()
{
	$re = array();
	$str_sql = "select id,name from class_info;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$name = $arr[$i]["name"];
		$re[$id] = $name;
	}
	return $re;
}
function arr_sou()
{
	//来源数组
	//输入:无
	//输出:数组，格式：cid=>array(array(id,title,url));
	$re = array();
	$str_sql = "select * from update_track;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$cid = intval($arr[$i]["cid"]);
		$title = $arr[$i]["title"];
		$url = $arr[$i]["url"];
		if(!isset($re[$cid]))
			$re[$cid] = array();
		$re[$cid][] = array($id,$title,$url);
	}
	return $re;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 管理 </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<STYLE type="text/css">
#c_lists{
	float:left;
	margin-left:10px;
	width:234px;
	height:592px;
	overflow:hidden;
	background-color:red;/**/
}
#c_info{
	float:left;
	margin-left:0px;
	width:424px;
	height:150px;
	overflow:hidden;
	background-color:blue;/**/
}
#c_allinfo{
	float:left;
	margin-left:0px;
	width:424px;
	height:550px;
	overflow:hidden;
	background-color:blue;/**/
}
#c_action{
	float:left;
	margin-left:0px;
	width:424px;
	height:40px;
	overflow:hidden;
	background-color:green;/**/
}
DIV {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; BORDER-LEFT: 0px; PADDING-TOP: 0px; BORDER-BOTTOM: 0px; TEXT-ALIGN: left;FONT-SIZE: 13px;
}
UL {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; BORDER-LEFT: 0px; PADDING-TOP: 0px; BORDER-BOTTOM: 0px; 
	TEXT-ALIGN: left;
}

.div_yt{
	/*车型用途*/
	float:left;
	width:180px;
	/*height:300px;*/
	overflow:hidden;
	/*background-color:red;*/
}
.div_yt ul li{
	FONT-SIZE: 13px;
	margin-left:0px;
	margin-right:0x;
	padding-left:5px;
	float:left;
	width:160px;
	white-space:nowrap;
	line-height:15px;
	overflow:hidden;
	/*background:url(/mwjx/images/bussniess/secondhandwindow_hit.gif) 0 4px no-repeat;*/
}
.spn_price{
	width:80px;
	background-color:block;/**/
	LINE-HEIGHT:100%; padding:6px 8px 6px 8px;   border:1px solid #CCCCEE; background:#EEEEFF;
	white-space:nowrap;
	overflow:hidden;
}
.spn_name{
	width:80px;
	background-color:block;/**/
	LINE-HEIGHT:100%; padding:6px 8px 6px 8px;   border:1px solid #CCCCEE; background:#EEEEFF;
	white-space:nowrap;
	overflow:hidden;

}
.dl_book {
	float:left;
	margin-left:10px;
	position:relative;
	width:235px;
	height:100px;
	overflow:hidden;
	background:#EEEEFF;
	padding:6px 8px 6px 8px;   border:1px solid #CCCCEE;
}

.dl_book dt{
	margin:0 1px;
	padding-left:1px;
	width:100%;
	height:20px;
	line-height:20px;
	text-align:center;
	overflow:hidden;
	cursor:pointer;
	color:#797979;
}
.dl_book dt.hover{font-weight:700;color:#E051A3;}
.dl_book dd ul li {line-height:19px;}
.dl_book dd ul li a {color:#5A5A5A;}
.dl_book dd ul li a:hover {color:#FF5500;}
/*#HeadLines dl dd {
	position:absolute;
	top:0;
	left:37px;
	display:none;
	margin:0;
	padding:3px 8px;
	height:120px;
	width:190px;
	overflow:auto;
	background:#fff url(/mwjx/images/bussniess/fp_info_bk.gif) no-repeat -77px -20px;
}
*/
</STYLE>
<style>
<!--
	body {font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; }

	a:link { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:visited { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:active { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:hover { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #FF0000; font-weight: normal; text-decoration: none; }

	.spnFieldHeader {width:80px;text-align:right}
	.spnButton {border:1px solid #003C74;cursor:hand;font-size:10pt;color:#3E3F41;background:#CDCCDF;padding:3px;line-height:30px;}

	#content {width:100%}
	#content #leftContent {font-size:10pt;width:70%}
	#content #rightContent {font-size:10pt;width:30%}

	#pageBar {width:100%};
	#pageBar .pageBarContent {font-size:10pt;}
	#pageBar .pageBarContent span{};
	#PageBar .pageBarContent .curPageNum{font-size:11pt;color:blue}


	.spnLeftContentTitle {font-family: Verdana, Arial, sans-serif; font-size: 18px; color: #727272; font-weight: bold; }
	.spnRightContentTitle {background-color: #C9C9C9;font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #ffffff; font-weight: bold;}

	.trHeadingRow{background-color: #C9C9C9;}
	.tdHeadingFields {font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #ffffff; font-weight: bold;}

	.dataTableRow { background-color: #F0F1F1; }
	.dataTableRowSelected { background-color: #DEE4E8; }
	.dataTableRowOver { background-color: #FFFFFF; cursor: pointer; cursor: hand; }
	.dataTableContent { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; }

	.infoBoxHeading { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #ffffff; background-color: #B3BAC5; font-weight: bold;}
	.infoBoxContent { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; background-color: #DEE4E8; }
-->
</style>
<script language="javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
var m_index = 0; //当前检查的来源页下标
var dochttp = null; //http对象
var m_timeid = null;
function go_page(str)
{
	//跳转页面查询
	//输入:str(string)查询关分键词
	//输出:无
	document.all["tbl_detail"].style.display = "none";
	var url = "./car_list.php?str="+str;
	document.location.href = url;
	//alert(str);
}
function rm_sou(sid)
{
	//清除来路
	//输入:sid(string)来路ID
	//输出:无
	//alert(sid);
	document.all["frm_action"]["fun"].value = "rm_sou";
	document.all["frm_action"]["sid"].value = sid;
	document.all["frm_action"].submit();

}
function check_new()
{
	//检查一个来源页是否有新章节
	//输入:无
	//输出:无
	//上一个
	window.clearTimeout(m_timeid);
	var pre = m_index -1;
	if(pre < 0)
		pre = m_arr_ls.length -1;
	var preid = m_arr_ls[pre];
	document.all["spn_load_"+preid].innerHTML = "";
	document.all["spn_load_"+preid].parentNode.style.color = "#000000";
	/**/
	//m_index
	//<img src=\"/mwjx/image/new.gif\"/>
	//document.all["spn_load_"+preid].parent.class = "li_bgnomal";
	//alert(document.all["spn_load_"+preid].parentNode.style.color);
	//return;
	//当前
	var id = m_arr_ls[m_index];
	var title = "("+id+"/"+m_arr_name.length+")"+m_arr_name[id][0];
	document.all["spn_title"].innerText = title;
	//return; // alert(id);
	document.all["spn_load_"+id].innerHTML = "<img src=\"../image/loading.gif\"/>";	
	document.all["spn_load_"+id].parentNode.style.color = "red";
	//请求
	//dochttp
	//alert("ee");
	//return;
	//throw(new Error("aa"));
	var url = './track_if.php?sid='+id;
	//window.status = "fff";
	//return;
	//throw(new Error("aa"));
	//dochttp = new_xmlhttp();
	//alert(url);
	//return;
	document.all["spn_new_"+id].innerHTML = "";//dochttp.responseText;	
	//try{
	dochttp.Open("GET",url,true);
	dochttp.Send(null);
	dochttp.onreadystatechange = deal_response;
	//}
	//catch(err){
	//	alert(err.message);
	//}
	/*
	if("Y" != dochttp.responseText){
		document.all["spn_new_"+id].innerHTML = "";
		//document.all["spn_new_"+id].innerHTML = url+"("+dochttp.responseText+")";	
		return;
	}
	//有新章节
	document.all["spn_new_"+id].innerHTML = "<a href=\"./track_sou.php?sid="+id+"\" target=\"_blank\"><img src=\"../image/new.gif\" border=\"0\"/></a>";	
	*/
	//document.all["spn_new_"+id].innerHTML = url+"("+dochttp.responseText+")"+"<a href=\"./track_sou.php?sid="+id+"\" target=\"_blank\"><img src=\"../image/new.gif\" border=\"0\"/></a>";	
	
}
function init()
{
	//初始
	//输入:无
	//输出:无
	
	if(m_arr_ls.length < 1)
		return;
	dochttp = new_xmlhttp();
	//dochttp new XMLHttpRequest();
	//dochttp = new XMLHttpRequest();
	//alert("fffff");
	//check_new();
	//window.setInterval("check_new();",3000);
	m_timeid = window.setTimeout("check_new();",1000);
	//check_new();
	/**/
	//alert("aaa");
}
function deal_response()
{
	//回复处理
	//输入:无
	//输出:无
	//window.clearTimeout(m_timeid);
	//m_timeid = window.setTimeout("check_new();",1000);
	//alert(dochttp.responseText);
	//return;
	if(4 != dochttp.readyState)
		return;
	if(dochttp.status != 200)
		return;
	try{
		//alert(this.xmlhttp.responseText);
		if("" == dochttp.responseText || null == dochttp.responseText || ("undifined" == typeof(dochttp.responseText)))
			return;
	}
	catch(err){
		m_timeid = window.setTimeout("check_new();",200);
		return; // alert(err.message);
	}

	//当前
	var id = m_arr_ls[m_index];
	if(null == m_arr_ls[++m_index])
		m_index = 0;
	//document.all["spn_load_"+id].innerHTML = "";
	//alert(id);
	//alert(dochttp.responseText);
	//document.all["spn_new_"+id].innerHTML = "";
	//return;
	//check_new();
	m_timeid = window.setTimeout("check_new();",500);
	if("Y" != dochttp.responseText){
		document.all["spn_new_"+id].innerHTML = "";
		//document.all["spn_new_"+id].innerHTML = url+"("+dochttp.responseText+")";	
		return;
	}
	//有新章节
	document.all["spn_new_"+id].innerHTML = "<a href=\"./track_sou.php?sid="+id+"\" target=\"_blank\"><img src=\"../image/new.gif\" border=\"0\"/></a>";	

	//移到前面
	//var oDiv=document.createElement("DIV");
	//document.body.appendChild(oDiv);
	//dl_170
	//div_main
	var cid = m_arr_name[id][1];
	//if("2" != id)
	//	return;
	//alert("ff");
	var obj = document.getElementById("dl_"+cid);
	var first = document.all["div_main"].firstChild;
	document.all["div_main"].insertBefore(obj,first);
}
window.onload   =   function()
{
	init();
	//alert("onload()");
} 

</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff">

<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top">
<a href="./track_add.php" target="_blank">添加来源</a>
&nbsp;&nbsp;<span id="spn_title" style="widt:200px;font-size:9pt;">标题</span>		</td>
	</tr>
	<tr>
		<td valign="top">
<?php
//echo $m_html;
echo html_lists();
?>
		</td>
	</tr>
<table>

<!--提交表单//-->
<form method="POST" name="frm_action" action="../cmd.php" target="submitframe" accept-charset="GBK">
<input type="hidden" name="fun" value=""/>
<input type="hidden" name="sid" value=""/>
</form>

<iframe name="submitframe" width="1" height="1"></iframe>
</BODY>
</HTML>
