<?php
//------------------------------
//create time:2010-12-26
//creater:zll,liang_0735@21cn.com
//purpose:С˵�½�����
//------------------------------
if(!isset($_COOKIE['username']) || "" == $_COOKIE['username']){
	exit("δ��¼������<a href=\"http://www.fish838.com/site838/\">��838�Ķ�����</a>��ҳ��¼");
}
include("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/pagebase.php");
my_safe_include("book/article.php");
my_safe_include("mwjx/mybook.php");
my_safe_include("class_man.php");
require("../../key_fill/fd.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);
//$m_id = 8; //tests
$m_ctitle = ""; //����
$m_author = ""; //����
$m_title = ""; //�½���
$m_cid = -1;
$m_pre = -1;
$m_next = -1;
$m_content = "";
$m_bottom = ""; //β��
$m_last = "";
$tbl = intval(($m_id-1)/100000)+1;
//��ת����̬ҳ
//if("" == $_COOKIE['username']){
//	$obj_a = new c_article($m_id);
//	$url = $obj_a->get_url_dynamic($m_id,2,$obj_a->get_cid());
//	//if(file_exists($dir_home.$dir_s)){
//	header("location: ".$url);
//	exit();
//	//}
//}

$str_sql = "select A.*,D.txt from article A left join a_data_".$tbl." D on A.id=D.aid where A.id ='".$m_id."';";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$arr = $sql->get_array_array();
$sql->close();
if(1 != count($arr))
	exit("���²�����");
$m_title = $arr[0]["title"];
$m_cid = intval($arr[0]["cid"]);
$m_last = $arr[0]["last"];
//����½�ID
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
$obj_mb = new c_mybook;
$m_uid = $obj_man->get_id();
$obj_mb->flag_article($m_uid,$m_cid,$m_id);
$obj_mb->rm_left($m_uid); //ɾ����������˵���������

$fil = new fillter("../../key_fill/bw.php");
$m_content = $arr[0]["txt"];
//$m_content = "838�����ҳ-->������ҳ-->�������-->����̾�����¼(43)    ���ߣ������� ";
$m_content = $fil->fill($m_content);
if(false !== strpos($m_content,"[/img]")){
	$m_content = str_replace("[img width=540]","[img width=918]",$m_content); //ͼƬ�Ŵ�
}
showtohtml($m_content);
$html_top = c_pagebase::html_headtop($m_cid);
//var_dump($m_content);
//exit($m_content);

$str_sql = "select * from class_info where id ='".$m_cid."';";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();
if(1 != count($arr))
	exit("���²�����");
$m_ctitle = $arr[0]["name"];
$m_author = $arr[0]["memo"];
//$html_top .= c_pagebase::html_quick();
//$html_top .= c_pagebase::html_menu("",2,"",$m_ctitle);
//var_dump($m_ctitle);
//exit();
$m_bottom = "<-���̷�ҳ&nbsp;&nbsp;<a href=\"/site838/view/track/index.php?id=".$m_cid."\">����Ŀ¼</a>&nbsp;&nbsp;���̷�ҳ->";
$str_sql = "select id from article  where id < ".$m_id." and cid='".$m_cid."' order by id desc limit 1;";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
//var_dump($arr);
//exit();
$len = count($arr);
$m_js = "<script language=\"javascript\">\n";
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i][0]);
	if($id < $m_id){
		$m_bottom = "<a href=\"/site838/view/track/show.php?id=".$id."\">��һҳ</a>&nbsp;&nbsp;".$m_bottom;
		$m_js .= "var m_page_pre='/site838/view/track/show.php?id=".$id."';\n";
	}
	else{
		$m_bottom = $m_bottom."&nbsp;&nbsp;<a href=\"/site838/view/track/show.php?id=".$id."\">��һҳ</a>";
		$m_js .= "var m_page_next='/site838/view/track/show.php?id=".$id."';\n";
	}
	//var_dump($id);
	//exit();
}
$str_sql = "select id from article  where id > ".$m_id." and cid='".$m_cid."' order by id asc limit 1;";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
//var_dump($arr);
//exit();
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i][0]);
	if($id < $m_id){
		$m_bottom = "<a href=\"/site838/view/track/show.php?id=".$id."\">��һҳ</a>&nbsp;&nbsp;".$m_bottom;
		$m_js .= "var m_page_pre='/site838/view/track/show.php?id=".$id."';\n";
	}
	else{
		$m_bottom = $m_bottom."&nbsp;&nbsp;<a href=\"/site838/view/track/show.php?id=".$id."\">��һҳ</a>";
		$m_js .= "var m_page_next='/site838/view/track/show.php?id=".$id."';\n";
	}
	//var_dump($id);
	//exit();
}
$m_js .= "</script>\n";

