<?php
//------------------------------
//create time:2007-9-3
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:����׷��
//------------------------------
require_once("../../aboutfish/fishcountry/class/function.inc.php");
//require_once("./fun_global.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/mwjx_cash.php");
my_safe_include("mwjx/authorize.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) < 1){
	exit("��ǰ�û���Ч�����ȵ���ҳ��¼��ע��");
	//exit("��ǰ�û���Ч");
}
//$obj = new c_authorize;		
//if(!$obj->can_do($obj_man,1,1,17)){ //��Ȩ���ȴ����
//	exit("��Ȩ��");
//}

//$m_obj = new c_mwjx_cash;
//exit("aaa");

function show_html()
{
	//����html����
	//����:��
	//���:��
	$html = "";
	$str_sql = "select B.*,C.name from book_unover B left join class_info C on B.cid = C.id;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	$html .= "<table width=\"100%\">";
	//<td width=\"20%\">md5</td>
	$html .= "<thead><tr bgcolor=\"#EEEEEE\"><td width=\"25%\">ʱ��(<font color=\"red\">��ɫ�и���</font>)</td><td width=\"15%\">����</td><td>URL</td></tr></thead><tbody>";
	echo $html;
	$html = "";
	for($i = 0;$i < $len; ++$i){
		$title = $arr[$i]["name"];
		$url = $arr[$i]["url"];
		$md5old = $arr[$i]["md5"];
		$md5 = fgets_html($url);
		$modify = $arr[$i]["modify"];
		if("" != $md5 && $md5old != $md5){ //����
			$modify = date("Y-m-d H:i:s",time());
			$str_sql = "update book_unover set md5='".$md5."',modify='".$modify."' where id='".$arr[$i]["id"]."';";
			//exit($str_sql);
			$sql = new mysql;
			$sql->query($str_sql);
			$sql->close();
			$modify = "<font color=\"red\">".$modify."</font>";						
		}
		else{
			$md5 = $md5old;
		}
		//if("" != $md5)
		$html .= "<tr>";
		//$html .= "<td>".$md5."</td>";
		$html .= "<td>".$modify."</td>";
		$html .= "<td>".$title."</td>";
		$html .= "<td><a href=\"".$url."\" target=\"_blank\">".$url."</a>"."</td>";
		$html .= "</tr>\n";
		echo $html;
		$html = "";
	}
	//var_dump($arr);
	//exit();
	$html .= "</tbody></table>";
	echo $html;
	$html = "";
	//return $html;
}
function fgets_html($url="")
{
	//ȡ��һ��url�����ݵ�hash
	//����:url(string)·��
	//���:md5�ַ������쳣���ؿ��ַ���
	$fp = fopen($url, "r");
	if(!$fp)
		return "";
	$html = "";
	while($line = fgets($fp,4096))
		$html .= $line;
	fclose($fp);
	if("" == $html)
		return "";
	$md5 = md5($html);
	return $md5;
	/*
	*/
	//http://www.qbxs.cn/modules/article/reader.php?aid=49
	/*
	$html = "";	
	$fp = fsockopen("www.qbxs.cn", 80, &$errno, &$errstr, 10);
	if(!$fp)
		return "";
	fputs($fp,"GET /modules/article/reader.php?aid=49 HTTP/1.0\nHost: www.qbxs.cn\n\n");
	while(!feof($fp)) {
			$html .= fgets($fp,1024);
	}
	fclose($fp);
	if("" == $html)
		return "";
	return md5($html);
	*/
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312"/>
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
</HEAD>

<BODY>
<?php
show_html();
?>
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>
