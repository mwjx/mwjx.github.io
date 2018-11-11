<?php
//------------------------------
//create time:2007-8-8
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:订阅邮件列表
//------------------------------
require("phpmailer/class.phpmailer.php");
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//接收地址
$m_to = trim(isset($_POST["txt_email"])?$_POST["txt_email"]:""); 
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //订阅用户ID
//取消订阅用户ID
$m_cancelid = intval(isset($_GET["cancelid"])?$_GET["cancelid"]:-1); 
$m_code = isset($_GET["code"])?$_GET["code"]:""; //激活码
//$m_to = "liang_0735@163.com"; //test
/*
if("" != $m_code && $m_cancelid > 0){ //取消订阅
	$code = get_code_byid($m_cancelid,2);	
	if("" == $code)
		exit("订户不存");
	if($m_code != $code)
		exit("激活码无效");
	//exit("fff");
	//开始取消
	$str_sql = "update mail_list set active ='N' where id = '".$m_cancelid."';";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	exit("取消订阅成功。</br><a href=\"http://www.mwjx.com/\">回到妙文精选</a>");	
}
*/
if("" != $m_code && $m_id > 0){ //激活
	$code = get_code_byid($m_id);	
	if("" == $code)
		exit("订户不存在或已经是激活用户");
	if($m_code != $code)
		exit("激活码无效");
	//exit("fff");
	//开始激活
	$str_sql = "update mail_list set active ='Y' where id = '".$m_id."';";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	exit("恭喜你，激活成功，如果正常，你将在明或后天收到第一次更新邮件。</br><a href=\"http://www.mwjx.com/\">回到妙文精选</a>");
}
//goto_url("","a:".($m_to));
if("" == $m_to){
	goto_url("","订阅失败,请填写邮箱");
	exit();
}
if(strlen($m_to) > 255){
	goto_url("","订阅失败,邮箱长度不能超过255个字符");
	exit();
}

if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$m_to)) {
	goto_url("","订阅失败,邮箱无效,请换一个邮箱试试");
	exit();
}
//是否已订阅
$str_sql = "select active from mail_list where tomail = '".$m_to."';";
$sql=new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
if(count($arr) > 0){ //已订阅
	if("Y" == $arr[0][0]){ //已激活
		goto_url("","订阅失败,这个邮箱已经订阅了邮件:".$m_to);
		exit();
	}
	//exit("未激活");
	//未激活，发送激活邮件
}
else{ //未订阅
	//插入订户列表
	$str_sql = "insert into mail_list (tomail,last)values('".$m_to."','".date("Y-m-d",time())."');";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
}
$arr_code = get_code($m_to);
if(2 != count($arr_code)){
	goto_url("","订阅失败,资料异常");
	exit();	
}
//var_dump($arr_code);
//exit();
//发送激活邮件
$mail = new phpmailer();
//$mail->IsSendmail();
$mail->IsSMTP(); // set mailer to use SMTP
/*
//sohu
$mail->Host = "smtp.sohu.com";  // specify main and backup server
$mail->SMTPAuth = true;   //true  // turn on SMTP authentication
$mail->Username = "liang_0735";  // SMTP username
$mail->Password = "i8u6e73d"; // SMTP password
*/
$mail->From = "webmaster@mwjx.com";
$mail->FromName = "小鱼";
$mail->AddAddress($m_to, "妙文精选邮件订阅用户:".$m_to);
//$mail->AddAddress("liang_0735@163.com");  // name is optional
//$mail->AddReplyTo($mail->From, "Information");
//goto_url("","你要发送这篇文章是吧:".$m_id.",这个邮箱:".$m_to);
$mail->WordWrap = 80; // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("test.csv");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->AddAttachment("/usr/home/mwjx/mwjx.com/image/indeximage/002.gif", "002.gif");   
$mail->IsHTML(true);                                  // set email format to HTML
//$txt = $obj_article->get_txt();
//$obj_article->showtohtml($txt);

$url = "http://www.mwjx.com/mwjx/src_php/add_mail_list.php?id=".$arr_code[0]."&code=".$arr_code[1];
//$txt .= "<br/><br/>发布者:".$obj_article->get_poster()."<br/>";
//$txt .= "原文地址:<a href=\"".$url."\" target=\"_blank\">".$url."</a><br/>";
//$txt .= "<a href=\"http://www.mwjx.com/\">访问妙文精选|www.mwjx.com</a>";
$txt = "请点击以下地址激活，以成为妙文精选邮件订阅有效用户:<br/>";
$txt .= "<a href=\"".$url."\" target=\"_blank\">".$url."</a>";
$mail->Subject = "妙文精选邮件订阅激活";
//$mail->Body    = "This is the HTML message body <b>in bold!</b>";
$mail->Body = "<html><head>
<title>妙文精选邮件用户激活|www.mwjx.com</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
<base target=\"_blank\"/>
</head>
<BODY>
".$txt."
</BODY>
</html>
";

$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send()){
	//echo "Message could not be sent. <p>";
	//echo "Mailer Error: " . $mail->ErrorInfo;
	//exit("发送失败，请重试");
	//exit("订阅失败");
	goto_url("","发送激活邮件失败，可能是系统繁忙，请重试");
}
//exit("订阅成功");
goto_url("","订阅成功，请收邮件激活订阅");

function get_code_byid($id=-1,$t = 1)
{
	//通过订阅ID查询激活码
	//输入:id(int)订阅ID,
	//t(int)代码类型1/2(id,邮箱,日期组合/id,邮箱组合)
	//输出:激活码字符串，异常返回空字符串
	$str_sql = "select id,tomail,last from mail_list where id = '".$id."' and active = 'N';";
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	if(1 != count($arr))
		return "";
	$id = intval($arr[0]["id"]);
	if(1 == $t)
		$code = md5($id.$arr[0]["tomail"].$arr[0]["last"]);
	else
		$code = md5($id.$arr[0]["tomail"]);
	return $code;
}
function get_code($mail="",$t = 1)
{
	//取得激活代码
	//输入:mail(string)订阅邮箱
	//t(int)代码类型1/2(id,邮箱,日期组合/id,邮箱组合)
	//输出:array(id,code),异常返回空数组
	$str_sql = "select id,tomail,last from mail_list where tomail = '".$mail."';";
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	if(1 != count($arr))
		return array();
	$id = intval($arr[0]["id"]);
	if(1 == $t)
		$code = md5($id.$arr[0]["tomail"].$arr[0]["last"]);
	else
		$code = md5($id.$arr[0]["tomail"]);
	return array($id,$code);
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