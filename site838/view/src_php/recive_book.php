<?php
//------------------------------
//create time:2007-11-21
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�����鼮
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
//goto_url("","�ϴ��鼮�ɹ�--");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) < 1){
	goto_url("","�ϴ��鼮ʧ�ܣ���ǰ�û���Ч�����ȵ���ҳ��¼��ע��");
}

if(!check_input())
	goto_url("","�ϴ��鼮ʧ�ܣ����ƻ�����Ч");
//�ϴ�ͼƬ
$re = cp_book($obj_man->get_id());
//$img_path = "http://slek.allyes.com/beauty/".$img_path;
if("" == $re)
	goto_url("refresh","�ϴ��鼮�ɹ�");
else
	goto_url("","�ϴ��鼮ʧ�ܣ�ԭ��".$re);
function check_input()
{
	//�������Ƿ���ȷ,���ƻ���
	//����:�ޣ����ύ�����Ĳ���
	//���:true��ȷ��false����
	if(!isset($_POST["book_title"]) || !isset($_POST["book_txt"]) || !isset($_POST["cid"]))
		return false;
	if(strlen($_POST["book_title"]) < 1 ||strlen($_POST["book_title"]) > 255)
		return false;
	if(strlen($_POST["book_txt"]) < 1 ||strlen($_POST["book_txt"]) > 100000)
		return false;
	if(intval($_POST["cid"]) < 1)
		return false;
	return true;
}
function cp_book($uid=0)
{
	//�ϴ��鼮
	//����:uid(int)�û�ID
	//���:�ɹ����ؿ��ַ������쳣��ʧ�ܷ���ʧ��ԭ���ַ���
	if("" == $_FILES['file_book']['name'])
		return "���ļ�1";
	if(!is_file($_FILES['file_book']['tmp_name']))
		return "���ļ�2,".$_FILES['file_book']['error'];
	$max_size = 20*1024*1024;
	if($_FILES['file_book']['size'] > $max_size)
	   return "�������ߴ�20M";
		
	$filename = "";
	$hz = strtolower(strrchr(basename($_FILES['file_book']['name']),"."));
	//goto_url("","OK:".basename($_FILES['file'.$i]['name']));
	//break;
	//return $hz;
	if($hz != ".rar" && $hz != ".zip" && $hz != ".chm" && $hz != ".doc" && $hz != ".pdf" && $hz != ".txt" && $hz != ".xls"){
		//goto_url("","�ļ����ʹ���".__LINE__);
		return "�ļ�������Ч";
	}
	mt_srand((double)microtime()*1000000);
	$filename = md5($_FILES['file_book']['name']."_".(uniqid(mt_rand()))).$hz; 
	//exit($filename);
	//goto_url("",$filename);
	//break;
	$m_dir_upload = "../../data/up_book/";
	$uploadfile = $m_dir_upload.$filename;
	//return $uploadfile;
	if (!move_uploaded_file($_FILES['file_book']['tmp_name'], $uploadfile)) {
	   //goto_url("","��������������".__LINE__);
		return "�����ļ�����";
	} 
	//���
	$title = addslashes($_POST["book_title"]);
	$txt = addslashes($_POST["book_txt"]);
	$cid = intval($_POST["cid"]);
	$str_sql = "insert into book_down (title,txt,fid,aday,poster,filename,size,hz)values('".$title."','".$txt."','".$cid."','".date("Y-m-d",time())."','".$uid."','".$filename."','".$_FILES['file_book']['size']."','".$hz."');";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	return "";
}
function goto_url($url = "",$str = "",$flag=1)
{
	//��תҳ��
	//����:url��Ϊ����ת���õ�ַ,ֵrefreshˢ�µ�ǰ����,
	//str��Ϊ����ʾ����Ϣ
	//flag(int)1/2(������/��ǰ����)
	//���:��
	//����Ҫ��exit���
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