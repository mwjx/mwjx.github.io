<?php
//------------------------------
//create time:2007-11-19
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:����������
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$m_aid = 40367; //����ҳ��ID

$str_sql = "select * from helpmwjx order by modify DESC limit 100;";
//$m_arr_re = array("",$name."--".$money);
//break;
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();

$len = count($arr);
$html = "";
$html .= "<center><a href=\"http://www.mwjx.com/\">�������ľ�ѡ</a>&nbsp;&nbsp;&nbsp;&nbsp<a href=\"http://www.mwjx.com/mwjx/include/help_mwjx.html\" target=\"_blank\">��Ӵ���������������</a></center>";
$html .= "<div style=\"border:1px #BECEE6 solid;background:#fff\">
<table width=\"100%\" bgcolor=\"#E1EFFA\" style=\"border-bottom:1px #BECEE6 solid;\">
<tr><td style=\"padding:0 0 0 10px;font-size:14px;\">
���������ľ�ѡ������������
</td></tr>";
$html .= "</table>";
$html .= "<table width=\"100%\" style=\"border-bottom:1px #BECEE6 solid;\">";
$html .= "<tr bgcolor=\"#E1EFFA\"><td>�����ߴ���</td><td>�������</td><td>ʱ��</td><td>С��ظ�</td></tr>";
for($i = 0;$i < $len; ++$i){
	$html .= "<tr bgcolor=\"#FFFFFF\"><td>".$arr[$i]["name"]."</td><td>".$arr[$i]["money"]."</td><td>".$arr[$i]["modify"]."</td><td>".$arr[$i]["comments"]."</td></tr>";

}
$html .= "</table>";
$html .= "</div>";
$html .= html_comments();
function html_comments()
{
	//��������
	//����:��
	//���:html�ַ���
	//��֯����
	$id = 40367;
	$sql_limit = "limit 5";
	$sql_type = "R.r_type = '2'";
	$sql_gid = "R.gid = '".strval($id)."'";
	$str_sql = "select R.id as 'int_id',R.modify,R.content,U.str_username as name  from reply R left join tbl_user U on R.poster = U.int_userid  where ".$sql_type." and ".$sql_gid." order by R.modify DESC ".$sql_limit.";";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();				
	$arr = $sql->get_array_array();		
	$str = "";
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$str .= "<tr><td bgcolor=\"#FFFFFF\"><img src=\"/mwjx/images/tie.gif\" border=\"0\"/></td><td bgcolor=\"#FFFFFF\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\"><tbody><tr><td></td><td height=\"18\" align=\"left\"><strong></strong></td><td></td></tr><tr><td></td><td align=\"left\" width=\"70%\"><p class=\"MsoNormal\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-INDENT: 24pt; TEXT-ALIGN: left; mso-char-indent-count: 2.0; mso-pagination: widow-orphan\" align=\"left\">".nl2br($arr[$i]["content"])."</p></td><td></td></tr><tr><td></td><td align=\"left\"></td><td></td></tr><tr><td></td><td align=\"left\"><img height=\"1\" src=\"\" width=\"530\" /></td><td></td></tr><tr><td></td><td></td><td align=\"right\"><div align=\"right\"><span style=\"15px\"></span><strong>".$arr[$i]["name"]."</strong>&nbsp;<span style=\"5px;\"></span>�����ڣ�".$arr[$i]["modify"]."</div></td></tr><tr><td height=\"8\"></td><td height=\"8\"></td><td height=\"8\" align=\"right\"><!--<form action=\"/mwjx/cmd.php?fun=rm_reply&amp;id=142&amp;type=N\" method=\"POST\"  target=\"submitframe\"><input type=\"image\" src=\"/mwjx/images/delete.gif\"  align=\"absbottom\" onclick=\"if(confirm('ɾ���������ֺ����ص���Ϊ��ȷ��Ҫɾ����\\n��ʾ�������ڴ��ھ�̬ҳ�棬�����ʾɾ���ɹ�����������Ҳ������ʧ��ֱ����ҳ����������ʱɾ���Ż���Ч��')){this.form.submit();}else{return false;}\" alt=\"ɾ������\"/></form>//--></td></tr></tbody></table></td></tr>";
	
	}
	//�γ��ַ���
	$html = "";
	$html .= "<!--start��������//--><TABLE cellSpacing=0 border=0 width=\"100%\" align=\"center\"><TBODY><TR><TD class=C style=\"PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px; BORDER-BOTTOM: #e7dc86 1px solid\" bgColor=#fef9cf><IMG height=11 hspace=6 src=\"/mwjx/images/start_with.gif\" width=5>��������</TD></TR></TBODY></TABLE>";
	$html .= "<table width=\"100%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#f3edc3\"><TBODY>".$str."<tr><td colspan=\"2\" align=\"right\"><a href=\"/mwjx/src_php/reply.php?gtype=A&page=1&per=10&id=".$id."\" target=\"_blank\" color=\"#035c9e\">������������...</a></td></tr></TBODY></table>";
	//$html .= reply_input($id);
	//$html .= "<TABLE cellSpacing=\"1\" cellPadding=\"3\" width=\"100%\" align=\"center\" bgColor=\"#cccccc\" border=\"0\"><TR bgColor=\"#ffffff\"><TD align=\"right\" width=\"100%\"><a href=\"/mwjx/src_php/reply.php?gtype=A&page=1&per=10&id=".$id."\" target=\"_blank\" color=\"#035c9e\">������������...</a></TD></TR></TABLE>";
	return $html;
}
function reply_input($id=-1)
{
	$html = "<div style=\"width:100%;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td height=\"29\" align=\"left\" background=\"/mwjx/images/titbg01.jpg\" class=\"newtext\"><span style=\"width:150px;\"></span>�������ۣ�</td></tr><form id=\"frmsubmit\" name=\"frmsubmit\" accept-charset=\"GB2312\"  action=\"/mwjx/cmd.php\" method=\"POST\" target=\"submitframe\">
<tr>
<td align=\"center\">
  <table width=\"72%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
	  <td align=\"right\">���ݣ�</td>
	  <td align=\"left\"><textarea name=\"message\" cols=\"60\" rows=\"5\"></textarea>
		<input name=\"fun\" type=\"hidden\" value=\"reply\"/>
<input name=\"reply_type\" type=\"hidden\" value=\"article\"/>
<input name=\"aid\" type=\"hidden\" value=\"".$id."\"/>

	  </td>
	</tr>
	<tr>
	  <td height=\"28\" align=\"right\"></td>
	  <td align=\"left\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		<tr>
		  <td width=\"29%\"><!--//--><img src=\"/mwjx/pic.php?t=reply\" onclick=\"this.src='/mwjx/pic.php?t=reply'\" alt=\"�������������ͼƬ\" style=\"cursor:hand;\"/>��֤�룺<input type=\"text\" name=\"conf_reply\" size=\"5\" value=\"\"/></td>
		  <td width=\"38%\" align=\"left\"><input type=\"submit\" name=\"Submit32\" value=\"����\"/></td>
		  <td width=\"17%\"></td>
		</tr>
	  </table></td>
	</tr>
  </table>
  </td>      
</tr>
  </form>
</table></div>";
	return $html;
}
?>
<HTML>
<HEAD>
<TITLE> ���������ľ�ѡ��--����������|���ľ�ѡ|www.mwjx.com </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<STYLE type=text/css media=screen>
td{
	font-size:13px;
}
</STYLE>