//-------------����Ⱥ-----------
function showtohtml(&$string)
{
	//���з�ת��Ϊ<br> ,ͼƬ[img][/img]תΪ<img src=" ">

	if(is_array($string)){
		foreach($string as $key => $val){
			$string[$key] = showtohtml($val);
		}
	}
	else{
		replace_url($string);
		$string.="\n";
	}
	return true;
}
function replace_url(&$txt)
{
	//��ͼƬ��URLת����html
	//�������е�URL��ַת���ɿɵ��������

	$txt=trim($txt);

	//$txt=htmlspecialchars($txt);
	$txt=str_replace("\n","<BR>",$txt);
	$txt=str_replace("\r","",$txt);
	//$txt=preg_replace("/\[img(.*?)\]http(.+?)\[\/img\]/is","[img\\1]!!!!\\2[/img]",$txt);
	//$txt=preg_replace("/\[img(.*?)\](.*?)\[\/img\]/is","[img\\1]\\2[/img]",$txt);
	//$txt=preg_replace("/\[swf\]http(.+?)\[\/swf\]/is","[swf]!!!!\\1[/swf]",$txt);
	//$txt=preg_replace("/\[flv\]http(.+?)\[\/flv\]/is","[flv]!!!!\\1[/flv]",$txt);

	//$txt=preg_replace("/(http:\/\/[a-zA-Z0-9\-\.\/\?\=\&\;\_\:\~]{1,150})/is","<a href=\\1 target=\"_blank\">\\1</a>",$txt);
	//$txt=preg_replace("/\[img\]!!!!(.+?)\[\/img\]/is","<img src=http\\1>",$txt);
	
	//$txt=preg_replace("/\[img(.*?)\]!!!!(.+?)\[\/img\]/is","<a href=\"http\\2\" target=\"_blank\"><img \\1 alt=\"����鿴ԭͼ\" border=\"0\" src=http\\2></a>",$txt);
	//$txt=preg_replace("/\[img(.*?)\]!!!!(.+?)\[\/img\]/is","<img \\1 alt=\"���ȫ��\" border=\"0\" onclick=\"this.style.width='718px';\" src=http\\2>",$txt);
	$txt=preg_replace("/\[img(.*?)\](.+?)\[\/img\]/is","<img \\1 alt=\"���ȫ��\" border=\"0\" onclick=\"this.style.width='718px';\" src=\"\\2\"/>",$txt);
	//$txt=preg_replace("/\[swf\]!!!!(.+?)\[\/swf\]/is","      <object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"460\" height=\"390\"  align=\"middle\"><param name=\"movie\" value=\"http\\1\" /><param name=\"quality\" value=\"high\" /></object>",$txt);
	//$txt=preg_replace("/\[flv\]!!!!(.+?)\[\/flv\]/is","<div id=\"div_flv\"><embed src=\"/site838/view/include/vcastr.swf?vcastr_file=http\\1\" showMovieInfo=1 pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" quality=\"high\" width=\"444\" height=\"358\"></embed></div>",$txt);
	return true;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?=$m_title;?>|��838��ǡ� - ������ɫ����С˵վ��|www.fish838.com</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="838���" name="description"/>
<META content="838���,����С˵,��ʷ,www.fish838.com" name="keywords"/>
<META NAME="Author" CONTENT="mwjx,С��"/>
<STYLE type=text/css media=screen>
@import url("/site838/view/css/tb_1.css");
@import url("/site838/view/css/tb_2.css");
@import url("/site838/view/css/class_dir.css");
.li_normal{
	background-color:#FFFFFF;
}
.li_red{
	background-color:#FFB6C1;
}
#div_articles{
	float:left;
	margin-left:10px;
	width:100%;
	overflow:hidden;
	/*height:100%;*/
	line-height:150%;
	/*height:192px;*/
}
#div_articles ul li {
	float:left;
	margin-left:0px;
	position:relative;
	width:200px;
	height:18px;
	overflow:hidden;
	cursor:hand;
	/*background:#EEEEFF;*/
	padding:0px 0px 0px 8px;   border:1px solid #CCCCEE;
}
#div_articles ul li a {color:#5A5A5A;}
#div_articles ul li a:hover {color:#FF5500;}
/**/
</STYLE>
<META content="MSHTML 6.00.2900.2180" name=GENERATOR/>
<?=$m_js;?>
<script language="javascript">
function check_confcode(str)
{
	//�����֤���Ƿ���д
	//����:str(string)��֤���������
	//���:true����,falseδ��д
	if("" == document.all[str].value){
		alert("����д��֤��");
		return false;
	}
	return true;
}
function report_err(id)
{
	//�ٱ������½�
	//����:id�½�ID
	//���:��
	//alert(id);
	document.all["frm_action"]["fun"].value = "report_err";
	document.all["frm_action"]["aid"].value = id;
	document.all["frm_action"].submit();
}
function keydown(evt)
{
	evt=evt||window.event;
	switch(evt.keyCode){
		case 37: //��
			//alert(m_page_pre);
			if(evt.ctrlKey) //ctrl��
				window.open(m_page_pre);
			else
				window.location.href=m_page_pre;
			break;
		case 39: //��
			//alert(m_page_next);
			if(evt.ctrlKey) //ctrl��
				window.open(m_page_next);
			else
				window.location.href=m_page_next;
			break;
		default:
			break;
	}


}
</script>
</HEAD><BODY class="W950 CurHome" onkeydown="javascript:keydown(event);">
<DIV id=Head><A class=hidden href="http://www.fish838.com/#Content">����������������</A> 
<?=$html_top;?>
<div id="title_ad" style="width:100%;height:60px;">
<table width="908" border="0" cellPadding="0" cellSpacing="0" align="center" valign="top">
<tr height="60" align="left">
<td>
<table border="0" width="100%"><tr>
<td width="100%" align="left" style="color:red;"><a href="/">838��ҳ</a>--&gt;<a href="/site838/view/track/index.php?id=<?=$m_cid?>" target="_self"><?=$m_ctitle;?></a>--&gt;<?=$m_title;?>
&nbsp;&nbsp;&nbsp;&nbsp;���ߣ�<?=$m_author;?>
</td>
</tr>
<tr><td align="right">
<UL>
  <LI class="bar_text"><A href="#" 
  target="_self" title="�����⣬ȱʧ���쳣�½ڶ��ɵ������ť�ٱ�" onclick="javascript:report_err('<?=$m_id;?>');">�ٱ������½�</A></LI>
  <LI class="bar_text"><A href="/site838/" 
  target="_self" title="�޸�����ʾͼƬ�ķ���Ϊ������������ѡһ����������Դ��վ�滻��ǰ��Դ��վ">�޸�����ʾͼƬ</A></LI>
