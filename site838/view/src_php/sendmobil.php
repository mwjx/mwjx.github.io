<?php
//------------------------------
//create time:2007-12-26
//creater:zll
//purpose:发送到手机
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_article.php");
my_safe_include("mwjx/class_query.php");
my_safe_include("mwjx/vote_article.php");
$m_id = (isset($_GET["id"])?$_GET["id"]:"");
//$m_id = "5469"; //tests
$obj_article = new articlebase($m_id,"","Y"); 
if($obj_article->get_id() < 1)
	exit("文章不存在");
//if(isset($_GET["edit"])) //全模式
//$obj_article->bln_dynamic = true;
//echo $obj_article->get_html();
$m_title = $obj_article->get_title();
$m_content = $obj_article->get_txt();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0108)http://send.ivansms.com/ibook/sendbook.asp?url=http://link.iuse.com.cn/style/book/style1.html&publisher=test -->
<HTML><HEAD><TITLE>埃文手机小说-72</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312"><LINK 
href="/mwjx/css/sendmobil.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="/mwjx/script/validate.js" 
type=text/JavaScript></SCRIPT>
<SCRIPT language=JavaScript>
<!--
	//resizeTo(506,527);
	window.focus();
//-->
</SCRIPT>

<META content="MSHTML 6.00.2900.3157" name=GENERATOR></HEAD>
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 scroll=no MARGINHEIGHT="0" 
MARGINWIDTH="0">
<FORM name=sendbook onsubmit="return CheckForm(this)" 
action=http://send.ivansms.com/ibook/dtMo_reg.asp method=post><INPUT type=hidden 
value=8272749 name=sessionid> <INPUT type=hidden value="mwjx" name=publisher> 
<TABLE cellSpacing=0 cellPadding=0 width=500 border=0>
  <TBODY>
  <TR>
    <TD colSpan=6><IMG height=63 alt="" src="/mwjx/images/sendmobil/aiwen_01.gif" 
      width=500></TD>
    <TD><IMG height=63 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD colSpan=6><IMG height=21 alt="" src="/mwjx/images/sendmobil/aiwen_02.gif" 
      width=500></TD>
    <TD><IMG height=21 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD colSpan=6><IMG height=25 alt="" src="/mwjx/images/sendmobil/aiwen_03.gif" 
      width=500></TD>
    <TD><IMG height=25 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD colSpan=3><IMG height=5 alt="" src="/mwjx/images/sendmobil/aiwen_04.gif" 
      width=316></TD>
    <TD background=/mwjx/images/sendmobil/aiwen_05.gif colSpan=2 rowSpan=2><INPUT 
      id=name maxLength=15 size=18 name=name value="<?=$m_title;?>"></TD>
    <TD rowSpan=12><IMG height=391 alt="" src="/mwjx/images/sendmobil/aiwen_06.gif" 
      width=9></TD>
    <TD><IMG height=5 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD rowSpan=11><IMG height=386 alt="" src="/mwjx/images/sendmobil/aiwen_07.gif" 
      width=30></TD>
    <TD bgColor=#ffffff rowSpan=8><TEXTAREA class=text14 style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; WIDTH: 268px; BORDER-BOTTOM: medium none; HEIGHT: 165px; wrap: " name=output_str rows=11 wrap=VIRTUAL cols=35 VIRTUAL?><?=$m_content;?>
			</TEXTAREA></TD>
    <TD rowSpan=11><IMG height=386 alt="" src="/mwjx/images/sendmobil/aiwen_09.gif" 
      width=18></TD>
    <TD><IMG height=19 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD colSpan=2><IMG height=15 alt="" src="/mwjx/images/sendmobil/aiwen_10.gif" 
      width=175></TD>
    <TD><IMG height=15 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD background=/mwjx/images/sendmobil/aiwen_11.gif colSpan=2><INPUT id=phonenum 
      onkeyup="this.value=this.value.replace(/\D/gi,'')" maxLength=11 size=15 
      value=13 name=phonenum></TD>
    <TD><IMG height=22 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD vAlign=bottom background=/mwjx/images/sendmobil/aiwen_12.gif colSpan=2><FONT 
      color=#2182e7>支持国内外所有彩屏手机</FONT></TD>
    <TD><IMG height=19 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD background=/mwjx/images/sendmobil/aiwen_13.gif colSpan=2><FONT 
      color=#2182e7>首次使用请查看操作指南</FONT></TD>
    <TD><IMG height=24 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD colSpan=2><IMG height=17 alt="" src="/mwjx/images/sendmobil/aiwen_14.gif" 
      width=175></TD>
    <TD><IMG height=17 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD background=/mwjx/images/sendmobil/aiwen_15.gif colSpan=2></TD>
    <TD><IMG height=24 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD background=/mwjx/images/sendmobil/aiwen_16.gif colSpan=2 rowSpan=2>
      <TABLE cellSpacing=0 cellPadding=0 width=92 border=0>
        <TBODY>
        <TR>
          <TD colSpan=2><IMG height=16 alt="" 
            src="/mwjx/images/sendmobil/direct_01.gif" width=92></TD></TR>
        <TR>
          <TD width=21 height=24><INPUT onclick=get_disable() type=radio 
            CHECKED value=1 name=opmode></TD>
          <TD><IMG height=24 alt="" src="/mwjx/images/sendmobil/direct_03.gif" 
            width=71></TD></TR>
        <TR>
          <TD width=21 height=24><INPUT type=radio value=2 name=opmode></TD>
          <TD><IMG height=23 alt="" src="/mwjx/images/sendmobil/direct_05.gif" 
            width=71></TD>
          <TD noWrap colSpan=3></TD></TR></TBODY></TABLE><FONT 
      color=#494949>&nbsp;<LIT>选择最快的发送服务器.</LIT><BR><INPUT type=radio CHECKED 
      value=1 name=IPORT>CN1<INPUT type=radio value=1 name=IPORT>CN2<INPUT 
      type=radio value=1 name=IPORT>CN3<INPUT type=radio value=1 
      name=IPORT>CN4</FONT><BR><A 
      href="http://send.ivansms.com/ibook/sendbook.asp?url=http://link.iuse.com.cn/style/book/style1.html&amp;publisher=test#"><IMG 
      onclick='window.showModalDialog("http://ns.ivansms.com/images/help.gif",window,"dialogWidth:450px;dialogHeight:330px;help:no;resizable:no;status:no;scroll:no;")' 
      src="/mwjx/images/sendmobil/helpbutton.gif" border=0></A></TD>
    <TD><IMG height=27 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD rowSpan=3><IMG height=219 alt="" src="/mwjx/images/sendmobil/aiwen_17.gif" 
      width=268 useMap=#Map border=0></TD>
    <TD><IMG height=110 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD><INPUT style="CURSOR: hand" type=image height=33 alt=点击下一步开始生成手机格式小说文件 
      width=99 src="/mwjx/images/sendmobil/aiwen_18.gif" border=0></TD>
    <TD vAlign=top width=76 background=/mwjx/images/sendmobil/aiwen_19.gif height=109 
    rowSpan=2></TD>
    <TD><IMG height=33 alt="" src="/mwjx/images/sendmobil/spacer.gif" width=1></TD></TR>
  <TR>
    <TD><IMG height=76 alt="" src="/mwjx/images/sendmobil/aiwen_20.gif" width=99 
      useMap=#Map2 border=0></TD>
    <TD><IMG height=76 alt="" src="/mwjx/images/sendmobil/spacer.gif" 
  width=1></TD></TR></FORM></TBODY></TABLE><MAP name=Map><AREA shape=RECT 
  target=_blank alt=点击进入在线帮助 coords=220,146,276,165 
  href="http://www.ivansms.com/ophelp.html"><AREA style="CURSOR: hand" 
  onclick='window.open("http://pay.ivansms.com/coop/faq.asp","_blank","left=120,top=120,width=100,height=100")' 
  shape=RECT target=_blank alt=点击进入业务合作栏目 coords=196,199,251,217 
  href="http://send.ivansms.com/ibook/sendbook.asp?url=http://link.iuse.com.cn/style/book/style1.html&amp;publisher=test#"></MAP><MAP 
name=Map2><AREA shape=RECT target=_blank alt=点击进入BBs论坛 coords=9,37,68,53 
  href="http://bbs.ivansms.com/"></MAP></BODY></HTML>
