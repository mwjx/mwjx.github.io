<?php
//--------------------------------
//create time:2003-12-16
//creater:zll
//purpose:登录注册页面
//-------------------------------
include("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
//缺省跳转地址
define("STR_URL_JUMP","/site838/view/home.php");
define("STR_LONG","18");
define("INT_NAME_LONG_MIN","2");  //名字最小长度
define("STR_EMAIL_LONG","50");
define("INT_MONEY_NEW",100);          //安家费
define("INT_WIN_NUM",1000);			  //每隔1000名注册用户中奖
define("INT_WIN_MONEY",10000);		  //中奖奖金额

define("INT_PV",5000);         //日页面访问量
define("INT_PV_PRICE",10);	   //每页价格

define("INT_REVENUE_DAY",6);	   //扣什一税日期,周一
define("INT_REVENUE_MONEY_MIN",100000);	   //扣什一税金钱最小值
define("INT_REVENUE_MUCH",1/10);	   //扣什一税税率

//cookie中的用户名//cookie中的密码
$currentuser = isset($_COOKIE["username"])?trim($_COOKIE['username']):"";
$currentpass = isset($_COOKIE["userpass"])?trim($_COOKIE['userpass']):"";
//接收表单的用户名//接收表单的密码
$str_post_user = isset($_POST["name"])?$_POST['name']:"";
$str_post_pass = isset($_POST["password"])?$_POST['password']:"";
//注册登录
$m_bln_submit = isset($_POST["submit"])?true:false;

if("" != $str_post_pass){
	$str_post_pass=crypt(stripslashes($str_post_pass),"d.r");   //密码加密
}
//HTTP_SERVER_VARS得到的地址参数
$str_url_referer = isset($_SERVER["HTTP_REFERER"])?$_SERVER['HTTP_REFERER']:"";
$str_url_get = isset($_GET["reurl"])?$_GET["reurl"]:"";                //GET得到的地址参数 //GET得到的功能参数   logout
$m_str_fun = isset($_GET["fun"])?$_GET["fun"]:"";
$m_login_url="/site838/view/login.php";  //接收参数地址
$m_str_post_url="/site838/main.php";  //接收参数地址
$m_str_myrand = mt_rand(1,5000);
//$m_str_liveroom_url = "index.php?roomid=1&amp;tmp=".strval($m_str_myrand);
$m_str_liveroom_url = "/";
$bln_reged = false;  //用户是否注册
$bln_login = false;  //用户是否登录
$timestamp = time();
$cookietime=time()+86400*365;
//$cookietime *= 365; //一年
if($m_str_fun == "logout"){
	setcookie("username","",$cookietime,"/","www.fish838.com");
	setcookie("userpass","",$cookietime,"/","www.fish838.com");
	setcookie("mw_uid","",$cookietime,"/","www.fish838.com");

	setcookie("username","",$cookietime,"/","fish838.com");
	setcookie("userpass","",$cookietime,"/","fish838.com");
	setcookie("mw_uid","",$cookietime,"/","fish838.com");
	//window.parent.location.href
	echo "<a href = \"#\" onclick=\"javascript:window.location.href=('".$m_login_url."');\">重新登录</a>";
	//echo "<a href = \"#\" onclick=\"javascript:window.top.location.href=('".$m_str_post_url."');\">重新登录</a>";
	exit;
}
/*else if($m_str_fun == "login"){
	setcookie("username","",$cookietime,"/");
	setcookie("userpass","",$cookietime,"/");
	//exit("kk");
	//window.parent.location.href
	echo "<script language=\"javascript\">\nwindow.top.location.href=('".$m_str_post_url."');\n</script>";
	exit;
}
*/

//已经登录并且用户名与密码正确，跳转到活动室
if($currentuser != "" && $currentpass != ""){

	//$aman=new manbase_2($currentuser,$currentpass);
	//$re_login = $aman->login();
	$re_login = login($currentuser,$currentpass);
	if(false === ($re_login[0])){
		//没有登录或用户名密码不对,删除cookei
		$bln_login=false;
		//$cookietime=time()+86400;
		setcookie("username","",$cookietime,"/");
		setcookie("userpass","",$cookietime,"/");
	}
	else{

		header("Location:  $m_str_liveroom_url");
		//jump_page($m_str_liveroom_url);
		exit;
	}
}
/*
else{
	//$bln_login = true;
	setcookie("username","",$cookietime,"/");
	setcookie("userpass","",$cookietime,"/");
}
*/
//是否注册
if(true === $m_bln_submit){
	/*
	$aman=new manbase_2($str_post_user);
	if($aman->get_id() == -1){
		//没有注册,删除cookie

		$bln_reged=false;
		if(false === ($re_reg = reg($str_post_user,$str_post_pass))){
			exit("注册失败");
		}
		$str_post_user = $re_reg[0];
		$str_post_pass = $re_reg[1];
	}
	else{
		//已经注册
		$bln_reged=true;
	}
	*/
	$re_login = login($str_post_user,$str_post_pass);
	if(false === $re_login[0]){
		//echo "<a href = \"#\" onclick=\"javascript:window.top.location.href=('".$m_str_post_url."');\">重新登录</a>&nbsp;&nbsp;";
		echo "<a href = \"#\" onclick=\"javascript:window.location.href=('".$m_login_url."');\">重新登录</a>&nbsp;&nbsp;";
		exit($re_login[1]);
	}
	//2007-8-15
	setcookie("username",$str_post_user,$cookietime,"/");
	setcookie("userpass",$str_post_pass,$cookietime,"/");
	//jump_page($m_str_post_url);
	goto_url("/site838/","登录成功，现在跳转到书库首页",3);
	exit;
}
/*
echo "<a href = \"#\" onclick=\"javascript:window.top.location.href=('".$m_str_post_url."');\">帐户验证失败，重新登录</a>";
exit();	
*/
//------------------具体函数-----------------------------
function goto_url($url = "",$str = "",$flag=1)
{
	//跳转页面
	//输入:url不为空跳转到该地址,值refresh刷新当前窗口,
	//str不为空显示该信息
	//flag(int)1/2/3(父窗口/当前窗口/祖窗口)
	//输出:无
	if("" != $str)
		$str = "alert(\"".$str."\");";
	$window = "window.parent";
	if(2 == $flag)
		$window = "window";
	if(3 == $flag)
		$window = "window.parent.parent";
	if("" != $url){
		if("refresh" == $url)
			$url = $window.".location.reload();";
		else
			$url = $window.".location.href=\"".$url."\";";
	}
	//writetofile("xxx.txt",$url);
	exit("<script language=\"javascript\">
".$str.$url."
</script>");
}
function login($name="",$userpass="")
{
	//登录
	$aman=new manbase_2($name,$userpass);
	$tmp = $aman->get_lastenter();
	$tmp = substr($tmp,0,10);
	if($aman->get_id() > 0 && date("Y-m-d",time()) != $tmp)
		$aman->add_money(1);
	$result = $aman->login($name,$userpass);
	return $result;
}


function reg($name="",$userpass="")
{
	//注册
	//输入：两个字符串，name用户名，userpass密码
	//输出：正常返回用户名和密码数组,异常返回false
	//exit($userpass);
	$new_man=new manbase_2();
	$result = $new_man->reg($name,$userpass);
	if(false == $result[0]){
		exit($result[1]);
		return false;
	}

	$findme = ",";
	$pos = strpos($result[1], $findme);
	if(false === $pos){
		return false;
	}
	$re_name = substr($result[1],0,$pos);
	$re_pswd = substr($result[1],$pos+1,(strlen($result[1]) - $pos - 1));
	return array($re_name,$re_pswd);
}

//------------------------------------------------------
?>
<HTML>
<HEAD><TITLE> --+妙文精选---幽默搞笑网文精品---登录/注册+-- www.mwjx.com</TITLE>
<META http-equiv=Content-Language content=zh-cn>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK
href="/site838/view/include/login.css" type=text/css rel=stylesheet>
<SCRIPT language=javascript>
function CheckForm()
{
	//alert("aaa");
	//return;
	if(document.UserLogin.name.value=="")
	{
		alert("请输入用户名！");
		document.UserLogin.name.focus();
		return false;
	}
	if(document.UserLogin.password.value == "")
	{
		alert("请输入密码！");
		document.UserLogin.password.focus();
		return false;
	}
	return true;
}
function come_on()
{
	//提交
	if(false ==- CheckForm())
		return;
	document.UserLogin.submit();
}
function init()
{
	//return;
	if("undefined" == typeof(document.all["name"]))
		return;
	try{
		document.all["name"].focus();
	}
	catch(err){
	}
}
</SCRIPT>
<META content="MSHTML 6.00.2800.1106" name=GENERATOR></HEAD>
<BODY onload="javascript:init();" bottomMargin="5" bgColor="#698db6" leftMargin="5" topMargin="5" rightMargin="5">
<DIV align=center>
<TABLE style="BORDER-COLLAPSE: collapse" borderColor=#698db6
 cellSpacing=0 cellPadding=0 width="750" border=0 height="80%">
  <TBODY>
  <TR>
    <TD width="100%" height=284>
      <FORM id="UserLogin"
      name="login" action="login.php" method="post" visable="false">
	  <CENTER>
      <TABLE class=box style="BORDER-RIGHT: #808080 2px outset; BORDER-TOP: #808080 2px outset; BORDER-LEFT: #808080 2px outset; BORDER-BOTTOM: #808080 2px outset" height="255" cellSpacing="0" cellPadding="0" width="440" bgColor="#f0f0f0" border="0">
        <TBODY>

        <TR vAlign=top>
          <TD width=440 colSpan=2 height=88 align=center><IMG
            src="/site838/view/images/002.gif" border=0 ><!--<br><a href="index.htm" title="打死都不注册,从来没有一个地方留住我两次"><b><font face="Arial">&gt;&gt;ENTER</font></b>
                  </a> //--></TD>
              </TR>

        <TR>
          <TD class=ttTable vAlign=top width=140 height=34>
            <P align=right><IMG src="/site838/view/images/t1.gif" border=0>
            </P></TD>
          <TD class=td noWrap width=300 height=34>&nbsp;&nbsp;&nbsp;&nbsp;
            <INPUT class=box name="name"> </TD></TR>
        <TR>
          <TD class=ttTable vAlign=top width=140 height=33>
            <P align=right><FONT color=#000000><IMG
            src="/site838/view/images/t2.gif" ></FONT> </P></TD>
          <TD class=td width=300 height=33>&nbsp;&nbsp;&nbsp;&nbsp; <INPUT class=box type="password" name="password"> </TD></TR>
        <TR>
          <TD align=middle width=440 colSpan=2 height=41 title="请在上面输入框中填入你的用户名与密码">请填写用户名与密码<!--[<a href="../../help.html#auto_reg" target="_blank">?</a>]//--><input style='background-color:white;color:#6699FF;border:1 double' type="submit" value=" 登陆 " name="submit" onclick="javascript:return CheckForm();">&nbsp;&nbsp;&nbsp;&nbsp;<a href="./reg.php">注册新用户</a></TD></TR></TBODY></TABLE>
		  </CENTER>
		  </FORM>
	  </TD></TR></TBODY></TABLE></DIV></BODY>
	  </HTML>