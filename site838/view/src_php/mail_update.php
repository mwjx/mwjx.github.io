<?php
//------------------------------
//create time:2007-8-15
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:���ĸ���
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//my_safe_include("mwjx/interface.php");
//my_safe_include("lib/fun_global.php");
$m_count = get_count(); //�û�ͳ��
$m_links = get_links(); //ÿ�ո����б�

function get_count()
{
	//�û�ͳ��
	//����:��
	//���:html�ַ���
	$str_sql = "select active,count(id) as 'num' from mail_list group by active;";
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	//var_dump($arr);
	//exit();
	$num_en = 0;
	$num_un = 0;
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		if("Y" == $arr[$i]["active"])
			$num_en = intval($arr[$i]["num"]);
		else
			$num_un = intval($arr[$i]["num"]);
	}
	$str = "�Ѽ����û�:".number_format($num_en,0,".",",")."&nbsp;&nbsp;δ�����û�:".number_format($num_un,0,".",",")."&nbsp;&nbsp;�û��ϼ�:".number_format(($num_en+$num_un),0,".",",")."<br/>";
	return $str;
}
function get_links()
{
	//ÿ�ո����б�
	//����:��
	//���:html�ַ���
	$links = "";
	$dir = "../../data/dailymail/";
	if(!file_exists($dir))
		return "";
	if(intval($int_dir = opendir($dir)) < 0)
		return "";
	//$result = array();
	while(($file = readdir($int_dir))!== false) {
		if(is_dir($dir.$file) || ("." == $file) || (".." == $file))
			continue;
		$url = $dir.$file;
		if("" != $links)
			$links .= "&nbsp;��&nbsp;";
		$links .= ("<a href=\"".$url."\">".$file."</a>");
	}
	
	closedir($int_dir);
	return $links;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> ���ľ�ѡ|www.mwjx.com </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<LINK href="/image/indeximage/content.css" type="text/css" rel="stylesheet"/>
<base target="_blank"/>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">

<script language="JavaScript" src="/top.js"></script>
<TABLE height=10 cellSpacing=0 cellPadding=0 width=778 align=center border=0><TBODY>
    <TR>
	    <TD width=1 bgColor=#8c8c8c></TD>
    <TD width=225 bgColor=#cccccc></TD>
    <TD width=1 bgColor=#8c8c8c></TD>
    <TD width=550 bgColor=#cccccc align=right>&#149;<a href="/sitemap.html">��վ��ͼ</a>&#149;</TD>
         <TD width=1 bgColor=#8c8c8c></TD>
  </TR></TBODY></TABLE>
<TABLE cellSpacing="0" cellPadding="0" width="778" align="center" bgColor="#8c8c8c" border="0"><TBODY><TR><TD><!--�ָ���//--></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="778" align=center border=0><TBODY><TR><TD width=1 bgColor=#8c8c8c height="30"></TD><TD vAlign=top width=776 bgColor="#ffffff">
<div style="width:100%;line-height:18px;border:1px solid #cccccc;margin-top:0px;"><div  style="padding-left:8px;padding-top:5px;background-color:#eeeeee;height:24px;">��������ÿ�ո����ʼ�<a name="daily_mail"></a></div><div style="padding-top:0px;padding-bottom:0px;table-layout:fixed; word-break :break-all;padding-left:10px;"><form action="/mwjx/src_php/add_mail_list.php" method="POST"  target="submitframe">����ÿ�ո���<input type="checkbox" name="chk_class" checked="true" disabled="false"/>&nbsp;&nbsp;���ܣ����ľ�ѡ�Ὣÿ����µ������б����ʼ���ʽ���͵���ĵ������䡣<br/><br/>����д���ո��µ������ַ:<br/><input type="text" name="txt_email" value="" style="width:150px;"/><br/><button onclick="this.form.submit();">�ύ����</button><br/>С��ʾ:�ܶ�������侭���ղ����ʼ���Ϊ��ȷ���յ��ʼ�������ύ������ͬ���䣬С���д��6����ֻ��3�����յ���<br/>Ŀǰ�����޷��յ��ʼ�������:����(sina.com)</form></div></div>

</TD>
<TD width=1 bgColor=#8c8c8c height="30"></TD></TR>
<TR><TD width=1 bgColor=#8c8c8c height="30"></TD><TD vAlign=top width=776 bgColor="#ffffff">

<div style="width:100%;line-height:18px;border:1px solid #cccccc;margin-top:0px;"><div  style="padding-left:8px;padding-top:5px;background-color:#eeeeee;height:24px;">����ͳ��</div><div style="padding-top:0px;padding-bottom:0px;table-layout:fixed; word-break :break-all;padding-left:10px;">
<?=$m_count;?></div></div>
</TD>
<TD width=1 bgColor=#8c8c8c height="30"></TD></TR>
<TR><TD width=1 bgColor=#8c8c8c height="30"></TD><TD vAlign=top width=776 bgColor="#ffffff">
<div style="width:100%;line-height:18px;border:1px solid #cccccc;margin-top:0px;"><div  style="padding-left:8px;padding-top:5px;background-color:#eeeeee;height:24px;">ÿ�ո����б�����</div><div style="width:776px;padding-top:0px;padding-bottom:0px;table-layout:fixed; padding-left:10px;word-break:break-all;">
<?=$m_links;?></div></div>
</TD>
<TD width=1 bgColor=#8c8c8c height="30"></TD></TR>
</TABLE>



<TABLE cellSpacing="0" cellPadding="0" width="778" align="center" bgColor="#8c8c8c" border="0"><TBODY><TR><TD><!--�ָ���//--></TD></TR></TBODY></TABLE>
<iframe name="submitframe" width="0" height="0" src="about:blank"></iframe><script language="JavaScript" src="/bottom.js"></script>
</BODY>
</HTML>
