<?php
//------------------------------
//create time:2007-11-21
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�����鼮�б�
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");

$m_cid = intval(isset($_GET["cid"])?$_GET["cid"]:12);
//var_dump($arr);
//exit();
$html = "";
$html .= "<div style=\"float:left;width:250px;border:1px #BECEE6 solid;background:#fff;\">";
$html .= "<table width=\"100%\" bgcolor=\"#E1EFFA\" style=\"border-bottom:1px #BECEE6 solid;\">
<tr><td style=\"padding:0 0 0 10px;font-size:14px;\">
�鼮��Ŀ</td></tr>";
$html .= "</table>";
$str_sql = "select B.fid,C.name,count(B.id) as num from book_down B left join class_info C on B.fid=C.id group by B.fid order by B.fid ASC;";
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();
//var_dump($arr);
//exit();
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	$cid = intval($arr[$i]["fid"]);
	$title = $arr[$i]["name"];
	$num = $arr[$i]["num"];
	$html .= "<hr/>";
	$url = "./book_list.php?cid=".$cid;
	if($m_cid == $cid)
		$title = "<font color=\"red\">".$title."</font>";
	$html .= "&nbsp;&nbsp;<a href=\"".$url."\"><strong>".$title."(".$num.")</strong></a>";
}
$html .= "</div>";

$str_sql = "select B.*,U.str_username from book_down B left join tbl_user U on B.poster=U.int_userid where B.fid='".$m_cid."' order by B.id DESC limit 9999;";
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();

$html .= "<div style=\"float:left;left:250px;width:700px;border:1px #BECEE6 solid;background:#fff\">
<table width=\"100%\" bgcolor=\"#E1EFFA\" style=\"border-bottom:1px #BECEE6 solid;\">
<tr><td style=\"padding:0 0 0 10px;font-size:14px;\">
���ľ�ѡ--�鼮����</td></tr>";
$html .= "</table>";
$len = count($arr);
$down = "/mwjx/src_php/downbook.php?id=";
$m = 1024*1024;
for($i = 0;$i < $len; ++$i){
	$title = $arr[$i]["title"];
	$txt = nl2br($arr[$i]["txt"]);
	$aday = $arr[$i]["aday"];
	$num = $arr[$i]["num"];
	$path = $down.$arr[$i]["id"];
	$name = $arr[$i]["str_username"];
	$hz = $arr[$i]["hz"];
	$size = $arr[$i]["size"]/$m;
	$size = number_format($size, 2, ".", " ");
	if(strlen($txt) > 200)
		$txt = msubstr($txt,0,200)."...";
	$html .= "<hr/>";	
	$html .= "���ƣ�<strong>��".$title."��</strong>&nbsp;&nbsp;&nbsp;&nbsp;�������ڣ�".$aday."&nbsp;&nbsp;&nbsp;&nbsp;����ˣ�".$name."<br/>��飺".$txt."<br/><br/>���ش�����".$num."&nbsp;&nbsp;&nbsp;&nbsp;��С��".$size."&nbsp;MB&nbsp;&nbsp;&nbsp;&nbsp;��ʽ��".$hz."&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$path."\">����</a>";
}
$html .= "</div>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>�鼮����|�����ľ�ѡ�� - ������ɫ�������Ĵ��ӻ�|www.mwjx.com</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="�鼮����" name="description"/>
<META content="�鼮����,���ľ�ѡ,����,��Ĭ��Ц,����,��ʷ,www.mwjx.com" name="keywords"/>
<META NAME="Author" CONTENT="mwjx,С��"/>
<STYLE type=text/css media=screen>
* html {
  filter:expression(document.execCommand("BackgroundImageCache", false, true));
}
body,p,th,td,input,select,textarea{
    font:normal normal 12px "SimSun";
    color:#111111;
}
body{
	margin:0;
	padding:0 10px 0 10px;
	background-color:#FFF;
}
h1,h2,h3,h4,h5,h6{
	margin:0;
	padding:0;
	font-size:14px;
}
ul,dl,ol,form{
	margin:0;
	padding:0;
}
ul li,ol li{
	list-style-type:none;
}
dl dt,dl dd{
	margin:0;
	padding:0;
}
table{
	text-align:left;
}
p{
	margin:0;
	padding:0;
	line-height:18px;
}
hr{
	border:#000 0 solid;
	border-top:#D1D7DC 1px solid;
	height:0;
}
img{
	border:0;
}
address,em{
	font-style:normal;
}
a:link,a:visited{
	color:#04D;
	text-decoration:none;
}
a:hover,a:active{
	color:#F50;
	text-decoration:underline;
}
.H{color:#F30;}
.G{color:#666;}

</STYLE>
<META content="MSHTML 6.00.2900.2180" name=GENERATOR/>
</HEAD>
<BODY class="W950 CurHome">
<iframe name="submitframe" width="0" height="0" src="about:blank"></iframe><!--//-->
<center><a href="http://www.mwjx.com/" target="_top"><strong>���ء����ľ�ѡ��</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.mwjx.com/mwjx/include/help_mwjx.html" target="_blank"><strong>���������ľ�ѡ��</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/mwjx/src_php/post_book.php?id=<?=$m_cid?>" target="_blank"><strong>�ϴ��鼮</strong></a></center><br/>

<?php
echo $html;
?>

<DIV id=Foot><DIV style="float:center;MARGIN: 0px auto; WIDTH: 380px; FONT-FAMILY: arial">
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
document.write('<a href="http://fishcounter.3322.org/data/xml_data.php?uid=10&type=page_detail&hpg='+hex_md5(escape(c_page))+'" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_10_10.gif?'+query+'" title="��������ͳ��" border="0"/></a>');
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=10" target="_blank"><img alt="��������ͳ��" src="http://fishcounter.3322.org:8086/fc_10_10.gif" border="0" /></a>
</noscript>
	
Copyright 2002-2007, ��Ȩ���� mwjx.com<BR></DIV>
</DIV>
</BODY></HTML>