<?php
//------------------------------
//create time:2007-11-12
//creater:zll
//purpose:���ո���
//------------------------------
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //��ĿID
//$m_id = 170;
if(-1 == $m_id)
	exit(js_empty());
//if("С��" != $_COOKIE['username']){

//	exit("document.write('������Դ���ޣ��˹����ݹرա�&nbsp;&nbsp;<a href=\"/mwjx/track/index.php?id=".$m_id."\">��Ŀ����</a>');\n");
//}
//$m_id = 2; //tests
//exit();
//exit(js_empty());
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$d = 4;
$e = date("Y-m-d",time());
$s = date("Y-m-d",(time()-86400*$d));
$str_sql = "select CA.aid,A.str_title from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid ='".$m_id."' and A.enum_active='Y' and A.enum_father='Y' and dte_post BETWEEN '".$s."' and '".$e."' order by A.dtt_change DESC limit 20;";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
if(count($arr) < 1){ //����û�и��£����հײ��ÿ����þɵ����
	$str_sql = "select CA.aid,A.str_title from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid ='".$m_id."' and A.enum_active='Y' and A.enum_father='Y' order by A.dtt_change DESC limit 18;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();

}
//var_dump($arr);
//exit();
$len = count($arr);
if($len < 1)
	exit(js_empty());
$m_js = "";
$m_js .= "document.write('<UL>');\n";

$str_ls = "";
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i][0]);
	$title_more = $arr[$i][1];
	//if(strlen($title_more)>22)
	//	$title = msubstr($title_more,0,22)."...";
	//else
	//	$title = $title_more;
	$title = $title_more;
	$url = "/bbs/html/".g_dir_from_id($id).$id.".html";
	$str_ls .= "<LI><A href=\"".$url."\" target=\"_blank\" title=\"".$title_more."\">".$title."&nbsp;</A></LI>";
}
$m_js .= "document.write('".$str_ls."');\n";
$m_js .= "document.write('</UL>');\n";
//$m_js .= "</script>";
//var_dump($m_js);
echo $m_js;
exit();

function js_empty()
{
	//δ��¼���
	return "";
}
/*
function dir_from_id($id = 0)
{
	//��������ID����������ھ�̬�ϼ�Ŀ¼��
	//����:id(int)����ID
	//���:Ŀ¼�ַ���,�쳣���ؿ��ַ���
	$num = 2000; //2000���ļ�һ��Ŀ¼��
	return strval((intval(($id-1)/$num)+1)*$num)."/"; 
}
*/
?>