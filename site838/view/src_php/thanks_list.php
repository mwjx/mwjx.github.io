<?php
//------------------------------
//create time:2007-11-19
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:捐助者名单
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$m_aid = 40367; //捐助页面ID

$str_sql = "select * from helpmwjx order by modify DESC limit 100;";
//$m_arr_re = array("",$name."--".$money);
//break;
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();

$len = count($arr);
$html = "";
$html .= "<center><a href=\"http://www.mwjx.com/\">返回妙文精选</a>&nbsp;&nbsp;&nbsp;&nbsp<a href=\"http://www.mwjx.com/mwjx/include/help_mwjx.html\" target=\"_blank\">添加大名到捐助者名单</a></center>";
$html .= "<div style=\"border:1px #BECEE6 solid;background:#fff\">
<table width=\"100%\" bgcolor=\"#E1EFFA\" style=\"border-bottom:1px #BECEE6 solid;\">
<tr><td style=\"padding:0 0 0 10px;font-size:14px;\">
捐助《妙文精选》捐助者名单
</td></tr>";
$html .= "</table>";
$html .= "<table width=\"100%\" style=\"border-bottom:1px #BECEE6 solid;\">";
$html .= "<tr bgcolor=\"#E1EFFA\"><td>捐助者大名</td><td>捐助金额</td><td>时间</td><td>小鱼回复</td></tr>";
for($i = 0;$i < $len; ++$i){
	$html .= "<tr bgcolor=\"#FFFFFF\"><td>".$arr[$i]["name"]."</td><td>".$arr[$i]["money"]."</td><td>".$arr[$i]["modify"]."</td><td>".$arr[$i]["comments"]."</td></tr>";

}
$html .= "</table>";
$html .= "</div>";
$html .= html_comments();
function html_comments()
{
	//评论留言
	//输入:无
	//输出:html字符串
	//组织数据
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
		$str .= "<tr><td bgcolor=\"#FFFFFF\"><img src=\"/mwjx/images/tie.gif\" border=\"0\"/></td><td bgcolor=\"#FFFFFF\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\"><tbody><tr><td></td><td height=\"18\" align=\"left\"><strong></strong></td><td></td></tr><tr><td></td><td align=\"left\" width=\"70%\"><p class=\"MsoNormal\" style=\"MARGIN: 0cm 0cm 0pt; TEXT-INDENT: 24pt; TEXT-ALIGN: left; mso-char-indent-count: 2.0; mso-pagination: widow-orphan\" align=\"left\">".nl2br($arr[$i]["content"])."</p></td><td></td></tr><tr><td></td><td align=\"left\"></td><td></td></tr><tr><td></td><td align=\"left\"><img height=\"1\" src=\"\" width=\"530\" /></td><td></td></tr><tr><td></td><td></td><td align=\"right\"><div align=\"right\"><span style=\"15px\"></span><strong>".$arr[$i]["name"]."</strong>&nbsp;<span style=\"5px;\"></span>发表于：".$arr[$i]["modify"]."</div></td></tr><tr><td height=\"8\"></td><td height=\"8\"></td><td height=\"8\" align=\"right\"><!--<form action=\"/mwjx/cmd.php?fun=rm_reply&amp;id=142&amp;type=N\" method=\"POST\"  target=\"submitframe\"><input type=\"image\" src=\"/mwjx/images/delete.gif\"  align=\"absbottom\" onclick=\"if(confirm('删除文章是种很严重的行为，确定要删除吗？\\n提示：你现在处于静态页面，如果提示删除成功，这条评论也不会消失，直到本页面重新生成时删除才会生效。')){this.form.submit();}else{return false;}\" alt=\"删除评论\"/></form>//--></td></tr></tbody></table></td></tr>";
	
	}
	//形成字符串
	$html = "";
	$html .= "<!--start评论留言//--><TABLE cellSpacing=0 border=0 width=\"100%\" align=\"center\"><TBODY><TR><TD class=C style=\"PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px; BORDER-BOTTOM: #e7dc86 1px solid\" bgColor=#fef9cf><IMG height=11 hspace=6 src=\"/mwjx/images/start_with.gif\" width=5>评论留言</TD></TR></TBODY></TABLE>";
	$html .= "<table width=\"100%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#f3edc3\"><TBODY>".$str."<tr><td colspan=\"2\" align=\"right\"><a href=\"/mwjx/src_php/reply.php?gtype=A&page=1&per=10&id=".$id."\" target=\"_blank\" color=\"#035c9e\">更多网友评论...</a></td></tr></TBODY></table>";
	//$html .= reply_input($id);
	//$html .= "<TABLE cellSpacing=\"1\" cellPadding=\"3\" width=\"100%\" align=\"center\" bgColor=\"#cccccc\" border=\"0\"><TR bgColor=\"#ffffff\"><TD align=\"right\" width=\"100%\"><a href=\"/mwjx/src_php/reply.php?gtype=A&page=1&per=10&id=".$id."\" target=\"_blank\" color=\"#035c9e\">更多网友评论...</a></TD></TR></TABLE>";
	return $html;
}
function reply_input($id=-1)
{
	$html = "<div style=\"width:100%;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td height=\"29\" align=\"left\" background=\"/mwjx/images/titbg01.jpg\" class=\"newtext\"><span style=\"width:150px;\"></span>发表评论：</td></tr><form id=\"frmsubmit\" name=\"frmsubmit\" accept-charset=\"GB2312\"  action=\"/mwjx/cmd.php\" method=\"POST\" target=\"submitframe\">
<tr>
<td align=\"center\">
  <table width=\"72%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
	  <td align=\"right\">内容：</td>
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
		  <td width=\"29%\"><!--//--><img src=\"/mwjx/pic.php?t=reply\" onclick=\"this.src='/mwjx/pic.php?t=reply'\" alt=\"看不清楚，更换图片\" style=\"cursor:hand;\"/>验证码：<input type=\"text\" name=\"conf_reply\" size=\"5\" value=\"\"/></td>
		  <td width=\"38%\" align=\"left\"><input type=\"submit\" name=\"Submit32\" value=\"发表\"/></td>
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
<TITLE> 捐助《妙文精选》--捐助者名单|妙文精选|www.mwjx.com </TITLE>
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
<h1>捐助《妙文精选》</h1>
<div>
通过支付宝捐赠：<br/>
支付宝帐号：liang_0735@21cn.com<br/><br/>
支付宝手机支付：(必须有支付宝帐号)<br/>
编写短信：to*13661724922*1.01<br/>
或：to*liang_0735@21cn.com*1.01<br/>
移动联通都发送到：10663721898<br/>
1.01是金额，可任意填定。<a href="https://www.alipay.com/user/mobile_pay.htm" target="_blank">支付宝手机支付详细说明</a><br/>
</div>
<hr/>
在线支付：<br/>
<form method="post" name="form1" action="https://www.cncard.net/purchase/selfdeal_step1.asp" target="_blank">
商品名称：捐助妙文精选<br>
支付金额：<input type="text" name="Unitprice" value='5'><br>
<input type="hidden" name="PMid" value='1018377'>
<input type="hidden" name="Pcatename" value='捐助妙文精选'>
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
<input type="image" src="https://www.cncard.net/cnpayment/admin/images/button/buynow26.gif" name="submit" alt="使用支付@网">
</form>
<hr/>
手机铃声捐赠，使用下面的精品铃声，本站会获得分成：<br/><br/>
<iframe src="http://www.spjoy.com/AdFiles/760-80-9/760-80-9.htm?f=4523&lower_cooid=0&ad_id=5485" height="80" width="760" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>
<hr/>

<div>
<br/>银行转帐：<br/>
 <div id="centerm"><div id="content"><table width="100%" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="/mwjx/image/zsbank.gif" title="招商银行" />招商银行</td>
    <td align="left" bgcolor="#FFFFFF"><br />
      <span class="even">　户名：周亮亮</span><br />
      <span class="even">　帐号：6225882000928454</span><br />

      <span class="even">　开户行：招商银行广州分行天河支行</span> <br /></td>
  </tr>
  <!--
  <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="../image/jsbank.gif" title="建设银行" />建设银行</td>
    <td align="left" bgcolor="#FFFFFF"><br />
      <span class="even">　户名：周亮亮</span><br />
      <span class="even">　卡号：</span><br />

      <span class="even">　开户行：建设银行广州分行高新区支行</span><br /></td>
  </tr>
  <tr>
    <td width="25%" align="center" bgcolor="#FFFFFF"><img src="../image/zgbank.gif" title="中国银行" />中国银行</td>
   <td width="75%" align="left" bgcolor="#FFFFFF"><br />
      <span class="even">　户名：</span><br />
      <span class="even">　卡号</span>：<span class="even"></span><br />

      <span class="even">　开户行：</span> <br /></td>
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
//----------客户端惟一代号----------
var cookieString = new String(document.cookie);
var cookieHeader = "fc_uniqid=" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = "";
if (beginPosition == -1){  //没有cookie,种植
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
//--------end 惟一代号-------------------
var fromr = top.document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==""? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
document.write('<a href="http://fishcounter.3322.org/data/xml_data.php?uid=9&type=page_detail&hpg='+hex_md5(escape(c_page))+'" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_9_9.gif?'+query+'" title="废墟流量统计" border="0"/></a>');
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=9" target="_blank"><img alt="废墟流量统计" src="http://fishcounter.3322.org:8086/fc_9_9.gif" border="0" /></a>
</noscript>
	
</div>
<iframe name="submitframe" width="1" height="1" src="about:blank">
</BODY>
</HTML>
