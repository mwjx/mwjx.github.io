<?php
//------------------------------
//create time:2006-12-26
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:������˵�
//------------------------------
//if("С��" != $_COOKIE['username']){
//	$html = "������Դ���ƣ���������ʱ�رա�";	
//	exit($html);
//}
require_once("../../class/function.inc.php");
require_once("./fun_global.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/authorize.php");
//var_dump(xml_class());
//exit();
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
$aman = new manbase_2($currentuser,$currentpass);
$str_xml = "";
$str_xml .= get_xml_head("settle_left","");
$str_xml .= "<listview>";
$m_newmsg = $aman->had_newmsg();
//exit("aa");
if($m_newmsg)
	$str_xml .= "<had_newmsg src=\"/mwjx/images/msg.wav\"/>";
$str_xml .= get_settle_left($aman,$m_newmsg);
$str_xml .= "</listview>";
//var_dump($str_xml);
//$str_xml = "<root></root>\r\n\r\n";
print_xml($str_xml);
function get_xml_head($type = "",$style = "")
{
	//����ͷ��
	//����:type����������,ǰ������Ҫ��֤type��Ч
	//���:xml�ַ���
	//return  "";
	if("" == $type)
		assert(0); //�쳣
	$xsl_path = "../include/xsl/".$type.".xsl";
	$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
	//$str_xsl = "";
	if("not_style" == $style)
		$str_xsl = "";
	return "<?xml version=\"1.0\"  encoding=\"gb2312\"?>".$str_xsl;
}
function get_settle_left(&$o,$newmsg=false)
{
	//�����˵�
	//����:o���û�����,newmsg(bool)�Ƿ�������Ϣ
	//���:xml�ַ���
	//$path_main = "../../data/12_20_1.xml";
	//$path = "./data_class.php?cid=12&amp;page=1&amp;per=20";
	$result = "";
	//$result .= "<item text=\"���ľ�ѡ\" href=\"".$path."\"></item>\n";
	//$result .= xml_class();
	$obj = new c_authorize;		
	if($o->get_id() > 0){
		$url = "./myhome.php?id=".$o->get_id();
		$result .= "<item text=\"�ҵ�����\"  href=\"".$url."\"";
		if($newmsg)
			$result .= " newmsg_img=\"/mwjx/images/newmail.gif\" ";
		$result .= ">";		
		$result .= "<item text=\"�ҵ�����\" href=\"".$url."\"/>";
		$url = "./my_power.php?id=".$o->get_id();
		$result .= "<item text=\"�ҵ�Ȩ��\" href=\"".$url."\"/>";
		$result .= "</item>";
		$result .= "<item text=\"��Ŀ����\" href=\"./data_all_class.php?type=class\">\n";	
		$result .= "<item text=\"��Ŀ����\" href=\"./class_link.php\"></item>\n";	
		$result .= "<item text=\"��Ŀ��Ŀ\" href=\"./class_dir.php\"></item>\n";	
		$result .= "<item text=\"����׷��\" href=\"./book_unover.php\"></item>\n";	
		$result .= "</item>\n";	
		$result .= "<item text=\"���¹���\" href=\"./article_manager.php\">";
		if($obj->can_do($o,1,1,12)){
			$result .= "<item text=\"��������\" href=\"./supper_poster.php\"></item>\n";
		}		
		$result .= "</item>\n";
		$result .= "<item text=\"���ӹ���\" href=\"./link_manager.php\"></item>\n";
	}
	if($obj->can_do($o,1,1,5)){
		$result .= "<item text=\"�������\" href=\"./other_manager.php\">\n";
		if($obj->can_do($o,1,1,5)){
			$result .= "<item text=\"�ı��滻\" href=\"./text_replacement.php\"></item>\n";
		}
		$result .= "</item>\n";
	}
	if($obj->can_do($o,1,1,17)){
		$result .= "<item text=\"��������\" href=\"./cash_manager.php\"></item>\n";
	}

	if($o->check_super_manager()){ //��������Ա

		
		$result .= "<item text=\"��������\" href=\"./garbage_article.php\"></item>\n";
	}
	$name = isset($_COOKIE['username'])?$_COOKIE['username']:"";
	if("" == $name){	//δ��¼
		$title = "��¼/ע��";
		$result .= "<item text=\"".$title."\" href=\"../login.php?fun=login\"/>\n";
	
	}
	else{ //�����ѵ�¼
		$title = "�˳�";
		$result .= "<item text=\"".$title."\" href=\"../login.php?fun=logout\"/>\n";

	}
	//$result .= "<button>ɾ��</button>";
	return $result;
}

?>