</HEAD>

<BODY text="#000000" bgColor="#FFFFFF">
<h1>���������ľ�ѡ��</h1>
<div>
ͨ��֧����������<br/>
֧�����ʺţ�liang_0735@21cn.com<br/><br/>
֧�����ֻ�֧����(������֧�����ʺ�)<br/>
��д���ţ�to*13661724922*1.01<br/>
��to*liang_0735@21cn.com*1.01<br/>
�ƶ���ͨ�����͵���10663721898<br/>
1.01�ǽ����������<a href="https://www.alipay.com/user/mobile_pay.htm" target="_blank">֧�����ֻ�֧����ϸ˵��</a><br/>
</div>
<hr/>
����֧����<br/>
<form method="post" name="form1" action="https://www.cncard.net/purchase/selfdeal_step1.asp" target="_blank">
��Ʒ���ƣ��������ľ�ѡ<br>
֧����<input type="text" name="Unitprice" value='5'><br>
<input type="hidden" name="PMid" value='1018377'>
<input type="hidden" name="Pcatename" value='�������ľ�ѡ'>
<input type="hidden" name="Pcateid" value='1'>
<input type="hidden" name="succ_url" value='http://www.mwjx.com/'>
<input type="hidden" name="Error_url" value='http://www.mwjx.com/'>
<input type="hidden" name="Memo_Status" value='0'>
<input type="hidden" name="Memo_topic" value=''>
<input type="hidden" name="Topic1" value=''>
<input type="hidden" name="Topic2" value=''>
<input type="hidden" name="Quantity_status" value='0'>
<input type="hidden" name="PsFee_type" value='0'>
<input type="hidden" name="PsFee" value='0'>
<input type="hidden" name="handFee" value='0'>
<input type="hidden" name="botton_type" value='1'>
<input type="hidden" name="c_language" value='0'>
<input type="image" src="https://www.cncard.net/cnpayment/admin/images/button/buynow26.gif" name="submit" alt="ʹ��֧��@��">
</form>
<hr/>
�ֻ�����������ʹ������ľ�Ʒ��������վ���÷ֳɣ�<br/><br/>
<iframe src="http://www.spjoy.com/AdFiles/760-80-9/760-80-9.htm?f=4523&lower_cooid=0&ad_id=5485" height="80" width="760" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>
<hr/>

