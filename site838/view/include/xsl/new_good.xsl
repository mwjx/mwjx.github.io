<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
		<head>
			<title>最新被投票文章 - (妙文精选提供)</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
			<link rel="stylesheet" href="../include/report.css" type="text/css"/>
			<script type="text/javascript">
			<![CDATA[

			]]>
			</script>
		</head>
		<xsl:element name="body">
			<xsl:attribute name="style">background-color: #<xsl:value-of select="listview/bgcolor"/>;</xsl:attribute>
			<xsl:attribute name="leftMargin">0</xsl:attribute>
			<xsl:attribute name="topMargin">0</xsl:attribute>
			<xsl:attribute name="marginheight">0</xsl:attribute>
			<xsl:attribute name="marginwidth">0</xsl:attribute>
			<xsl:apply-templates select="listview"/>
			<iframe name="submitframe" width="0" height="0"></iframe>
		</xsl:element>
		</html>
	</xsl:template>
	<xsl:template match="listview">
		<TABLE align="left" width="90%">
		<thead>
		<TR class="listTableHead">
			<TD width="100%"><b><font size="2">最新被投票文章</font></b></TD>
		</TR>
		</thead>
		<TBODY>
			<xsl:apply-templates select="new/rc"/>			
		</TBODY></TABLE>
	</xsl:template>

	<xsl:template match="listview/new/rc">
		<xsl:element name="tr">
			<xsl:attribute name="height">20</xsl:attribute>
			<xsl:attribute name="align">left</xsl:attribute>
			<xsl:choose>
			<xsl:when test="bg=1">
			<xsl:attribute name="class">bgcolor_tr_1</xsl:attribute>
			</xsl:when>
			<xsl:otherwise>
			<xsl:attribute name="class">bgcolor_tr_2</xsl:attribute>
			</xsl:otherwise>
			</xsl:choose>
			<xsl:apply-templates select="title"/>
		</xsl:element>
	</xsl:template>
	<xsl:template match="listview/new/rc/title">
		<TD align="left">
			<xsl:element name="a">
				<xsl:attribute name="href"><xsl:value-of select="../path"/></xsl:attribute>
				<xsl:attribute name="class">a1</xsl:attribute>
				<xsl:attribute name="target">_blank</xsl:attribute>
				<xsl:value-of select="."/>
			</xsl:element>
			---&gt;<xsl:value-of select="../voter"/>
		</TD>
	</xsl:template>
</xsl:stylesheet>
