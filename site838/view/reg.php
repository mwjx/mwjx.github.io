<?php
//--------------------------------
//create time:2007-7-4
//creater:zll
//purpose:ע��ҳ��
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

$m_url = "/site838/view/reg.php";  //ԭʼ��ַ
//cookie�е��û���//cookie�е�����
$currentuser = isset($_COOKIE["username"])?trim($_COOKIE['username']):"";
$currentpass = isset($_COOKIE["userpass"])?trim($_COOKIE['userpass']):"";
//���ձ����û���//���ձ�������
$str_post_user = isset($_POST["name"])?$_POST['name']:"";
$str_post_pass = isset($_POST["password"])?$_POST['password']:"";
$str_email = isset($_POST["txt_email"])?$_POST['txt_email']:"";
$m_fun = isset($_GET["fun"])?$_GET["fun"]:"";
if("" != $str_email){
	if(strlen($str_email) > 50){
		goto_url("","���䳤�Ȳ��ܳ���50���ַ�");
	}
	//if(!eregi("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]\\-)+\\.)+[a-z]{2,4}$",$str_email)){
	//	goto_url("","�����ʽ����ȷ:".$str_email);
	//}
	if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$",$str_email)) { //��ʽ����ȷ
		goto_url("","�����ʽ����ȷ:".$str_email);
	}
}

if("reg" == $m_fun){
	//����û��Ƿ����
	if("" != $str_post_pass){ //�������
		$str_post_pass=crypt(stripslashes($str_post_pass),"d.r");   
	}	
	if(false === ($re_reg = reg($str_post_user,$str_post_pass,$str_email))){
		goto_url($m_url,"ע��ʧ��");
	}
	else{
		$re_login = login($str_post_user,$str_post_pass);
		if(false === $re_login[0]){
			goto_url("","ע��ɹ�������¼ʧ�ܣ�ԭ��δ֪");
		}
		goto_url("/site838/","ע��ɹ���������ת�������ҳ",3);
	}
	//$str_post_user = $re_reg[0];
	//$str_post_pass = $re_reg[1];
}
//------------------���庯��-----------------------------

function login($name="",$userpass="")
{
	//��¼
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
function reg($name="",$userpass="",$email = "")
{
	//ע��
	//���룺�����ַ�����name�û�����userpass����
	//email�û�����
	//��������������û�������������,�쳣����false
	//exit($userpass);
	$new_man=new manbase_2();
	if("" != $eamil){
		$new_man->set_email($eamil);
	}
	$result = $new_man->reg($name,$userpass);
	//goto_url("",$name."|".$userpass."|".$eamil);
	if(false == $result[0]){
		//exit($result[1]);
		goto_url("","ע��ʧ��:".$result[1]);
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
<HEAD><TITLE> --+838���---����С˵---ע��+-- www.fish838.com</TITLE>
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
          <TD class=td noWrap width=300 height=34>[����]<strong>�û���</strong>:&nbsp;&nbsp;
            <INPUT class="inbox" name="name"> </TD></TR>
        <TR>
          <TD class=ttTable vAlign=top width=140 height=33>
            </TD>
          <TD class=td width=300 height=33>[����]<strong>����</strong>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT class="inbox" type="password" name="password"> </TD></TR>
        <TR>
          <TD class=ttTable vAlign=top width=140 height=33>
            </TD>
          <TD class=td width=300 height=33>[ѡ��]<strong>����</strong>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT class="inbox" type="text" name="txt_email"> </TD></TR>
        <TR>
          <TD align=middle width=440 colSpan=2 height=41 title="�����������������������ʹ�õ��û���������">����д�û���������<input style='background-color:white;color:#6699FF;border:1 double' type="submit" value=" �ύע�� " name="submit"></TD></TR></TBODY></TABLE>
		  </CENTER>
		  </FORM>
	  </TD></TR>	  
	  </TBODY></TABLE></DIV>
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>