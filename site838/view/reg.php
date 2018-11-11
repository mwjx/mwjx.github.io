<?php
//--------------------------------
//create time:2007-7-4
//creater:zll
//purpose:注册页面
//-------------------------------
//setcookie("username","aa");
//$cookietime=time()+86400*365;
//setcookie("username","bb",$cookietime,"/");
//setcookie("userpass","123",$cookietime,"/");
//var_dump($_COOKIE["username"]);
//exit();
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

$m_url = "/site838/view/reg.php";  //原始地址
//cookie中的用户名//cookie中的密码
$currentuser = isset($_COOKIE["username"])?trim($_COOKIE['username']):"";
$currentpass = isset($_COOKIE["userpass"])?trim($_COOKIE['userpass']):"";
//接收表单的用户名//接收表单的密码
$str_post_user = isset($_POST["name"])?$_POST['name']:"";
$str_post_pass = isset($_POST["password"])?$_POST['password']:"";
$str_email = isset($_POST["txt_email"])?$_POST['txt_email']:"";
$m_fun = isset($_GET["fun"])?$_GET["fun"]:"";
if("" != $str_email){
	if(strlen($str_email) > 50){
		goto_url("","邮箱长度不能超出50个字符");
	}
	//if(!eregi("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]\\-)+\\.)+[a-z]{2,4}$",$str_email)){
	//	goto_url("","邮箱格式不正确:".$str_email);
	//}
	if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$",$str_email)) { //格式不正确
		goto_url("","邮箱格式不正确:".$str_email);
	}
}

if("reg" == $m_fun){
	//检查用户是否存在
	if("" != $str_post_pass){ //密码加密
		$str_post_pass=crypt(stripslashes($str_post_pass),"d.r");   
	}	
	if(false === ($re_reg = reg($str_post_user,$str_post_pass,$str_email))){
		goto_url($m_url,"注册失败");
	}
	else{
		$re_login = login($str_post_user,$str_post_pass);
		if(false === $re_login[0]){
			goto_url("","注册成功，但登录失败，原因未知");
		}
		goto_url("/site838/","注册成功，现在跳转到书库首页",3);
	}
	//$str_post_user = $re_reg[0];
	//$str_post_pass = $re_reg[1];
}
//------------------具体函数-----------------------------

function login($name="",$userpass="")
{
	//登录
	$aman=new manbase_2($name,$userpass);
	$result = $aman->login($name,$userpass);
	//$cookietime=time()+86400*30;
	//$_COOKIE["username"] = $name;
	//$_COOKIE["userpass"] = $userpass;
	//setcookie("username",$name,$cookietime,"/");
	//setcookie("userpass",$userpass,$cookietime,"/");
	$cookietime=time()+86400*365;
	setcookie("username",$name,$cookietime,"/");
	setcookie("userpass",$userpass,$cookietime,"/");
	return $result;
}
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
function reg($name="",$userpass="",$email = "")
{
	//注册
	//输入：两个字符串，name用户名，userpass密码
	//email用户邮箱
	//输出：正常返回用户名和密码数组,异常返回false
	//exit($userpass);
	$new_man=new manbase_2();
	if("" != $eamil){
		$new_man->set_email($eamil);
	}
	$result = $new_man->reg($name,$userpass);
	//goto_url("",$name."|".$userpass."|".$eamil);
	if(false == $result[0]){
		//exit($result[1]);
		goto_url("","注册失败:".$result[1]);
		//return false;
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
<HEAD><TITLE> --+838书城---最新小说---注册+-- www.fish838.com</TITLE>
<META http-equiv=Content-Language content=zh-cn>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK
href="/site838/view/css/reg.css" type=text/css rel=stylesheet>
<SCRIPT language=javascript>
function CheckForm()
{
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
      name="form_reg" action="reg.php?fun=reg" method="post" visable="false" onsubmit="return CheckForm();" target="submitframe">
	  <CENTER>
      <TABLE class=box style="BORDER-RIGHT: #808080 2px outset; BORDER-TOP: #808080 2px outset; BORDER-LEFT: #808080 2px outset; BORDER-BOTTOM: #808080 2px outset" height="255" cellSpacing="0" cellPadding="0" width="440" bgColor="#f0f0f0" border="0">
        <TBODY>

        <TR vAlign=top>
          <TD width=440 colSpan=2 height=88 align=center><IMG
            src="/site838/view/images/002.gif" border=0 ></TD>
              </TR>

        <TR>
          <TD class=ttTable vAlign=top width=140 height=34>
			</TD>
          <TD class=td noWrap width=300 height=34>[必填]<strong>用户名</strong>:&nbsp;&nbsp;
            <INPUT class="inbox" name="name"> </TD></TR>
        <TR>
          <TD class=ttTable vAlign=top width=140 height=33>
            </TD>
          <TD class=td width=300 height=33>[必填]<strong>密码</strong>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT class="inbox" type="password" name="password"> </TD></TR>
        <TR>
          <TD class=ttTable vAlign=top width=140 height=33>
            </TD>
          <TD class=td width=300 height=33>[选填]<strong>邮箱</strong>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT class="inbox" type="text" name="txt_email"> </TD></TR>
        <TR>
          <TD align=middle width=440 colSpan=2 height=41 title="请在上面输入框中填入你想使用的用户名与密码">请填写用户名与密码<input style='background-color:white;color:#6699FF;border:1 double' type="submit" value=" 提交注册 " name="submit"></TD></TR></TBODY></TABLE>
		  </CENTER>
		  </FORM>
	  </TD></TR>	  
	  </TBODY></TABLE></DIV>
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>