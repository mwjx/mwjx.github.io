<?php
//------------------------------
//create time:2010-4-24
//creater:zll,liang_0735@21cn.com
//purpose:藏书管理
//------------------------------
if("" == $_COOKIE['username']){
	exit("无权限");
}
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/track.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/mybook.php");
//$m_id = 581; //572
//$m_html = "";

function html_lists()
{
	//小说类目列表
	//输入:无
	//输出:html字符串
	$html = "";
	$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
	$obj_mb = new c_mybook;
	$bkls = $obj_mb->ls_book($obj_man->get_id(),2);
	$sou = arr_sou();
	$arrc = arr_class();
	//var_dump($arrc);
	//exit();
	$ls = "";
	$js_ls = "<script language=\"javascript\">\n"; //来源ID列表,js数组
	$js_ls .= "var m_arr_name = Array();\n";
	//$js_sou .= "var m_arr_sou = Array();\n";
	
	foreach($sou as $cid=>$row){
		//$cid = intval($arr[$i][0]);
		if(!isset($arrc[$cid]))
			continue;
		$title = $arrc[$cid];
		$len = count($row);
		for($i = 0;$i < $len; ++$i){
			$id = $row[$i][0];
			if("" != $ls)
				$ls .= ",";
			$ls .= $id;
		}
	}
	/**/
	$js_ls .= "var m_arr_ls = Array(".$ls.");\n";
	//来源站点列表
	$arr = arr_track_flag();
	$js_ls .= "var m_arr_sou = Array();\n";
	foreach($arr as $id=>$name){
		$js_ls .= "m_arr_sou['".$id."'] = '".$name."';\n";
	}
	//藏书列表
	$js_ls .= "var m_bookls = [];\n";
	for($i = 0;$i < count($bkls);++$i){
		$flag = intval($bkls[$i][2]);
		//if(2 == $i)
		//	$flag = 1;
		$js_ls .= "m_bookls[m_bookls.length] = [".$bkls[$i][0].",'".$bkls[$i][1]."',".$flag.",".$bkls[$i][3]."];\n";
	}
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
function count_sou()
{
	//作品数
	//输入:无
	//输出:整形数量
	$str_sql = "select count(*) from update_track;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	return intval($arr[0][0]);
}
function arr_sou()
{
	//来源数组
	//输入:无
	//输出:数组，格式：cid=>array(array(id,title,url,flag));
	$re = array();
	$str_sql = "select * from update_track;";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$cid = intval($arr[$i]["cid"]);
		$title = $arr[$i]["title"];
		$url = $arr[$i]["url"];
		$flag = $arr[$i]["flag"];
		if(!isset($re[$cid]))
			$re[$cid] = array();
		$re[$cid][] = array($id,$title,$url,$flag);
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
var m_xmldom = null; //xmldom对象
var m_timeid = null;
var m_arr_tianya = Array();
var m_arr_new = Array(); //当前更新来源ID
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
	//window.clearTimeout(m_timeid);
	document.all["spn_title"].innerHTML = "<img src=\"../image/loading.gif\"/>";
	//return; // alert(id);
		
	//请求
	var url = './track_ifv2.php';
	//window.status = "fff";
	//return;
	//throw(new Error("aa"));
	//dochttp = new_xmlhttp();
	//alert(url);
	//return;
	//document.all["spn_new_"+id].innerHTML = "";//dochttp.responseText;	
	//try{
	//dochttp.Open("GET",url,true);
	//dochttp.Send(null);
	dochttp.open("GET",url,true);
	dochttp.send(null);
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
	//提取出天涯分页
	/*var id = "";
	for(var i = m_index;i < m_arr_ls.length; ++i){
		id = String(m_arr_ls[i]);
		if(null == m_arr_name[id])
			continue;
		if("8" != m_arr_name[id][3])
			continue;
		m_arr_tianya[m_arr_tianya.length] = id;
	}
	*/
	//return check_newtianya();
	//return alert(m_arr_ls.length);
	init_ls();
	//return;
	if(m_arr_ls.length < 1)
		return;
	dochttp = new_xmlhttp();
	m_xmldom = new_xmldom();
	//dochttp new XMLHttpRequest();
	//dochttp = new XMLHttpRequest();
	//alert("fffff");
	check_new();
	window.setInterval("check_new();",60000);
	//window.setInterval("check_newtianya();",120000);
	//m_timeid = window.setTimeout("check_new();",60000);
	//check_new();
	/**/
	//alert("aaa");
}
function check_newtianya()
{
	//天涯分页预处理
	//输入:无
	//输出:无
	if(m_arr_tianya.length < 1)
		return;
	//return alert(m_arr_tianya);
	var id = m_arr_tianya[m_index];
	var url = './track_ifv2.php?sid='+id;
	dochttp.Open("GET",url,true);
	dochttp.Send(null);
	//dochttp.onreadystatechange = deal_response;
	//next
	//return alert();
	m_index += 1;
	if(null == m_arr_tianya[m_index])
		m_index = 0;
}
function init_ls()
{
	//展示藏书列表
	//输入:无，m_bookls
	//输出:无，写页面
	var html = "",site,surl,cid,id,ctitle,newflag;
	for(var i=0;i < m_bookls.length;++i){
		id = m_bookls[i][0];
		ctitle = m_bookls[i][1];
		newflag = m_bookls[i][2];
		cid = m_bookls[i][3];

		//ctitle = arrc[cid][0];

		html += "<dl id=\"dl_"+cid+"\" class=\"dl_book\"><dt><a href=\"/site838/view/mybook.php?id="+id+"&t=m\" target=\"_blank\">"+cid+":"+ctitle+"</a></dt><dd><ul>";
//		for(var i = 0;i < arrc[cid][1].length;++i){
//			//return alert(arrc[cid]);
//			sid = arrc[cid][1][i][0];
//			surl = m_arr_name[sid][2];
//			site = m_arr_name[sid][3];
//			stitle = "";
//			if(null != m_arr_sou[site])
//				stitle = m_arr_sou[site];
//			html += "<li><a href=\""+surl+"\" target=\"_blank\">"+stitle+"</a>&nbsp;<span id=\"spn_new_"+sid+"\"><a href=\"../src_php/track_sou.php?sid="+sid+"\" target=\"_blank\"><img src=\"../image/new.gif\" border=\"0\"/></a></span><span id=\"spn_load_"+sid+"\"></span></li>";
//		}
		html += "</ul></dd></dl>\n";	
	}
	document.all["div_main"].innerHTML = html;

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
		//m_timeid = window.setTimeout("check_new();",200);
		return; // alert(err.message);
	}

	//当前
	var ls = dochttp.responseText;
	//alert(ls);
	if("" == ls){
		document.all["div_main"].innerHTML = "";
		return;
	}
	var arr = ls.split(",");
	var arrc = Array(); //cid=>array(title,array(sid,title))
	var sid,cid,ctitle,stitle,count = 0;
	//求信息
	var ls_get = "";
	for(var i = 0;i < arr.length; ++i){
		//alert(m_arr_name);
		sid = arr[i];
		if(null != m_arr_name[sid])
			continue;
		if(i > 150)
			break; //太多可能出错，分开
		if("" != ls_get)
			ls_get += ",";
		ls_get += sid;
	}
	if("" != ls_get){
		//alert("ls_get:"+ls_get);
		var url = "./data_trackinfo.php?ls="+ls_get;
		//alert(url);
		
		m_xmldom.async=false;
		m_xmldom.load(url);
		//var nodes=m_xmldom.documentElement.childNodes;
		var nodes = m_xmldom.getElementsByTagName("row");
		//alert(m_xmldom.documentElement.childNodes[0].nodeValue);
		//alert("len="+nodes.length);
		var id,cid,site,title,url;
		//var lsname="";
		for(var i = 0;i < nodes.length;++i){
			//alert(nodes[i].childNodes[0].childNodes[0].nodeValue);
			if(nodes[i].childNodes.length < 5)
				break;
			id = nodes[i].childNodes[0].childNodes[0].nodeValue;
			//lsname += id+",";
			//alert(id);
			//break;
			cid = nodes[i].childNodes[1].childNodes[0].nodeValue;
			site = nodes[i].childNodes[2].childNodes[0].nodeValue;
			title = nodes[i].childNodes[3].childNodes[0].nodeValue;
			url = nodes[i].childNodes[4].childNodes[0].nodeValue;
			m_arr_name[id] = [title,cid,url,site];
			//alert(id+","+cid+","+title);
			//alert(m_arr_name[id]);
			//break;
		}
		//alert(ls_get+"\n"+lsname);
		//alert(m_arr_name[id]);
	}

	m_arr_new = Array();
	//alert(arr);
	for(var i = 0;i < arr.length; ++i){
		sid = arr[i];
		if(null == m_arr_name[sid])
			continue;
		cid = m_arr_name[sid][1]; //m_arr_name[sid][1];
		//return alert(cid);
		ctitle = m_arr_name[sid][0];
		//return alert(m_arr_name[sid][0]);
		
		stitle = sid;
		if(null == arrc[cid])
			arrc[cid] = [ctitle,[]];
		arrc[cid][1][arrc[cid][1].length] = [sid,stitle];
		//return alert(arrc[cid][1]);
		++count;
		m_arr_new[m_arr_new.length] = sid;
	}
	document.all["spn_title"].innerHTML = "有 "+count+"　部作品等待更新入库";
	//return alert(arrc); 
	var html = "",site,surl,o=null;
	for(var cid in arrc){
		ctitle = arrc[cid][0];

		//html += "<dl id=\"dl_"+cid+"\" class=\"dl_book\"><dt><a href=\"/data/"+cid+".html\" target=\"_blank\">"+cid+":"+ctitle+"</a></dt><dd><ul>";
		//alert(cid);
		//break;
		o = document.getElementById("dl_"+cid);
		if(!o)
			continue;
		html = "";
		for(var i = 0;i < arrc[cid][1].length;++i){
			//return alert(arrc[cid]);
			sid = arrc[cid][1][i][0];
			surl = m_arr_name[sid][2];
			site = m_arr_name[sid][3];
			stitle = "";
			if(null != m_arr_sou[site])
				stitle = m_arr_sou[site];
			html += "<li><a href=\""+surl+"\" target=\"_blank\">"+stitle+"</a>&nbsp;<span id=\"spn_new_"+sid+"\"><a href=\"../src_php/track_sou.php?sid="+sid+"\" target=\"_blank\"><img src=\"../image/new.gif\" border=\"0\"/></a></span><span id=\"spn_load_"+sid+"\"></span></li>";
		}
		//if("" != html)
		//	alert(html);
		o.childNodes[1].childNodes[0].innerHTML = html;
		//html += "</ul></dd></dl>\n";	
	}
	//document.all["div_main"].innerHTML = html;
}
function open_new(flag)
{
	//打开全部更新来源窗口
	//输入:flag(int)1顺序/2倒序
	//输出:无
	if(m_arr_new.length < 1)
		return;
	var arr_c = Array(); //cid=>sid
	var id,cid;
	if(1 == flag){
		for(var i = 0;i < m_arr_new.length; ++i){
			if(i > 32)
				break;
			id = m_arr_new[i];
			if(null == m_arr_name[id])
				return alert("来源无类目："+id);
			cid = m_arr_name[id][1];
			if(cid < 1)
				return alert("来源类目无效,id="+id+",cid="+cid);
			if(null == arr_c[cid]) //同一类目只打开一个
				arr_c[cid] = id;
			else
				continue;
			window.open("../src_php/track_sou.php?sid="+id);
		}
		return;
	}
	//flag=2倒序
	var end = m_arr_new.length - 1;
	var count = 0;
	for(var i = end;i >= 0; --i){
		if(++count > 32)
			break;
		id = m_arr_new[i];
		if(null == m_arr_name[id])
			return alert("来源无类目："+id);
		cid = m_arr_name[id][1];
		if(null == arr_c[cid]) //同一类目只打开一个
			arr_c[cid] = id;
		else
			continue;
		window.open("../src_php/track_sou.php?sid="+id);
	}
	return;
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

<a href="./track_preparatory.php" target="_blank">添加新书</a>
&nbsp;&nbsp;<a href="#" target="_self" onclick="javascript:open_new(1);">打开全部更新</a>
&nbsp;&nbsp;<a href="#" target="_self" onclick="javascript:open_new(2);">打开全部更新(倒序)</a>
&nbsp;&nbsp;
<a href="./pass_add.php" target="_blank">过滤条件</a>
&nbsp;&nbsp;
<a href="../src_php/track_add.php" target="_blank">添加来源</a>
&nbsp;&nbsp;
<a href="./class_kw.php" target="_blank">类目关键词</a>
&nbsp;&nbsp;<span  style="widt:200px;font-size:9pt;">共有作品　<?=count_sou();?>　部</span>&nbsp;&nbsp;<span id="spn_title" style="widt:200px;font-size:9pt;">标题</span>		</td>
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
