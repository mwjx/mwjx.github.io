<?php
//------------------------------
//create time:2007-11-21
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ϴ��鼮
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //��ĿID
//$m_id = 12; //tests

$str_sql = "select name from class_info where id = ".$m_id.";";
//$m_arr_re = array("",$name."--".$money);
//break;
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();
if(1 != count($arr))
	exit("��Ŀ��Ч��".$m_id);
$cname = $arr[0][0];
/**/
//$len = count($arr);
$html = "";
$html .= "<center><a href=\"http://www.mwjx.com/\">�������ľ�ѡ</a>&nbsp;&nbsp;&nbsp;&nbsp;</center>";
$html .= "<div style=\"border:1px #BECEE6 solid;background:#fff\">
<table width=\"100%\" bgcolor=\"#E1EFFA\" style=\"border-bottom:1px #BECEE6 solid;\">
<tr><td style=\"padding:0 0 0 10px;font-size:14px;\">
��ĿID��".$m_id."&nbsp;&nbsp;&nbsp;&nbsp;��Ŀ���ƣ���".$cname."��
</td></tr>";
$html .= "</table>";
$html .= "</div>";
$html .= html_form($m_id);
function html_form($id = -1)
{
	//��������
	//����:id(int)��ĿID
	//���:html�ַ���
	//��֯����
	//�γ��ַ���
	$html = "";
	$html .= "<!--start�ϴ��鼮//-->
<TABLE cellSpacing=0 border=0 width=\"100%\" align=\"center\">
<TBODY>
<TR>
<TD 
style=\"PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px; BORDER-BOTTOM: #e7dc86 1px solid\" 
bgColor=#fef9cf><IMG height=11 hspace=6 src=\"/mwjx/images/start_with.gif\" 
  width=5>�ϴ��鼮</TD></TR></TBODY></TABLE>
	<form name=\"frm_up_book\" method=\"post\" enctype=\"multipart/form-data\" action=\"/mwjx/src_php/recive_book.php\" target=\"submitframe\">
<table width=\"70%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"20971520\">
	  <tr>
<td align=\"center\">
  <table width=\"92%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
	  <td align=\"right\">���ƣ�</td>
	  <td align=\"left\"><input type=\"text\" name=\"book_title\" value=\"\"/>
<input name=\"cid\" type=\"hidden\" value=\"".$id."\"/>

	  </td>
	</tr>
	<tr>
	  <td align=\"right\">��飺</td>
	  <td align=\"left\"><textarea name=\"book_txt\" cols=\"60\" rows=\"5\"></textarea>
	  </td>
	</tr>
	<tr>
	  <td height=\"28\" align=\"right\"></td>
	  <td align=\"left\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		<tr>
		  <td width=\"39%\"><input type=\"file\" name=\"file_book\"/></td>
		  <td width=\"28%\" align=\"left\"><input type=\"submit\" value=\"�ϴ�\"/></td>
		  <td width=\"17%\"></td>
		</tr>
	  </table></td>
	</tr>
  </table>
  </td>      
</tr>
</table></form><!--end �ϴ��鼮//-->";
	return $html;
}
?>
<HTML>
<HEAD>
<TITLE> �ϴ��鼮|���ľ�ѡ|www.mwjx.com </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<STYLE type=text/css media=screen>
td{
	font-size:13px;
}
</STYLE>

</HEAD>

<BODY text="#000000" bgColor="#FFFFFF" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
<?php
echo $html;
?>
<iframe name="submitframe" width="1" height="1" src="about:blank">
</BODY>
</HTML>
