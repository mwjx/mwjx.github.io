<?php
//------------------------------
//create time:2006-6-8
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:���ľ�ѡ����Դ
//------------------------------
require("../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/interface.php");
my_safe_include("lib/fun_global.php");
//my_safe_include("lib/page_info.php");
$m_type = isset($_GET["type"])?$_GET["type"]:""; //��������
$m_fun = isset($_GET["fun"])?$_GET["fun"]:""; //����
$m_id = isset($_GET["id"])?$_GET["id"]:""; //id
$m_page = isset($_GET["page"])?$_GET["page"]:""; //��ҳ
$m_per = isset($_GET["per"])?$_GET["per"]:""; //ÿҳ��¼��
$m_style = isset($_GET["style"])?$_GET["style"]:""; //xsl��ʽ�ļ�
//session_start();
//--------test---------------
//$m_style = "not_style"; //������xsl�ļ���������
//$m_type = "new_good"; //���¾����Ƽ��б�
//$m_id = "8";
//--------end test-----------
//�������ɵ����������б�
$m_arr_type = array("new_good");
if(!check_type($m_type,$m_arr_type))
	exit("����������Ч:".strval($m_type));
//---------��ҳ��Ϣ--------
//$m_obj_page = new c_page_info;
//init_page($m_obj_page,intval($m_page),intval($m_per));
//---------end ��ҳ��Ϣ--------
$str_xml = get_xml($m_type,$m_fun,$m_id,$m_obj_page,$m_style);
//------------����----------
function get_xml($type = "",$fun = "",$id = "",&$page,$style)
{
	//����ȫ��XML�ı�
	//����:type����������,fun����,id�û�ID,page�Ƿ�ҳ��Ϣ����
	//$style����ʽ�ļ�
	//���:xml�ַ���
	$str_xml_fun = "<fun>".$fun."</fun>";
	$obj_face = new c_interface;
	$result = "";
	$result .= get_xml_head($type,$style);
	//$result .= get_xml_head();
	$result .= "<listview>";
	$result .= $str_xml_fun;
	switch($type){
		case "new_good":
			if("" != $_GET["bgcolor"])
				$result .= "<bgcolor>".$_GET["bgcolor"]."</bgcolor>";
			else
				$result .= "<bgcolor>FFFFFF</bgcolor>";
			$result .= get_new_good($obj_face);
			break;
		default:
			assert(0);
			break;
	}
	$result .= "</listview>";
	return $result;
}
//-------------xml���ݺ���Ⱥ-------------
function get_new_good(&$face)
{
	//�����ܱ���
	//����:face�ӿڴ���
	//���:xml�ַ���,�쳣���ؿ��ַ���
	return $face->new_vote_article(1);
	//return $face->get_report_total();
}
//-----------------����Ⱥ---------------
function get_xml_head($type = "",$style = "")
{
	//����ͷ��
	//����:type����������,ǰ������Ҫ��֤type��Ч
	//���:xml�ַ���
	if("" == $type)
		assert(0); //�쳣
	$xsl_file = "";
	switch($type){
		default:
			$xsl_file = $type;
			break;
	}
	$xsl_path = "include/xsl/".$xsl_file.".xsl";
	$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
	if("not_style" == $style)
		$str_xsl = "";
	return "<?xml version=\"1.0\"  encoding=\"gb2312\"?>".$str_xsl;
}
function check_type($type = "",&$arr)
{
	//������������Ƿ���Ч
	//����:type�����������ַ���
	//���:��Ч����true,���򷵻�false
	if(("string" != gettype($type)) || ("" == $type))
		return false;
	//$arr = array("total_view","settle_left");
	foreach($arr as $name){
		if($type == $name)
			return true;
	}
	return false;
}
?>
<?php
print_xml($str_xml);
?>
