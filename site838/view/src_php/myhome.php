<?php
//------------------------------
//create time:2006-12-29
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ҵļ�
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
//-----------�°�-----------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/mylibpage.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //�û�ID
if(-1 == $m_id){ //�ҵ�����
	my_safe_include("class_man.php");
	$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
	$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
	$man_me = new manbase_2($currentuser,$currentpass);
	if($man_me->get_id() > 0)
		$m_id = $man_me->get_id();
}
$obj_hp = new c_mylibpage;
echo ($obj_hp->html_mylibpage($m_id)); //16
exit();
//---------end �°�---------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/my_mwjx.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //�û�ID
$m_name = (isset($_GET["name"])?$_GET["name"]:""); //�û���
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
//---------test---------
//$m_id = 200200068;
//$m_name = "С��";

$man_me = new manbase_2($currentuser,$currentpass);
if($m_id < 1)
	$aman = new manbase_2($m_name);
else
	$aman = new manbase_2($m_id);
if($aman->get_id() < 1)
	exit("�û���Ч:".$m_id."-".$m_name); 
//��<a href=\"../login.php\">��¼</a>
//info_xml
$str_xml = "<?xml version=\"1.0\"  encoding=\"gb2312\"?>\n";
$xsl_path = "../include/xsl/myhome.xsl";
$str_xml .= "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
$str_xml .= "<myhome>";
$str_xml .= $aman->info_xml();
if($man_me->get_id() == $aman->get_id()){ //�ҵ�IP		
	$str_xml .= "<i_ip>".strval(ip2int($_SERVER[REMOTE_ADDR]))."</i_ip>";
}
if($man_me->get_id() == $aman->get_id()){ //�ҵ���Ϣ�б�
	$str_xml .= "<msglist/>";
}
//�ҵ�������
$obj = new c_my_mwjx;
$str_xml .= "<article_num>".strval($obj->article_num($aman->get_id()))."</article_num>";
$pv_num = get_my_pv($aman->get_name());
$str_xml .= "<my_pv>".(number_format($pv_num,0,".",","))."</my_pv>";
//��������
my_safe_include("mwjx/search.php");
//$flag = 0;
$obj_search = new c_search;
$arr = ($obj_search->user_article_arr($m_id,10));
$str_xml .= "<article_new>";
foreach($arr as $row){
	//</title>ǰ��һ���Է��ַ����Ե�����ʱ������뷽����2007-7-4
	$id = intval($row[0]);	
	$url = "/mwjx/src_php/data_article.php?id=".strval($id);
	$url .= "&amp;state=dynamic";
	$str_xml .= "<item>\n<id>".$row[0]."</id>\n<title>".htmlspecialchars($row[1])." </title>\n<poster>".$row[2]."</poster>\n<dte>".$row[3]."</dte>\n<url>".$url."</url>\n</item>\n";
}		
$str_xml .= "</article_new>\n";

/*
*/
$str_xml .= "</myhome>";
print_xml($str_xml);

function get_my_pv($name="")
{
	//�ҵ���ҳ�������
	//����:name(string)�û���
	//���:����
	//ǰ�ñ�֤������Ч
	$str_sql = "select sum(int_click) as 'click' from tbl_article where str_poster = '".$name."' and enum_active = 'Y' and enum_father = 'Y';";
	//echo ($str_sql)."<br/>";
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	return intval($arr[0][0]);
}
?>