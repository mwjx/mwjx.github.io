<?php
//--------------------------------
//create time:2003-12-16
//creater:zll
//purpose:��¼ע��ҳ��
//-------------------------------
include("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
//ȱʡ��ת��ַ
define("STR_URL_JUMP","/site838/view/home.php");
define("STR_LONG","18");
define("INT_NAME_LONG_MIN","2");  //������С����
define("STR_EMAIL_LONG","50");
define("INT_MONEY_NEW",100);          //���ҷ�
define("INT_WIN_NUM",1000);			  //ÿ��1000��ע���û��н�
define("INT_WIN_MONEY",10000);		  //�н������

define("INT_PV",5000);         //��ҳ�������
define("INT_PV_PRICE",10);	   //ÿҳ�۸�

define("INT_REVENUE_DAY",6);	   //��ʲһ˰����,��һ
define("INT_REVENUE_MONEY_MIN",100000);	   //��ʲһ˰��Ǯ��Сֵ
define("INT_REVENUE_MUCH",1/10);	   //��ʲһ˰˰��

//cookie�е��û���//cookie�е�����
$currentuser = isset($_COOKIE["username"])?trim($_COOKIE['username']):"";
$currentpass = isset($_COOKIE["userpass"])?trim($_COOKIE['userpass']):"";
//���ձ����û���//���ձ�������
$str_post_user = isset($_POST["name"])?$_POST['name']:"";
$str_post_pass = isset($_POST["password"])?$_POST['password']:"";
//ע���¼
$m_bln_submit = isset($_POST["submit"])?true:false;

if("" != $str_post_pass){
	$str_post_pass=crypt(stripslashes($str_post_pass),"d.r");   //�������
}
//HTTP_SERVER_VARS�õ��ĵ�ַ����
$str_url_referer = isset($_SERVER["HTTP_REFERER"])?$_SERVER['HTTP_REFERER']:"";
$str_url_get = isset($_GET["reurl"])?$_GET["reurl"]:"";                //GET�õ��ĵ�ַ���� //GET�õ��Ĺ��ܲ���   logout
$m_str_fun = isset($_GET["fun"])?$_GET["fun"]:"";
$m_login_url="/site838/view/login.php";  //���ղ�����ַ
$m_str_post_url="/site838/main.php";  //���ղ�����ַ
$m_str_myrand = mt_rand(1,5000);
//$m_str_liveroom_url = "index.php?roomid=1&amp;tmp=".strval($m_str_myrand);
$m_str_liveroom_url = "/";
$bln_reged = false;  //�û��Ƿ�ע��
$bln_login = false;  //�û��Ƿ��¼
$timestamp = time();
$cookietime=time()+86400*365;
//$cookietime *= 365; //һ��
if($m_str_fun == "logout"){
	setcookie("username","",$cookietime,"/","www.fish838.com");
	setcookie("userpass","",$cookietime,"/","www.fish838.com");
	setcookie("mw_uid","",$cookietime,"/","www.fish838.com");

	setcookie("username","",$cookietime,"/","fish838.com");
	setcookie("userpass","",$cookietime,"/","fish838.com");
	setcookie("mw_uid","",$cookietime,"/","fish838.com");
	//window.parent.location.href
	echo "<a href = \"#\" onclick=\"javascript:window.location.href=('".$m_login_url."');\">���µ�¼</a>";
	//echo "<a href = \"#\" onclick=\"javascript:window.top.location.href=('".$m_str_post_url."');\">���µ�¼</a>";
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

//�Ѿ���¼�����û�����������ȷ����ת�����
if($currentuser != "" && $currentpass != ""){

	//$aman=new manbase_2($currentuser,$currentpass);
	//$re_login = $aman->login();
	$re_login = login($currentuser,$currentpass);
	if(false === ($re_login[0])){
		//û�е�¼���û������벻��,ɾ��cookei
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
//�Ƿ�ע��
if(true === $m_bln_submit){
	/*
	$aman=new manbase_2($str_post_user);
	if($aman->get_id() == -1){
		//û��ע��,ɾ��cookie

		$bln_reged=false;
		if(false === ($re_reg = reg($str_post_user,$str_post_pass))){
			exit("ע��ʧ��");
		}
		$str_post_user = $re_reg[0];
		$str_post_pass = $re_reg[1];
	}
	else{
		//�Ѿ�ע��
		$bln_reged=true;
	}
	*/
	$re_login = login($str_post_user,$str_post_pass);
	if(false === $re_login[0]){
		//echo "<a href = \"#\" onclick=\"javascript:window.top.location.href=('".$m_str_post_url."');\">���µ�¼</a>&nbsp;&nbsp;";
		echo "<a href = \"#\" onclick=\"javascript:window.location.href=('".$m_login_url."');\">���µ�¼</a>&nbsp;&nbsp;";
		exit($re_login[1]);
	}
	//2007-8-15
	setcookie("username",$str_post_user,$cookietime,"/");
	setcookie("userpass",$str_post_pass,$cookietime,"/");
	//jump_page($m_str_post_url);
	goto_url("/site838/","��¼�ɹ���������ת�������ҳ",3);
	exit;
}
/*
echo "<a href = \"#\" onclick=\"javascript:window.top.location.href=('".$m_str_post_url."');\">�ʻ���֤ʧ�ܣ����µ�¼</a>";
exit();	
*/
//------------------���庯��-----------------------------
function goto_url($url = "",$str = "",$flag=1)
{
	//��תҳ��
	//����:url��Ϊ����ת���õ�ַ,ֵrefreshˢ�µ�ǰ����,
	//str��Ϊ����ʾ����Ϣ
	//flag(int)1/2/3(������/��ǰ����/�洰��)
	//���:��
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
	//��¼
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
	//ע��
	//���룺�����ַ�����name�û�����userpass����
	//��������������û�������������,�쳣����false
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
<HEAD><TITLE> --+���ľ�ѡ---��Ĭ��Ц���ľ�Ʒ---��¼/ע��+-- www.mwjx.com</TITLE>
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
		alert("�������û�����");
		document.UserLogin.name.focus();
		return false;
	}
	if(document.UserLogin.password.value == "")
	{
		alert("���������룡");
		document.UserLogin.password.focus();
		return false;
	}
	return true;
}
function come_on()
{
	//�ύ
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
            src="/site838/view/images/002.gif" border=0 ><!--<br><a href="index.htm" title="��������ע��,����û��һ���ط���ס������"><b><font face="Arial">&gt;&gt;ENTER</font></b>
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
          <TD align=middle width=440 colSpan=2 height=41 title="�����������������������û���������">����д�û���������<!--[<a href="../../help.html#auto_reg" target="_blank">?</a>]//--><input style='background-color:white;color:#6699FF;border:1 double' type="submit" value=" ��½ " name="submit" onclick="javascript:return CheckForm();">&nbsp;&nbsp;&nbsp;&nbsp;<a href="./reg.php">ע�����û�</a></TD></TR></TBODY></TABLE>
		  </CENTER>
		  </FORM>
	  </TD></TR></TBODY></TABLE></DIV></BODY>
	  </HTML>