<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
<html>
<head>
	<title>����|���ľ�ѡ|www.mwjx.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
	<STYLE type="text/css">
	<![CDATA[
a			{ text-decoration: none; color: #003366 }
a:hover			{ text-decoration: underline }
body			{ scrollbar-base-color: #DFDFDF; scrollbar-arrow-color: #FFFFFF; font-size: 12px; background-color: #ffffff }
table			{ font: 12px Tahoma, Verdana; color: #004080 }
input,select,textarea	{ font: 12px Tahoma, Verdana; color: #004080; font-weight: normal; background-color: #DFDFDF }
select			{ font: 12px Tahoma; color: #004080; font-weight: normal; background-color: #DFDFDF }
.nav			{ font: 12px Tahoma, Verdana; color: #004080; font-weight: bold }
.nav a			{ color: #004080 }
.header			{ font: 12px Tahoma, Verdana; color: #ffffff; font-weight: bold; background-color: #606096 }
.header a		{ color: #ffffff }
.category		{ font: 12px Tahoma; color: #FFF788; background-color: #8080A6 }
.tableborder		{ background: #000000; border: 1px solid #FFFFFF } 
background-color: #DFDFDF }
.bold			{ font-weight: bold }
ul{
	margin:0;
	padding:0;
}

#last8{
	float:left;
	margin-left:0px;
	margin-top:0px;
	width:170px;
	height:60px;
	overflow:hidden;
}
#last8 ul {margin-top:0px;}
#last8 ul li{
	float:left;
	width:170px;
	white-space:nowrap;
	overflow:hidden;
	line-height:15px;
	text-indent:1em;
}



	]]>
	</STYLE>
</head>
<BODY leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" >
<xsl:apply-templates select="listview"/>
</BODY>
</html>
</xsl:template>
<xsl:template match="listview">
<table align="left" width="568" height="60" cellSpacing="0" cellPadding="0" BORDER="0" bgColor="#eeeeee">
	<TBODY>
	<TR valign="top">
	<TD width="30%" align="left">
	<xsl:apply-templates select="article"/>	
	</TD>
	<TD width="36%" align="left">
	<xsl:apply-templates select="last_click"/>	
	</TD>
	<TD width="34%" align="left">
	<xsl:apply-templates select="last_vote"/>	
	</TD>
	</TR>
	</TBODY>

</table>

</xsl:template>

<xsl:template match="listview/article">
	<DIV id="last8"><ul>	
		<xsl:apply-templates select="item"/>
	</ul></DIV>

</xsl:template>

<xsl:template match="listview/last_click | listview/last_vote">
		<xsl:apply-templates select="item"/>
</xsl:template>
<xsl:template match="article/item">
	<li>
	&#149;<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="./id"/>&amp;state=dynamic&amp;r_cid=<xsl:value-of select="./cid"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:attribute name="title"><xsl:value-of select="./title_more"/></xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element></li>
</xsl:template>
<xsl:template match="item">
	<span style="height:15px;">
	&#149;<xsl:if test="../@name='���µ��'">
	[<xsl:value-of select="./num"/>]
	</xsl:if>
	<xsl:if test="../@name='���ٵ��'">
	[<xsl:value-of select="./num"/>]
	</xsl:if>
	<xsl:apply-templates select="./img_star"/>			
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="./id"/>&amp;state=dynamic&amp;r_cid=<xsl:value-of select="./cid"/></xsl:attribute>
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
