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

<xsl:apply-templates select="listview"/>
</xsl:element>
</html>
</xsl:template>
<xsl:template match="listview">
	<TABLE border="0" align="center" width="778">
	<TBODY><TR>
	<TD width="30%" align="left" valign="top">
	<xsl:apply-templates select="article"/>	
	</TD>
	<TD width="30%" valign="top">
	<xsl:apply-templates select="article2"/>	
	</TD>
	<TD width="30%" valign="top" align="right">
	<xsl:apply-templates select="article3"/>		
	</TD>
	<TD width="10%" valign="bottom" align="right">
	<a href="/data/last.xml" target="_blank">更多...</a>
	</TD>
	</TR>
	</TBODY>
	</TABLE>
</xsl:template>

<xsl:template match="listview/article | listview/article2  | listview/article3">
	<div style="width:100%;line-height:18px;" class="BG3" align="left">
			
		<div class="bgr3" style="padding-left:8px;padding-top:5px;"><xsl:value-of select="@name"/> ---《妙文精选》</div>
		<div id="dre" class="pad10L" style="padding-top:4px;padding-bottom:5px;table-layout:fixed; word-break :break-all;">
		<xsl:apply-templates select="item"/>
		</div>
	</div>
</xsl:template>
<xsl:template match="item">
	<span style="height:22px;">
	<xsl:if test="../@name='新文章点击'">
	[<xsl:value-of select="./num"/>]
	</xsl:if>

	<xsl:apply-templates select="./img_star"/>			
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_article.php&amp;id=<xsl:value-of select="./id"/>&amp;state=dynamic&amp;r_cid=<xsl:value-of select="./cid"/></xsl:attribute>
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
