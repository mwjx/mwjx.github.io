<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
<html>
<head>
	<title>最新|妙文精选|www.mwjx.com</title>
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
<TABLE height="10" cellSpacing="0" cellPadding="0" width="778" align="center" border="0"><TBODY>
    <TR>
	    <TD width="1" bgColor="#8c8c8c"></TD>
    <TD width="225" bgColor="#cccccc"></TD>
    <TD width="1" bgColor="#8c8c8c"></TD>
    <TD width="550" bgColor="#cccccc" align="right">&#149;<a href="/sitemap.html">网站地图</a>&#149;</TD>
         <TD width="1" bgColor="#8c8c8c"></TD>
  </TR></TBODY></TABLE>
<!--//-->

<xsl:apply-templates select="listview"/>
</xsl:element>
<script language="JavaScript" src="/bottom.js"></script>
</html>
</xsl:template>
<xsl:template match="listview">
	<TABLE cellSpacing="0" cellPadding="0" width="778" align="center" border="0">
	<TBODY><TR valign="top">
	<TD width="34%" align="left">
	<xsl:apply-templates select="recommend"/>	
	</TD>
	
	<TD width="66%" valign="top" rowspan="2" colspan="2">
	<table width="100%" border="0" cellSpacing="0" cellPadding="0">
	<tr><td width="50%" valign="top"><xsl:apply-templates select="article"/></td>
	<td width="50%" valign="top" align="right"><xsl:apply-templates select="article2"/></td></tr>
	<tr><td width="100%" colspan="2">
<IFRAME align="left" marginWidth="0" marginHeight="0" src="/mwjx/include/ad/toplast_468_60.html" frameBorder="0" width="468" scrolling="no" height="60"></IFRAME>	
	</td></tr>
	</table>
	</TD>
	<!--
	<TD width="33%" valign="top" rowspan="2">
	<xsl:apply-templates select="article"/>	
	</TD>
	<TD width="33%" valign="top" align="right" rowspan="2">
	<xsl:apply-templates select="article2"/>		
	</TD>
	//-->
	<!--<IFRAME align="left" marginWidth="0" marginHeight="0" src="/mwjx/include/ads_google_200_200.html" frameBorder="0" width="200" scrolling="no" height="200"></IFRAME>
	//-->
	</TR>
	<TR valign="top">
	<TD width="34%">
	<xsl:apply-templates select="star"/>	
	</TD>
	</TR>
	<TR valign="top">
	<TD width="34%" align="left">
	<xsl:apply-templates select="new_vote"/>
	</TD>
	<TD width="33%" valign="top">	
	<xsl:apply-templates select="good"/>	
	</TD>
	<TD width="33%" valign="top" align="right">
	<xsl:apply-templates select="up_hp"/>
	</TD>
	</TR>

	<!--
	<TR valign="top">
	<TD width="100%" colspan="3">
	<IFRAME align="right" marginWidth="0" marginHeight="0" src="/mwjx/include/ads_google_728_90.html" frameBorder="0" width="728" scrolling="no" height="90"></IFRAME>
	</TD>
	</TR>
	//-->
	<TR valign="top">
	<TD width="100%" colspan="3" align="right">
	<xsl:apply-templates select="reply"/>	
	</TD>
	</TR>
	<TR valign="top">
	<TD width="34%">
	<xsl:apply-templates select="class"/>
	</TD>
	<TD width="33%" colspan="1" align="right">
	<xsl:apply-templates select="new_user"/>
	</TD>
	<TD width="33%" colspan="1" align="right">
	<IFRAME align="right" marginWidth="0" marginHeight="0" src="/mwjx/include/ad/toplast_250_250.html" frameBorder="0" width="250" scrolling="no" height="250"></IFRAME>	
	</TD>

	</TR>
	</TBODY>
	</TABLE>
</xsl:template>

<xsl:template match="listview/class | listview/article | listview/article2 | listview/good | listview/reply | listview/star | listview/recommend | listview/new_vote | listview/up_hp | listview/new_user">
	<div style="width:100%;line-height:18px;" class="BG3" align="left">
			
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
<xsl:template match="up_hp/item | new_user/item">
	<span style="height:22px;">
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/myhome.php?id=<xsl:value-of select="./id"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element></span><br/>
</xsl:template>
<xsl:template match="class/item">
<!--	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_class.php&amp;cid=<xsl:value-of select="./id"/>&amp;page=1&amp;per=20</xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element><br/>//-->
	<span style="height:22px;">
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/class_homepage.php?cid=<xsl:value-of select="./id"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element></span><br/>
</xsl:template>

<xsl:template match="reply/item">
	[<xsl:value-of select="./dte"/>]<xsl:value-of select="./poster"/>:
	<xsl:choose>
		<xsl:when test="r_type='A'">
			<xsl:element name="a">
				<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="./gid"/>&amp;state=dynamic&amp;r_cid=12</xsl:attribute>
				<xsl:attribute name="target">_blank</xsl:attribute>
				<xsl:value-of select="./content"/>
			</xsl:element>
		</xsl:when>
		<xsl:when test="r_type='C'">
			<xsl:element name="a">
				<xsl:attribute name="href">/mwjx/src_php/class_homepage.php?cid=<xsl:value-of select="./gid"/></xsl:attribute>
				<xsl:attribute name="target">_blank</xsl:attribute>
				<xsl:value-of select="./content"/>
			</xsl:element>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="./content"/>
		</xsl:otherwise>
	</xsl:choose>

	<br/>
</xsl:template>
<xsl:template match="item">
	<span style="height:22px;">
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
<xsl:template match="img_star">
	<xsl:element name="img">
		<xsl:attribute name="src"><xsl:value-of select="../../../path_img"/></xsl:attribute>
	</xsl:element>
</xsl:template>
</xsl:stylesheet>
