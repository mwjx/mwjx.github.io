<?php
//------------------------------
//create time:2007-8-8
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�����ʼ��б�
//------------------------------
require("phpmailer/class.phpmailer.php");
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//���յ�ַ
$m_to = trim(isset($_POST["txt_email"])?$_POST["txt_email"]:""); 
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //�����û�ID
//ȡ�������û�ID
$m_cancelid = intval(isset($_GET["cancelid"])?$_GET["cancelid"]:-1); 
$m_code = isset($_GET["code"])?$_GET["code"]:""; //������
//$m_to = "liang_0735@163.com"; //test
/*
if("" != $m_code && $m_cancelid > 0){ //ȡ������
	$code = get_code_byid($m_cancelid,2);	
	if("" == $code)
		exit("��������");
	if($m_code != $code)
		exit("��������Ч");
	//exit("fff");
	//��ʼȡ��
	$str_sql = "update mail_list set active ='N' where id = '".$m_cancelid."';";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	exit("ȡ�����ĳɹ���</br><a href=\"http://www.mwjx.com/\">�ص����ľ�ѡ</a>");	
}
*/
if("" != $m_code && $m_id > 0){ //����
	$code = get_code_byid($m_id);	
	if("" == $code)
		exit("���������ڻ��Ѿ��Ǽ����û�");
	if($m_code != $code)
		exit("��������Ч");
	//exit("fff");
	//��ʼ����
	$str_sql = "update mail_list set active ='Y' where id = '".$m_id."';";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	exit("��ϲ�㣬����ɹ�������������㽫����������յ���һ�θ����ʼ���</br><a href=\"http://www.mwjx.com/\">�ص����ľ�ѡ</a>");
}
//goto_url("","a:".($m_to));
if("" == $m_to){
	goto_url("","����ʧ��,����д����");
	exit();
}
if(strlen($m_to) > 255){
	goto_url("","����ʧ��,���䳤�Ȳ��ܳ���255���ַ�");
	exit();
}

if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$m_to)) {
	goto_url("","����ʧ��,������Ч,�뻻һ����������");
	exit();
}
//�Ƿ��Ѷ���
$str_sql = "select active from mail_list where tomail = '".$m_to."';";
$sql=new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
if(count($arr) > 0){ //�Ѷ���
	if("Y" == $arr[0][0]){ //�Ѽ���
		goto_url("","����ʧ��,��������Ѿ��������ʼ�:".$m_to);
		exit();
	}
	//exit("δ����");
	//δ������ͼ����ʼ�
}
else{ //δ����
	//���붩���б�
	$str_sql = "insert into mail_list (tomail,last)values('".$m_to."','".date("Y-m-d",time())."');";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
}
$arr_code = get_code($m_to);
if(2 != count($arr_code)){
	goto_url("","����ʧ��,�����쳣");
	exit();	
}
//var_dump($arr_code);
//exit();
//���ͼ����ʼ�
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
$mail->AddAddress($m_to, "���ľ�ѡ�ʼ������û�:".$m_to);
//$mail->AddAddress("liang_0735@163.com");  // name is optional
//$mail->AddReplyTo($mail->From, "Information");
//goto_url("","��Ҫ������ƪ�����ǰ�:".$m_id.",�������:".$m_to);
$mail->WordWrap = 80; // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("test.csv");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->AddAttachment("/usr/home/mwjx/mwjx.com/image/indeximage/002.gif", "002.gif");   
$mail->IsHTML(true);                                  // set email format to HTML
//$txt = $obj_article->get_txt();
//$obj_article->showtohtml($txt);

$url = "http://www.mwjx.com/mwjx/src_php/add_mail_list.php?id=".$arr_code[0]."&code=".$arr_code[1];
//$txt .= "<br/><br/>������:".$obj_article->get_poster()."<br/>";
//$txt .= "ԭ�ĵ�ַ:<a href=\"".$url."\" target=\"_blank\">".$url."</a><br/>";
//$txt .= "<a href=\"http://www.mwjx.com/\">�������ľ�ѡ|www.mwjx.com</a>";
$txt = "�������µ�ַ����Գ�Ϊ���ľ�ѡ�ʼ�������Ч�û�:<br/>";
$txt .= "<a href=\"".$url."\" target=\"_blank\">".$url."</a>";
$mail->Subject = "���ľ�ѡ�ʼ����ļ���";
//$mail->Body    = "This is the HTML message body <b>in bold!</b>";
$mail->Body = "<html><head>
<title>���ľ�ѡ�ʼ��û�����|www.mwjx.com</title>
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
	//exit("����ʧ�ܣ�������");
	//exit("����ʧ��");
	goto_url("","���ͼ����ʼ�ʧ�ܣ�������ϵͳ��æ��������");
}
//exit("���ĳɹ�");
goto_url("","���ĳɹ��������ʼ������");

function get_code_byid($id=-1,$t = 1)
{
	//ͨ������ID��ѯ������
	//����:id(int)����ID,
	//t(int)��������1/2(id,����,�������/id,�������)
	//���:�������ַ������쳣���ؿ��ַ���
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
	//ȡ�ü������
	//����:mail(string)��������
	//t(int)��������1/2(id,����,�������/id,�������)
	//���:array(id,code),�쳣���ؿ�����
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