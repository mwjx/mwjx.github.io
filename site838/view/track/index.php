<?php
//------------------------------
//create time:2010-12-26
//creater:zll,liang_0735@21cn.com
//purpose:小说索引
//------------------------------
if("" == $_COOKIE['username']){
	exit("未登录，返回<a href=\"http://www.fish838.com/site838/\">〈838阅读器〉</a>首页登录");
}
include("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/pagebase.php");
my_safe_include("mwjx/mybook.php");
my_safe_include("class_man.php");
require("../../key_fill/fd.php");
$fil = new fillter("../../key_fill/bw.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);
//$m_id = 168; //tests
$m_ctitle = ""; //书名
$m_author = ""; //作者
////跳转到静态页
//if("" == $_COOKIE['username']){
//	//exit("ff");
//	$dir_home = get_dir_home();
//	$dir_home = $dir_home."../html/";
//	$dir_root = "/html/";
//	$dir_s = substr(md5($m_id),0,3);
//	$dir_s = $dir_s."/".$m_id."/index.html";
//	//exit($dir_root.$dir_s);
//	if(file_exists($dir_home.$dir_s)){
//		header("location: ".$dir_root.$dir_s);
//		exit();
//	}
//}
$str_sql = "select * from class_info where id ='".$m_id."';";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$arr = $sql->get_array_array();
$sql->close();
if(1 != count($arr))
	exit("类目不存在");
$m_ctitle = $arr[0]["name"];
$m_author = $arr[0]["memo"];
//var_dump($m_arr);
//exit();
$html_top = "";
//$html_top = c_pagebase::html_headtop($m_id);
//$html_top .= c_pagebase::html_quick().c_pagebase::html_menu("",2,"",$m_ctitle);
//$html_top .= c_pagebase::html_quick().c_pagebase::html_menu("",2,"",$m_ctitle);
//-------------函数群-----------
function html_list($cid=-1)
{
	//索引列表
	//输入:cid类目ID
	//输出:html字符串
	//$db = "fish838";
	global $fil;
	//标记章节ID
	$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
	$obj_mb = new c_mybook;
	$aid = $obj_mb->get_flag($obj_man->get_id(),$cid);

	$str_sql = "select * from article where cid ='".$cid."' order by id asc limit 9999;"; //9999
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	$html = "<DIV id=\"div_articles\"><UL>";
	$len = count($arr);
	if($len < 1){
		return "<font color=\"red\">没找到章节内容，你可以点击底部的“管理本书”按钮进行手动更新</font>";
	}
	//可能是正在下载中，
	$line = 0;	
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$url = "/site838/view/track/show.php?id=".$arr[$i]["id"];
		$title = $arr[$i]["title"];
		$title = $fil->fill($title);
		$check = "";
		$ch_line = "";
		if(0 == $i%3){
			++$line;
			$ch_line = "<img src=\"/site838/view/image/bsall4.gif\" style=\"position:relative;left:0px;float:left;cursor:hand;\"  alt=\"选中本行\" onclick=\"javascript:ck_line(".$line.");\"/>&nbsp;";
		}
		$color = "";
		if($aid == $id)
			$color = "style=\"color:red;\"";
		$html .= "<LI title=\"".$title."\" >".$ch_line."&#149;<input id=\"ck_section_".$id."\" line=\"".$line."\" name=\"line_".$line."\" type=\"checkbox\" ".$check."/><a href=\"".$url."\" target=\"_blank\" ".$color.">".$title."</a></LI>";
	}
	$html .= "</UL></DIV>";
	return $html;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?=$m_ctitle;?>|《838书城》 - 打造绿色健康小说站点|www.fish838.com</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="评剑山庄&科幻迷城" name="description"/>
<META content="评剑山庄&科幻迷城,838书城,网文,幽默搞笑,军事,历史,www.fish838.com" name="keywords"/>
<META NAME="Author" CONTENT="mwjx,小鱼"/>
<STYLE type=text/css media=screen>
@import url("/site838/view/css/tb_1.css");
@import url("/site838/view/css/tb_2i.css");
@import url("/site838/view/css/class_dir.css");
.li_normal{
	background-color:#FFFFFF;
}
.li_red{
	background-color:#FFB6C1;
}
#div_articles{
	float:left;
	margin:0 0 0 0;
	width:100%;
	overflow:hidden;
	/*height:100%;*/
	line-height:150%;
	/*background-color:black;
	height:192px;
	*/
}
#div_articles ul li {
	float:left;
	margin-left:0px;
	position:relative;
	width:32%;
	height:18px;
	overflow:hidden;
	cursor:hand;
	/*background:#EEEEFF;*/
	padding:0px 0px 0px 8px;   border:1px solid #CCCCEE;
}
#div_articles ul li a:hover {color:green;}
#div_articles ul li a:visited {color:#5A5A5A;} 
.flagc {color:red;}
/*#div_articles ul li a {color:#5A5A5A;}
*/
</STYLE>
<META content="MSHTML 6.00.2900.2180" name=GENERATOR/>
<script type="text/javascript" src="/site838/view/include/script/cookie.js"></script>
<script language="javascript">
function check_confcode(str)
{
	//检查验证码是否填写
	//输入:str(string)验证码输入框名
	//输出:true已填,false未填写
	if("" == document.all[str].value){
		alert("请填写验证码");
		return false;
	}
	return true;
}
function check_all()
{
	//全选
	//输入:无
	//输出:无
	var arr = document.all;
	for(var i = 0;i < arr.length; ++i){
		if("INPUT" != arr[i].tagName)
			continue;
		if("undefined" == typeof(arr[i].id))
			continue;
		var name = arr[i].id;
		if(name.length < 12)
			continue;
		var str = name.substr(0,11);
		if("ck_section_" != str)
			continue;
		arr[i].checked = true;
	}

}
function check_anather()
{
	//反选
	//输入:无
	//输出:无
	var arr = document.all;
	var bln = null;
	for(var i = 0;i < arr.length; ++i){
		if("INPUT" != arr[i].tagName)
			continue;
		if("undefined" == typeof(arr[i].id))
			continue;
		var name = arr[i].id;
		if(name.length < 12)
			continue;
		var str = name.substr(0,11);
		if("ck_section_" != str)
			continue;
		if(arr[i].checked)
			bln = false;
		else 
			bln = true;
		arr[i].checked = bln;
		//if(true != arr[i].checked)
		//	continue;
	}

}