</UL>  
</td>
</tr>
<tr><td align="left">
  ����ʱ�䣺<?=$m_last;?>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div><!--end title_ad//-->

<DIV class=L250 id=Content style="font-size:13pt;"><A name=main></A>
<!--<DIV style="FLOAT: right;">
<IFRAME align="left" marginWidth="0" marginHeight="0" src="/site838/view/include/ads_google_336_280.html" frameBorder=0 width="336" scrolling="no" height="280" topmargin="0" leftmargin="0"></IFRAME>
		</DIV>//-->
<SPAN style="FONT-SIZE: 13pt;word-break:break-all;word-wrap:break-word;line-height:30px;">
<?=$m_content;?>
</SPAN>
</DIV>
<DIV align="center">
<?=$m_bottom;?>
</DIV>

<DIV id=Foot><DIV style="MARGIN: 0px auto; WIDTH: 380px; FONT-FAMILY: arial">
<!--
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
document.write('<a href="http://fishcounter.3322.org/data/xml_data.php?uid=1&type=page_detail&hpg='+hex_md5(escape(c_page))+'" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="��������ͳ��" border="0"/></a>');
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="��������ͳ��" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>
	
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="&#x5e9f;&#x589f;&#x6d41;&#x91cf;&#x7edf;&#x8ba1;" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>
Copyright 2002-2010,alpha fish838.com
//-->
<script type="text/javascript" src="../../count.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4899067-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
<BR></DIV></DIV>
<!--//-->
<!--���ܱ�//-->
<form method="POST" name="frm_action" action="../cmd.php" target="submitframe" accept-charset="GBK">
<input type="hidden" name="fun" value=""/>
<input type="hidden" name="aid" value=""/>
</form>

<iframe name="submitframe" width="1" height="1" src="/site838/view/addclick.php?id=<?=$m_id;?>"></iframe>

</BODY></HTML>
