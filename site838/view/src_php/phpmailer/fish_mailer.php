<?php
//------------------------------
//create time:2006-5-11
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ʼ�������
//------------------------------
//exit();
require("./class.phpmailer.php");
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_article.php");

$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //Ҫ���͵�����ID
$m_to = (isset($_POST["hd_email"])?$_POST["hd_email"]:""); //���յ�ַ
//$m_id = 5469; //test
//$m_to = "liang_0735@sina.com";
//goto_url("","��Ҫ������ƪ�����ǰ�:".$m_id.",�������:".$m_to);
if("" == $m_to || $m_id < 1)
	goto_url("","���յ�ַ����Ϊ�ջ�����ID��Ч");
//exit("���յ�ַ����Ϊ�ջ�����ID��Ч");
$obj_article = new articlebase($m_id,"","Y"); 
if($obj_article->get_id() < 1)
	goto_url("","������Ч");//exit("������Ч");

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
$mail->FromName = "С��";
$mail->AddAddress($m_to, "���ľ�ѡ�û�:".$m_to);
//$mail->AddAddress("liang_0735@163.com");  // name is optional
//$mail->AddReplyTo($mail->From, "Information");
//goto_url("","��Ҫ������ƪ�����ǰ�:".$m_id.",�������:".$m_to);
$mail->WordWrap = 80; // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("test.csv");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->AddAttachment("/usr/home/mwjx/mwjx.com/image/indeximage/002.gif", "002.gif");   
$mail->IsHTML(true);                                  // set email format to HTML
$txt = $obj_article->get_txt();
$obj_article->showtohtml($txt);
$url = "http://www.mwjx.com".$obj_article->get_url_dynamic($m_id,12);
$txt .= "<br/><br/>������:".$obj_article->get_poster()."<br/>";
$txt .= "ԭ�ĵ�ַ:<a href=\"".$url."\" target=\"_blank\">".$url."</a><br/>";
$txt .= "<a href=\"http://www.mwjx.com/\">�������ľ�ѡ|www.mwjx.com</a>";
$mail->Subject = "���ľ�ѡ�ʼ�:".$obj_article->get_title();
//$mail->Body    = "This is the HTML message body <b>in bold!</b>";
$mail->Body = "<html><head>
<title>".$obj_article->get_title()."|www.mwjx.com</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
<base target=\"_blank\"/>
</head>
<BODY>
".$txt."
</BODY>
</html>
";
/*
if (($str_txt = $this->get_txt()) == false){
return false;
}
else{
$this->showtohtml($str_txt);
$strcenterhtml .= ($str_ads_google.$str_txt."".$str_ads_google2);
}
*/
$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send()){
	//echo "Message could not be sent. <p>";
	//echo "Mailer Error: " . $mail->ErrorInfo;
	//exit("����ʧ�ܣ�������");
	goto_url("","����ʧ�ܣ�������ϵͳ��æ��������");
}

//echo "Message has been sent";
//echo "���ͳɹ�";
//��¼
$str_sql = "insert into mail_rc (oid,tomail,modify)values('".$m_id."','".$m_to."','".date("Y-m-d H:i:s",time())."');";
$sql=new mysql;
$sql->query($str_sql);
$sql->close();
goto_url("","���ͳɹ�,���¡�".$obj_article->get_title()."�������͵���".$m_to);

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