function ck_line(li)
{
	//选中一行
	//输入:li(int)行号
	//输出:无
	//alert(li);
	//alert();
	var obj = document.all["line_"+li];
	var len = obj.length;	
	if("undefined"==typeof(len)){
		if(obj.checked)
			obj.checked = false;
		else
			obj.checked = true;
		return;
	}
	if(len < 1){
		//alert("aa");
		return;
	}
	for(var i = 0;i < len; ++i){
		if(obj[i].checked)
			obj[i].checked = false;
		else
			obj[i].checked = true;
	}
}
function get_ls()
{
	//返回选中列表
	//输入:无
	//输出:列表字符串
	var arr = document.all;
	var num = 0;
	var result = Array();
	for(var i = 0;i < arr.length; ++i){
		if("INPUT" != arr[i].tagName)
			continue;
		if("undefined" == typeof(arr[i].id))
			continue;
		var name = arr[i].id;
		if(name.length < 12)
			continue;
		var str = name.substr(0,11);
		if("ck_section_" != str)
			continue;
		if(true != arr[i].checked)
			continue;
		var id = parseInt(name.substr(11),10);
		result[result.length] = id;

		++num;
	}
	if(result.length < 1)
		return "";
	var ls = "";
	for(var i = 0; i < result.length; ++i){
		if("" != ls)
			ls += ",";
		ls += result[i];
	}
	return ls;
}
function batch_del(cid)
{
	//删除文章
	//输入:cid类目ID
	//输出:无
	var username = get_cookie("username");
	if(null == username)
		return alert("本功能只有注册用户才能使用，请先注册/登录");
	var ls = get_ls();
	if("" == ls)
		return alert("请先选择要删除的章节");
	if(!window.confirm("本操作不可恢复，确实要删除吗？"))
		return;
	document.all["frm_action"].action = "../cmd.php";
	document.all["frm_action"]["fun"].value = "batch_del";
	document.all["frm_action"]["downtype"].value = "";
	document.all["frm_action"]["id_ls"].value = ls;	
	document.all["frm_action"]["cid"].value = cid;	
	document.all["frm_action"].submit();
}
function down_html(t)
{
	//下载合集
	//输入:t类型:downhtml/readhtml
	//输出:无
	var username = get_cookie("username");
	if(null == username)
		return alert("本功能只有注册用户才能使用，请先注册/登录");
	var ls = get_ls();
	if("" == ls)
		return alert("请先选择要下载或阅读的章节");
	document.all["frm_action"].action = "./down_txt.php";
	document.all["frm_action"]["fun"].value = "";
	document.all["frm_action"]["downtype"].value = t;
	document.all["frm_action"]["id_ls"].value = ls;	
	document.all["frm_action"].submit();
	//username = escape(username);
	//username = unescape(username);
	//alert(username);
}
function down_txt()
{
	//下载txt全文
	//输入:无
	//输出:无
	var username = get_cookie("username");
	if(null == username)
		return alert("本功能只有注册用户才能使用，请先注册/登录");
	var ls = get_ls();
	if("" == ls)
		return alert("下载失败，请先选择要下载的章节");
	document.all["frm_action"].action = "./down_txt.php";
	document.all["frm_action"]["fun"].value = "";
	document.all["frm_action"]["downtype"].value = "downtxt";
	document.all["frm_action"]["id_ls"].value = ls;
	document.all["frm_action"].submit();
	//return alert(get_ls());
}
function init()
{
	//alert('init');
	window.focus();
	window.scrollTo(0,document.body.scrollHeight); //竖向滚动条置底
}
</script>
</HEAD><BODY SCROLL="yes" style="MARGIN: 0px" onload="init();">
<!--<DIV id=Head>//-->
<?=$html_top;?>

