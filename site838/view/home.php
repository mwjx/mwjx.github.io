<?php
//------------------------------
//create time:2006-12-26
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:用户主页
//------------------------------
//if("小鱼" != $_COOKIE['username']){
//	$html = "由于资源限制，本功能暂时关闭。<br/><a href=\"http://www.mwjx.com/\"><b>返回《妙文精选》首页</b></a>";	
//	exit($html);
//}
$m_uid = isset($_GET["id"])?$_GET["id"]:"";
require_once("../class/function.inc.php");
require_once("./src_php/fun_index.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
$m_path_main = isset($_GET["main"])?$_GET["main"]:"";
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
$m_uid = ""; //用户ID
if("" != $currentuser){
	$aman = new manbase_2($currentuser,$currentpass);
	//if($aman->get_id() < 1)
	//	exit("用户无效");
	$m_uid = $aman->get_id();
}
//exit($m_path_main);
if("" != $m_path_main){
	$str_get = get_str();
	if("" != $str_get)
		$m_path_main .= ("?".$str_get);

}
function get_str()
{
	//get字符串
	//输入:无
	//输出:字符串,异常返回空字符串
	$str_get = "";
	foreach($_GET as $key=>$val){
		if("" != $str_get)
			$str_get .= "&";
		$str_get .= ($key."=".$val);
	}
	return $str_get;
}
//exit($m_path_main);
$m_str_html = get_html_frame(strval($m_uid),$m_path_main);
/*
session_start();
require_once("./class/function.inc.php");
require_once("./class/fun_global.php");
require_once("./class/fun_index.php");
require_once("./class/config.inc.php");
require_once("./class/class_mysql.inc.php");
require_once("./class/class_user.php");
my_safe_include("power.php");
//接收表单的用户名
$str_post_user = isset($_POST['name'])?$_POST['name']:"";
//接收表单的密码
$str_post_pass = isset($_POST['password'])?$_POST['password']:"";
$str_get_fun = isset($_GET["fun"])?$_GET["fun"]:"";  //功能
$m_uid = isset($_GET["uid"])?$_GET["uid"]:"";  //用户ID
$m_str_url_login = "./index.php";  //写完session后跳转的网址
if($str_post_user != "" && $str_post_pass != ""){ //登录
	$_SESSION["username"] = $str_post_user;
	$_SESSION["userpass"] = userbase::cry_pswd($str_post_pass);
	header("Location:  $m_str_url_login");
}
if($str_get_fun == "logout"){ //退出登录
	clear_session_user();
	header("Location:  $m_str_url_login");
}
//验证用户密码
$obj_user = new userbase($_SESSION["username"],$_SESSION["userpass"]);
if(!$obj_user->check_build()){
	$m_power = new powerbase;
	if(!$m_power->is_user_open_report($m_uid)){
		$m_uid = -1;
		$str_check = get_html_login();
	}
	else{
		$str_check = get_html_frame(strval($m_uid));
	}
}
else{
	$str_check = get_html_frame(strval($obj_user->get_id()));
	$m_uid = $obj_user->get_id();	
}
if(intval($m_uid) > 0)
	$_SESSION["uid"] = $m_uid;
$m_str_html = $str_check;
*/
//$m_str_html = get_html_login();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title>妙文精选</TITLE>
<SCRIPT>
function switchSysBar(){
//return false;
if (document.all("switchPoint").innerText==3){
document.all("switchPoint").innerText=4;
document.all("frmTitle").style.display="none";
}else{
document.all("switchPoint").innerText=3;
document.all("frmTitle").style.display="";
}}
</SCRIPT>
<link rel="stylesheet" href="./css/global.css">
<style>
body,td,p,a,input {font-size:12px;}
p {line-height:140%;margin:10px 0px 4px 0px}
a {text-decoration:none}
a:hover {text-decoration: underline }
</style>
</head>
<BODY scroll="no" style="MARGIN: 0px" oncontextmenu="return false" >

<!--<script language="javascript">
check_qq_height();
function height_ifmqq(s)
{
	document.all.ifm_fish_qq.style.height = s;
}
function check_qq_height()
{
	try{
		var str = window.clipboardData.getData('text');
		if("show_msglist" == str)
			height_ifmqq("240px");
		if("hide_msglist" == str)
			height_ifmqq("30px");
		if("show_msglist" == str || "hide_msglist" == str)
			window.clipboardData.setData('text',""); //清空
		setTimeout(check_qq_height,500);
	}
	catch(err){
	}
}
</script>

<table width="100%" cellSpacing=0 cellPadding=0 align=center border=0><tr><td>
<IFRAME align="left" marginWidth="0" marginHeight="0" src="http://mwjxhome.3322.org/fish_qq_client/fish_qq.html" frameBorder="0" scrolling="auto" name="ifm_fish_qq" style="width:100%;height:30px;"></IFRAME>
</td></tr>
</table>
//-->
<?php
echo $m_str_html;
?>
<table border="0" width="100%" cellpadding="0" cellspacing="0" height="21" valign="bottom">
<tr bgcolor="#6699cc">
	<td height="21" class="font_white" nowrap align="center" valign="middle">

&nbsp;&nbsp;&copy; 2002-<?=date("Y")?>  &reg;mwjx <a href="mailto:liang_0735@21cn.com">联系站长</a>&nbsp;
	</td>
</tr>
</table>
</body></html>