<div>
<br/>����ת�ʣ�<br/>
 <div id="centerm"><div id="content"><table width="100%" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="/mwjx/image/zsbank.gif" title="��������" />��������</td>
    <td align="left" bgcolor="#FFFFFF"><br />
      <span class="even">��������������</span><br />
      <span class="even">���ʺţ�6225882000928454</span><br />

      <span class="even">�������У��������й��ݷ������֧��</span> <br /></td>
  </tr>
  <!--
  <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="../image/jsbank.gif" title="��������" />��������</td>
    <td align="left" bgcolor="#FFFFFF"><br />
      <span class="even">��������������</span><br />
      <span class="even">�����ţ�</span><br />

      <span class="even">�������У��������й��ݷ��и�����֧��</span><br /></td>
  </tr>
  <tr>
    <td width="25%" align="center" bgcolor="#FFFFFF"><img src="../image/zgbank.gif" title="�й�����" />�й�����</td>
   <td width="75%" align="left" bgcolor="#FFFFFF"><br />
      <span class="even">��������</span><br />
      <span class="even">������</span>��<span class="even"></span><br />

      <span class="even">�������У�</span> <br /></td>
  </tr>//-->
</table>
<br />
<br />

</div></div>
</div>


<?php
echo $html;
echo reply_input($m_aid);
?>
<div>
<script type="text/javascript" src="http://fishcounter.3322.org/script/md5.js"></script>
<script language="JavaScript" type="text/javascript">
//----------�ͻ���Ωһ����----------
var cookieString = new String(document.cookie);
var cookieHeader = "fc_uniqid=" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = "";
if (beginPosition == -1){  //û��cookie,��ֲ
	sFc_uniqid = Math.round(Math.random() * 2147483647);
	document.cookie = cookieHeader+sFc_uniqid+";expires=Sun, 18 Jan 2038 00:00:00 GMT;"+"path=/";
}
else{
	var pos_end = cookieString.indexOf(";",beginPosition);
	var pos_start = beginPosition+cookieHeader.length;
	if(-1 != pos_end){
		sFc_uniqid = cookieString.substr(pos_start,(pos_end - pos_start));
	}
}
//--------end Ωһ����-------------------
var fromr = top.document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==""? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
document.write('<a href="http://fishcounter.3322.org/data/xml_data.php?uid=9&type=page_detail&hpg='+hex_md5(escape(c_page))+'" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_9_9.gif?'+query+'" title="��������ͳ��" border="0"/></a>');
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=9" target="_blank"><img alt="��������ͳ��" src="http://fishcounter.3322.org:8086/fc_9_9.gif" border="0" /></a>
</noscript>
	
</div>
<iframe name="submitframe" width="1" height="1" src="about:blank">
</BODY>
</HTML>
