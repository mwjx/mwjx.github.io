<?php
//------------------------------
//create time:2007-6-8
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��̬��Ŀ��ҳ����
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
//$_COOKIE['username'] ="";
if("" == $_COOKIE['username']){
	$m_cid = intval(isset($_GET["cid"])?$_GET["cid"]:""); //��ĿID
	$url = "/data/".$m_cid.".html";
	exit("��̬��ַֻ�޻�Ա���ʡ�<br/>����Ŀ��̬��ַ��<a href=\"".$url."\">".$url."</a><br/><a href=\"http://www.mwjx.com/\"><b>�������ľ�ѡ</b></a>");
}
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/class_query.php");
my_safe_include("mwjx/top_star.php");
$m_cid = intval(isset($_GET["cid"])?$_GET["cid"]:""); //��ĿID
//$m_page = intval(isset($_GET["page"])?$_GET["page"]:""); //ҳ��
//$m_per = intval(isset($_GET["per"])?$_GET["per"]:""); //ÿҳ��¼��
//����ʹ��������:list/manager(�����б�/���¹���)
//$m_type = (isset($_GET["type"])?$_GET["type"]:"list"); 
//�����������ַ��������û�ID
//$m_str = (isset($_GET["str"])?$_GET["str"]:""); 
//if("" == $m_str)
//	$m_str = (isset($_POST["str"])?$_POST["str"]:""); 
//$m_str = addslashes($m_str); 
//var_dump($_REQUEST);
//echo $m_str."---";

//------test-----
//-------��Ŀ��ҳ------
//$m_cid = 1;
/*
*/
$obj = new c_class_info($m_cid);
if($obj->get_id() < 1)
	exit("��Ŀ������");
//$str_xml = ($obj->data_class($m_page,$m_per,$all));
$path_xsl = "../include/xsl/class_homepage.xsl";
$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$path_xsl."\"?>\n";
$path_img = "../images/tech_star1.gif";
$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>\n";
$str_xml .= $str_xsl;
$str_xml .= "<listview>\n";
$str_xml .= "<path_img>".$path_img."</path_img>\n";
//$str_xml .= "hello\n";
$obj_q = new c_class_query;
$str_xml .= $obj->xml_info($obj_q->class_class($obj->get_id())); //һ����Ϣ
//$str_xml .= $obj->xml_reply(); //�����б�
$str_xml .= $obj->xml_new(18); //��������
//��Ŀ��Ϣ
//$str_xml .= xml_class_dir($m_cid);
//��Ŀ�Ƽ�����,������δ���
//$str_recommend = $obj->xml_recommend(25);
//if("" == $str_recommend)
//	$str_xml .= "<recommend name=\"�����Ƽ�\"></recommend>";
//else
//	$str_xml .= $str_recommend;
//--------�Ǽ���Ŀ-------
//$img_star = get_dir_home()."../../mwjx/images/tech_star1.gif";
//$str_content .= "<path_img>".$img_star."</path_img>\n";
//$obj_ts = new c_top_star;
//$arr_ts = ($obj_ts->lists(3,0,2));
//$arr_ts[1] = 3;
//var_dump($arr_ts);
//exit();
//$num_star = isset($arr_ts[$m_cid])?$arr_ts[$m_cid]:0;
//for($i = 0;$i < $num_star; ++$i){
//	$str_xml .= "<img_star/>\n";
//}
//------end �Ǽ���Ŀ------
$str_xml .= "</listview>\n";
if("" == $str_xml)
	exit("��Ŀ����Ϊ��");
print_xml($str_xml);
//echo "aa";									
function xml_class_dir($id=-1)
{
	//��Ŀ��Ŀ��Ϣ
	//����:id(int)��ĿID
	//���:xml�ַ���
	$xml = "";
	$str_sql = "select * from class_dir where cid = '".$id."' order by orderid ASC limit 200;";
	//exit($str_sql);
	$sql = new mysql();
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	//var_dump($arr);
	//exit();
	$xml .= "<class_dir>";
	$len = count($arr);
	//for($k = 0;$k < 3; ++$k){
	for($i = 0;$i < $len; ++$i){
		$d_title = $arr[$i]["title"];
		$content = $arr[$i]["content"];
		$xml .= "<dir title=\"".htmlspecialchars($d_title)."\">";
		$row = explode("\n",$content);
		$len2 = count($row);
		for($j = 0;$j < $len2; ++$j){
			$line = trim($row[$j]);
			if("" == $line)
				continue;
			$col = explode("`|)",$line);
			if(2 != count($col))
				continue;
			
			//$tmp = explode();
			$xml .= "<item><id>".$col[0]."</id><title>".htmlspecialchars($col[1])."</title></item>";
		}
		$xml .= "</dir>";
	}
	//}
	$xml .= "</class_dir>";
	return $xml;
}
?>

