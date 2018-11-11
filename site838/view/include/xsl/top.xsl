<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
<html>
<head>
	<title>排行榜|妙文精选|www.mwjx.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
	<LINK href="/image/indeximage/content.css" type="text/css" rel="stylesheet"/>

	<STYLE type="text/css">
	<![CDATA[
div,td{font-family: 宋体;}
a:link {color:#261cdc;text-decoration: none}
a:visited {color: #261cdc; text-decoration: none}
a.t:link{color:#261cdc;text-decoration: none}a.t:hover{color:#261cdc;text-decoration: none}a.t:visited{color:#800080;text-decoration: none}
td{font-size:12px; line-height:18px;}
.red{color:#FF0000;}
.fB{ font-weight:bold;}
.pad10L{padding-left:10px; }.g{color:#666666}
.i{font-size:16px;font-family:arial}
a.top{font-family:arial}
a.top:link {COLOR: #0000cc; text-decoration: none}
a.top:visited {COLOR: #800080; text-decoration: none}
a.top:active {COLOR: #0000cc; text-decoration: none}
/*相关贴吧新增样式*/
.BG3{border:1px solid #cccccc;margin-top:10px}
.bgr3{background-color:#eeeeee;height:24px;line-height:24px}
.pad5L{padding-left:5px; }
/*以下为页首样式*/
body,form{margin:0}
	]]>
	</STYLE>
</head>
<xsl:element name="body">
	<xsl:attribute name="leftMargin">0</xsl:attribute>
	<xsl:attribute name="topMargin">0</xsl:attribute>
	<xsl:attribute name="marginheight">0</xsl:attribute>
	<xsl:attribute name="marginwidth">0</xsl:attribute>

<script language="JavaScript" src="/top.js"></script>
<!--//-->
<TABLE height="10" cellSpacing="0" cellPadding="0" width="778" align="center" border="0"><TBODY>
    <TR>
	    <TD width="1" bgColor="#8c8c8c"></TD>
    <TD width="225" bgColor="#cccccc"></TD>
    <TD width="1" bgColor="#8c8c8c"></TD>
    <TD width="550" bgColor="#cccccc" align="right">&#149;<a href="/sitemap.html">网站地图</a>&#149;</TD>
         <TD width="1" bgColor="#8c8c8c"></TD>
  </TR></TBODY></TABLE>

<xsl:apply-templates select="listview"/>
<script language="JavaScript" src="/bottom.js"></script>
<!--
//-->
</xsl:element>
</html>
</xsl:template>
<xsl:template match="listview">
	<TABLE align="center" width="778" border="0" cellSpacing="0" cellPadding="0">
	<TBODY><TR valign="top">
	<TD width="33%">	
	<xsl:apply-templates select="reply"/>	
	</TD>
	<TD width="33%">
	<xsl:apply-templates select="vote"/>
	</TD>
	<TD width="34%" valign="top">
	<xsl:apply-templates select="last_click"/>	
	</TD>
	<!--

	//-->
	</TR>
	<TR valign="top">
	<TD width="33%">
	<xsl:apply-templates select="click"/>	
	</TD>
	<TD width="33%">
	<xsl:apply-templates select="week_click"/>	
	</TD>
	<TD width="34%">
	<xsl:apply-templates select="class_click"/>
	</TD>
	<!--
	//-->
	</TR>
	<TR valign="top">
	<TD width="33%">
	<xsl:apply-templates select="poster"/>	
	</TD>
	<TD width="33%">
	<xsl:apply-templates select="visit"/>	
	</TD>
	<TD width="34%">
	<xsl:apply-templates select="last_click2"/>
	</TD>
	</TR>
	<!--<TR valign="top">
	<TD width="100%" colspan="3">
	<IFRAME align="right" marginWidth="0" marginHeight="0" src="/mwjx/include/ads_google_728_90.html" frameBorder="0" width="728" scrolling="no" height="90"></IFRAME>
	</TD>
	</TR>//-->
	<TR valign="top">
	<TD width="33%">
	<xsl:apply-templates select="month_click"/>
	</TD>
	<TD width="33%">
	<xsl:apply-templates select="month3_click"/>
	</TD>
	<TD width="34%">
	<xsl:apply-templates select="month6_click"/>
	</TD>

	</TR>
	<TR valign="top">
	<TD width="33%">
	<xsl:apply-templates select="keyword"/>
	</TD>
	<TD width="67%" colspan="2">
	<IFRAME align="left" marginWidth="0" marginHeight="0" src="/mwjx/include/ads_google_336_280.html" frameBorder="0" width="336" scrolling="no" height="280"></IFRAME>
	</TD>
	</TR>
	</TBODY>
	</TABLE>
</xsl:template>
<xsl:template match="listview/click | listview/visit | listview/reply | listview/vote | listview/poster | listview/last_click | listview/last_click2 | listview/week_click | listview/month_click | listview/month3_click | listview/month6_click | listview/class_click">
	<div style="width:100%;line-height:18px;" class="BG3">
			
		<div class="bgr3" style="padding-left:8px;padding-top:5px;"><xsl:value-of select="@name"/>
		<xsl:element name="a">
			<xsl:attribute name="name"><xsl:value-of select="name()"/></xsl:attribute>
		</xsl:element>
		</div>
		<div id="dre" class="pad10L" style="padding-top:4px;padding-bottom:5px;table-layout:fixed; word-break :break-all;">
		<xsl:apply-templates select="item"/>
		</div>
	</div>
</xsl:template>
<xsl:template match="listview/keyword">
	<div style="width:100%;line-height:18px;" class="BG3">
			
		<div class="bgr3" style="padding-left:8px;padding-top:5px;"><xsl:value-of select="@name"/></div>
		<div id="dre" class="pad10L" style="padding-top:4px;padding-bottom:5px;table-layout:fixed; word-break :break-all;">
		<xsl:apply-templates select="item"/>
		</div>
	</div>
</xsl:template>
<xsl:template match="keyword/item">
	<span style="height:22px;">
	[<xsl:value-of select="./num"/>]
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_class.php?type=search&amp;page=1&amp;per=10&amp;show_type=dynamic&amp;cid=0&amp;str=<xsl:value-of select="./searchkey"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:attribute name="title"><xsl:value-of select="./title_more"/></xsl:attribute>
		<xsl:value-of select="./keyword"/>
	</xsl:element></span><br/>
</xsl:template>
<xsl:template match="poster/item">	
	<span style="height:22px;">
	[<xsl:value-of select="./num"/>]
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/myhome.php?id=<xsl:value-of select="./id"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element></span><br/>

</xsl:template>
<xsl:template match="item">
	<span style="height:22px;">
	[<xsl:value-of select="./num"/>]
	<xsl:apply-templates select="./img_star"/>	
	
	<xsl:element name="a">
		<xsl:attribute name="href"><xsl:value-of select="./url"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:attribute name="title"><xsl:value-of select="./title_more"/></xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element>
	</span>
	<br/>
</xsl:template>
<xsl:template match="class_click/item">
<!--	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_class.php&amp;cid=<xsl:value-of select="./id"/>&amp;page=1&amp;per=20</xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element><br/>//-->
	<span style="height:22px;">
	[<xsl:value-of select="./num"/>]
	<xsl:element name="a">
		<!--
		<xsl:attribute name="href">/mwjx/home.php?main=./src_php/class_homepage.php&amp;cid=<xsl:value-of select="./id"/></xsl:attribute>//-->
		<xsl:attribute name="href">/data/<xsl:value-of select="./id"/>.html</xsl:attribute>
		
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element></span><br/>
</xsl:template>

<xsl:template match="img_star">
	<xsl:element name="img">
		<xsl:attribute name="src"><xsl:value-of select="../../../path_img"/></xsl:attribute>
	</xsl:element>
</xsl:template>
</xsl:stylesheet>
