<?php
//------------------------------
//create time:2007-8-13
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:远程文本替换工具
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//my_safe_include("mwjx/interface.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/authorize.php");
//echo "hello";
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if($obj_man->get_id() < 1)
	exit("<a href=\"/mwjx/login.php\">请登录</a>");
//权限
$obj = new c_authorize;		
if(!$obj->can_do($obj_man,1,1,19)){
	exit("无权修改");		
}
//$test = "http://localhost/index.html";
//$path = (get_path($test));
//$txt = get_txt($test);
//var_dump(get_txt($test));
//exit();
$m_fun = isset($_POST["fun"])?$_POST["fun"]:"";
$m_url = isset($_POST["txt_url"])?$_POST["txt_url"]:""; //要修改的URL
$m_txt = ""; //原始文本
//$m_txt = isset($_POST["content_all"])?$_POST["content_all"]:""; 
switch($m_fun){
	case "get_txt": //取原始文本
		//goto_url("",$_POST["txt_url"]);
		
		$m_txt = get_txt($m_url);
		//goto_url("",);
		break;
	case "commit_txt": //提交文本
		//$txt = (str_replace("\\\"","\"",$_POST["content_all"]));
		//exit();
		$txt = stripslashes(isset($_POST["content_all"])?$_POST["content_all"]:"");
		//goto_url("",msubstr($_POST["content_all"],0,200));
		//$str_sql = "insert into tests (val)values('".$txt."');";
		//$sql = new mysql;
		//$sql->query($str_sql);
		//$sql->close();
		//goto_url("",$txt.":".strlen($txt));
		if(commit_txt($m_url,$txt))
			goto_url("","修改成功");
		else
			goto_url("","修改失败");
		break;
	default:
		break;
}
function commit_txt($url = "",$txt="")
{
	//提交文本
	//输入:url(string),txt(string)文本内容
	//输出:true,false
	if("" == $url)
		return false;
	//从URL取得路径
	$path = get_path($url);
	if("" == $path)
		return false;
	//exit($path);
	$str_dir = get_dir_home();
	$path = $str_dir."../../".$path;
	//goto_url("","txt:".$txt);
	
	if(false === writetofile($path,$txt))
		return false;
	return true;
}
function get_txt($url = "")
{
	//返回url文本
	//输入:url(string)URL
	//输出:文本字符串
	if("" == $url)
		return "";
	//从URL取得路径
	$path = get_path($url);
	if("" == $path)
		return "";
	//exit($path);
	$str_dir = get_dir_home();
	$path = $str_dir."../../".$path;
	//exit($path);
	//$txt = readfromfile("../../index.html");
	$txt = readfromfile($path);
	//exit($txt);
	return $txt;
}
function get_path($url = "")
{
	//从url中取得路径
	//输入:url(string)
	//输出:路径字符串
	if("" == $url)
		return "";
	if(!($path = strstr($url,"//")))
		return "";
	$path = substr($path,2);
	if(!($path = strstr($path,"/")))
		return "";
	$path = substr($path,1);
	//$path = "";
	return $path;
}
function goto_url($url = "",$str = "",$flag=1)
{
	//跳转页面
	//输入:url不为空跳转到该地址,值refresh刷新当前窗口,
	//str不为空显示该信息
	//flag(int)1/2(父窗口/当前窗口)
	//输出:无
	if("" != $str)
		$str = "alert(\"".$str."\");";
	$window = "window.parent";
	if(2 == $flag)
		$window = "window";
	if("" != $url){
		if("refresh" == $url)
			$url = $window.".location.reload();";
		else
			$url = $window.".location.href=\"".$url."\";";
	}
	exit("<script language=\"javascript\">
".$str.$url."
</script>");
}
?>
<HTML>
<HEAD>
<TITLE> 远程文本替换工具 </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<script language="javascript">
function get_txt()
{
	if("" == document.all["txt_url"].value)
		return alert("URL不能为空");
	document.all["fun"].value = "get_txt";
	document.all["frmsubmit"].target = '_self';
	document.all["frmsubmit"].action = './text_replacement.php';
	document.all["frmsubmit"].submit();	
	return; // alert("取得原文本");
	//return document.all["title_all"].value;
}
function commit()
{
	//提交
	//输入:无
	//输出:无
	if("" == document.all["txt_url"].value)
		return alert("URL不能为空");
	document.all["fun"].value = "commit_txt";
	document.all["frmsubmit"].target = 'submitframe';
	//document.all["frmsubmit"].target = '_self';
	document.all["frmsubmit"].action = './text_replacement.php';
	document.all["frmsubmit"].submit();	
	//return; // alert("取得原文本");
}
function view()
{
	//预览
	//输入:无
	//输出:无
	if("" == document.all["txt_url"].value)
		return alert("URL不能为空");
	window.open(document.all["txt_url"].value);
	//alert("预览");
}
function init()
{
	//初始
	//run();
}
</script>
</HEAD>

<BODY onload="javascript:init();">
<table>
<tr><td>
全部内容
</td></tr>
<form id="frmsubmit" name="frmsubmit"  action="" method="POST" target="submitframe">
<input type="hidden" name="fun" value=""/>
<tr><td>
要修改的URL:<input type="text" name="txt_url" value="<?=$m_url;?>" size="50"/>
</td></tr>
<tr><td>
<textarea cols="80" name="content_all" rows="17" style="FONT-SIZE: 9pt"><?=$m_txt;?></textarea>
</td></tr>
<tr><td align="center">
<button onclick="javascript:get_txt();">获取原始文本</button>&nbsp;&nbsp;<button onclick="javascript:commit();">提交修改</button>
&nbsp;&nbsp;<button onclick="javascript:view();">预览</button>
</td></tr>
</form>
</table>
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>
