<?php
//------------------------------
//create time:2007-8-13
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:Զ���ı��滻����
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
	exit("<a href=\"/mwjx/login.php\">���¼</a>");
//Ȩ��
$obj = new c_authorize;		
if(!$obj->can_do($obj_man,1,1,19)){
	exit("��Ȩ�޸�");		
}
//$test = "http://localhost/index.html";
//$path = (get_path($test));
//$txt = get_txt($test);
//var_dump(get_txt($test));
//exit();
$m_fun = isset($_POST["fun"])?$_POST["fun"]:"";
$m_url = isset($_POST["txt_url"])?$_POST["txt_url"]:""; //Ҫ�޸ĵ�URL
$m_txt = ""; //ԭʼ�ı�
//$m_txt = isset($_POST["content_all"])?$_POST["content_all"]:""; 
switch($m_fun){
	case "get_txt": //ȡԭʼ�ı�
		//goto_url("",$_POST["txt_url"]);
		
		$m_txt = get_txt($m_url);
		//goto_url("",);
		break;
	case "commit_txt": //�ύ�ı�
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
			goto_url("","�޸ĳɹ�");
		else
			goto_url("","�޸�ʧ��");
		break;
	default:
		break;
}
function commit_txt($url = "",$txt="")
{
	//�ύ�ı�
	//����:url(string),txt(string)�ı�����
	//���:true,false
	if("" == $url)
		return false;
	//��URLȡ��·��
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
	//����url�ı�
	//����:url(string)URL
	//���:�ı��ַ���
	if("" == $url)
		return "";
	//��URLȡ��·��
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
	//��url��ȡ��·��
	//����:url(string)
	//���:·���ַ���
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
<HTML>
<HEAD>
<TITLE> Զ���ı��滻���� </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<script language="javascript">
function get_txt()
{
	if("" == document.all["txt_url"].value)
		return alert("URL����Ϊ��");
	document.all["fun"].value = "get_txt";
	document.all["frmsubmit"].target = '_self';
	document.all["frmsubmit"].action = './text_replacement.php';
	document.all["frmsubmit"].submit();	
	return; // alert("ȡ��ԭ�ı�");
	//return document.all["title_all"].value;
}
function commit()
{
	//�ύ
	//����:��
	//���:��
	if("" == document.all["txt_url"].value)
		return alert("URL����Ϊ��");
	document.all["fun"].value = "commit_txt";
	document.all["frmsubmit"].target = 'submitframe';
	//document.all["frmsubmit"].target = '_self';
	document.all["frmsubmit"].action = './text_replacement.php';
	document.all["frmsubmit"].submit();	
	//return; // alert("ȡ��ԭ�ı�");
}
function view()
{
	//Ԥ��
	//����:��
	//���:��
	if("" == document.all["txt_url"].value)
		return alert("URL����Ϊ��");
	window.open(document.all["txt_url"].value);
	//alert("Ԥ��");
}
function init()
{
	//��ʼ
	//run();
}
</script>
</HEAD>

<BODY onload="javascript:init();">
<table>
<tr><td>
ȫ������
</td></tr>
<form id="frmsubmit" name="frmsubmit"  action="" method="POST" target="submitframe">
<input type="hidden" name="fun" value=""/>
<tr><td>
Ҫ�޸ĵ�URL:<input type="text" name="txt_url" value="<?=$m_url;?>" size="50"/>
</td></tr>
<tr><td>
<textarea cols="80" name="content_all" rows="17" style="FONT-SIZE: 9pt"><?=$m_txt;?></textarea>
</td></tr>
<tr><td align="center">
<button onclick="javascript:get_txt();">��ȡԭʼ�ı�</button>&nbsp;&nbsp;<button onclick="javascript:commit();">�ύ�޸�</button>
&nbsp;&nbsp;<button onclick="javascript:view();">Ԥ��</button>
</td></tr>
</form>
</table>
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>