<div id="title_ad" style="width:810px;height:60px;">
<table width="100%" border="0" cellPadding="0" cellSpacing="0" align="center" valign="top">
<tr height="60" align="center">
<td>
<table border="0"><tr>
<td width="100%" align="center" style="color:red;"><H1>《<a href="/site838/view/track/info.php?id=<?=$m_id;?>"><?=$m_ctitle;?></a>》</H1>
&nbsp;&nbsp;作者：<?=$m_author;?>
</td>
</tr></table>
</td>
</tr>
</table>
</div><!--end title_ad//-->
<DIV id=Content><A name=main></A>
<?=html_list($m_id);?>
<!--
//-->
</DIV>

<div style="display:block;text-align:right;float:left;width:810px;margin-left:0px;margin-top:0px;overflow:hidden;">
<UL style="width:90%;">
<LI class="bar_text"><A href="#" 
  target="_self" onclick="javascript:window.location.reload();">刷新本页</A></LI>
  <LI class="bar_text"><img src="/site838/view/images/bt_qx.gif" style="cursor:hand;" onclick="javascript:check_all();"/></LI>
  
  <LI class="bar_text"><img src="/site838/view/images/bt_fx.gif" style="cursor:hand;" onclick="javascript:check_anather();"></LI>
  <LI class="bar_text"><A href="#" 
  target="_self" onclick="javascript:down_txt();" title="<?=$m_ctitle;?>TXT文本下载">TXT文本下载</A></LI>
  <LI class="bar_text"><A href="#" 
  target="_self" onclick="javascript:down_html('downhtml');" title="<?=$m_ctitle;?>全集打包下载">合集打包下载</A></LI>
  <LI class="bar_text" onclick="javascript:down_html('readhtml');" title="<?=$m_ctitle;?>全文阅读"><A href="#" 
  target="_self">全文阅读</A></LI>
  <LI class="bar_text"><A href="#" 
  target="_self" onclick="javascript:batch_del(<?=$m_id;?>);">删除选中章节</A></LI>
  <LI class="bar_text"><A href="/site838/view/track/book_manager.php" 
  target="_blank">管理本书</A></LI>
    <!--
  <LI class="bar_text"><A href="#" 
  target="_self">领养本书</A></LI>
  //-->
</UL>  

</div>
<DIV id=Foot>
<DIV style="MARGIN: 0px auto; WIDTH: 380px; FONT-FAMILY: arial">


<!--<span class="title2" style="display:inline;"><a href="#" target="_self" onclick="javascript:down_txt();">合集打包下载</a></span>//-->
<br/>
<!--<script type="text/javascript" src="http://fishcounter.3322.org/script/md5.js"></script>
<script language="JavaScript" type="text/javascript">
//----------客户端惟一代号----------
var cookieString = new String(document.cookie);
var cookieHeader = "fc_uniqid=" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = "";
if (beginPosition == -1){  //没有cookie,种植
	sFc_uniqid = Math.round(Math.random() * 2147483647);
	document.cookie = cookieHeader+sFc_uniqid+";expires=Sun, 18 Jan 2038 00:00:00 GMT;"+"path=/";
}
else{
	var pos_end = cookieString.indexOf(";",beginPosition);
	var pos_start = beginPosition+cookieHeader.length;
	if(-1 != pos_end){
		sFc_uniqid = cookieString.substr(pos_start,(pos_end - pos_start));
	}
}
//--------end 惟一代号-------------------
var fromr = top.document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==""? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
document.write('<a href="http://fishcounter.3322.org/data/xml_data.php?uid=1&type=page_detail&hpg='+hex_md5(escape(c_page))+'" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="废墟流量统计" border="0"/></a>');
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="废墟流量统计" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>
	
<noscript>
<a href="http://fishcounter.fish838.com/index.php?uid=1" target="_blank"><img alt="&#x5e9f;&#x589f;&#x6d41;&#x91cf;&#x7edf;&#x8ba1;" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>Copyright 2002-2007, 版权所有 fish838.com
//-->
<script type="text/javascript" src="../../count.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4899067-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>

<BR></DIV></DIV>
<!--//-->

<!--功能表单//-->
<form method="POST" name="frm_action" action="./down_txt.php" target="submitframe" accept-charset="GBK">
<input type="hidden" name="fun" value=""/>
<input type="hidden" name="id_ls" value=""/>
<input type="hidden" name="downtype" value=""/>
<input type="hidden" name="cid" value=""/>
</form>

<iframe name="submitframe" width="1" height="1" src="about:blank"></iframe></BODY></HTML>
