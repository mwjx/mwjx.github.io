<?php
//------------------------------
//create time:2006-5-11
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ʼ�������
//------------------------------
//exit();
require("./class.phpmailer.beta.php");
require_once("./class.smtp.beta.php");
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
exit();
//my_safe_include("class_article.php");
//$mail = new phpmailer();
//$mail->IsSMTP(); // set mailer to use SMTP
/*
$host = "localhost";
$port = 25;
$timeout = 10;
$smtp = new SMTP;
if(!$smtp->Connect($host, $port,$timeout))
	exit("connect fail");
if(!$smtp->Hello("localhost"))
	exit("hello fail");

exit("SEND OK");
*/
define("SMTP_SERVER_ADDR", "localhost"); //������ΪSMTP����
define("SMTP_DOMAIN", "localhost");
$from = "webmaster@mwjx.com";
$to = "liang_0735@21cn.com";
$message = "hello";
$fromName = "mwjx";
$subject = "subject";
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=gb2312\r\n";
$headers .= "Content-Transfer-Encoding: base64\r\n";
$arr_to = array("liang_0735@21cn.com","liang_0735@sina.com","liang_0735@163.com","liang_0735@sohu.com","liang0735@gmail.com","ll_zhou@allyes.com");
$smtpfp = fsockopen(SMTP_SERVER_ADDR, 25, $errno,$errstr,10);
if(!$smtpfp)
	exit("fsockopen fail");
$res = fgets($smtpfp, 256);
if (substr($res,0,3) != "220")
	exit("connect fail:".$res);
//echo $res."<br/>";
//var_dump($smtpfp);
fputs($smtpfp, "HELO ".SMTP_DOMAIN."\r\n");
$res = fgets($smtpfp, 256);
if (substr($res,0,3) != "250")
	exit("HELO fail:".$res);
//$res = fgets($smtpfp, 256);
//echo $res."<br/>\n";
fputs($smtpfp, "MAIL FROM: ".$from."\r\n");
$res = fgets($smtpfp, 256);
if (substr($res,0,3) != "250")
	exit("mail from fail");

$len = count($arr_to);
for($i = 0;$i < $len;++$i){
	$to = $arr_to[$i];
	fputs($smtpfp, "RCPT TO: ".$to."\r\n");
	$res = fgets($smtpfp, 256);
	if (substr($res,0,3) != "250"){
		echo ($to.",rcpt to fail:".$res."<br/>");
		continue;
	}
}
fputs($smtpfp, "DATA\r\n");
$res = fgets($smtpfp,256);
if (substr($res,0,3) != "354"){
	echo ("data fail".$res."<br/>\n");
	exit();
}
$message = chunk_split(base64_encode(StripSlashes($message)));
fputs($smtpfp, "To: ".$to."\r\nFrom: ".$fromName."\r\nSubject: ".$subject."\r\n".$headers."\r\n\r\n".$message."\r\n.\r\n");
$res = fgets($smtpfp,256);
if (substr($res,0,3) != "250"){
	echo ("body fail".$res."<br/>\n");
	exit();
}
//---------����-------------
fputs($smtpfp, "QUIT\n");
$res = fgets($smtpfp, 256);
//echo $res."<br/>\n";
if (substr($res,0,3) != "221")
	exit("quit fail");
fclose ($smtpfp);
//var_dump($smtpfp);
exit("SEND OK");

//goto_url("","��Ҫ������ƪ�����ǰ�:".$m_id.",�������:".$m_to);


$mail = new phpmailer();
//$mail->IsMail();
//$mail->IsSendmail();
$mail->IsSMTP(); // set mailer to use SMTP
//localhost
//$mail->Host = "localhost";  // specify main and backup server
//$mail->SMTPAuth = true;   //true  // turn on SMTP authentication
//$mail->Username = "liang_0735";  // SMTP username
//$mail->Password = "i8u6e73d"; // SMTP password
/*
$mail->Host = "smtp.163.com";  // specify main and backup server
$mail->SMTPAuth = true;   //true  // turn on SMTP authentication
$mail->Username = "liang_0735";  // SMTP username
$mail->Password = "3864682"; // SMTP password
*/
/*
//sohu
$mail->Host = "smtp.sohu.com";  // specify main and backup server
$mail->SMTPAuth = true;   //true  // turn on SMTP authentication
$mail->Username = "liang_0735";  // SMTP username
$mail->Password = "i8u6e73d"; // SMTP password
*/
$mail->From = "webmaster@mwjx.com";
$mail->FromName = "С��";

$m_to = "liang_0735@sina.com";
$mail->AddAddress($m_to,"���ľ�ѡ�û�");
$m_to = "liang_0735@163.com";
$mail->AddBCC($m_to,"���ľ�ѡ�û�");
$m_to = "liang_0735@21cn.com";
$mail->AddBCC($m_to,"���ľ�ѡ�û�");
$m_to = "liang_0735@sohu.com";
$mail->AddBCC($m_to,"���ľ�ѡ�û�");
$m_to = "liang0735@gmail.com";
$mail->AddBCC($m_to,"���ľ�ѡ�û�");
$m_to = "ll_zhou@allyes.com";
$mail->AddBCC($m_to,"���ľ�ѡ�û�");

//AddBCC
//$mail->AddAddress($m_to, "���ľ�ѡ�û�:".$m_to);
//$mail->AddAddress("liang_0735@163.com");  // name is optional
//$mail->AddReplyTo($mail->From, "Information");
//goto_url("","��Ҫ������ƪ�����ǰ�:".$m_id.",�������:".$m_to);
$mail->WordWrap = 80; // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("test.csv");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->AddAttachment("/usr/home/mwjx/mwjx.com/image/indeximage/002.gif", "002.gif");   
$mail->IsHTML(true);                                  // set email format to HTML
$txt = "aaa333";

$txt .= "<a href=\"http://www.mwjx.com/\">�������ľ�ѡ|www.mwjx.com</a>";
$mail->Subject = "���ľ�ѡ�ʼ�";
//$mail->Body    = "This is the HTML message body <b>in bold!</b>";
$mail->Body = "<html><head>
<title>|www.mwjx.com</title>
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
	echo "Message could not be sent. <p>";
	echo "Mailer Error: " . $mail->ErrorInfo;
	exit("����ʧ�ܣ�������");
	//goto_url("","����ʧ�ܣ�������ϵͳ��æ��������");
}
var_dump($mail->arr_smtp_ok);
echo "Message has been sent";
echo "���ͳɹ�";

function goto_url($url = "",$str = "",$flag=1)
{
	//��תҳ��
	//����:url��Ϊ����ת���õ�ַ,ֵrefreshˢ�µ�ǰ����,
	//str��Ϊ����ʾ����Ϣ
	//flag(int)1/2(������/��ǰ����)
	//���:��
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