<?xml version="1.0" encoding="gb2312"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
		<head>
			<title>menu</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
			<link rel="stylesheet" href="../css/all.css" type="text/css"/>
			<script type="text/javascript">
			<![CDATA[
				function ClickEvent(img)
				{
					var content = img.parentNode.nextSibling;
					if ("none" == content.style.display)
					{
						content.style.display = "block";
						img.src = "../image/treeminus.png";
					}
					else
					{
						content.style.display = "none";
						img.src = "../image/treeplus.png";
					}
				}
				function del_article()
				{
					//删除文章
					//输入:无
					//输出:无
					alert(window.parent.document.all.roll.src);
					//alert("删除文章");
				}
				function good_article(flag)
				{
					//精华文章
					//输入:flag(bool)true/false(精华/去掉精华)
					//输出:无
					alert("精华文章");
				}
			]]>
			</script>
			<base target="roll"/>
			<xsl:apply-templates select="listview/had_newmsg"/>
		</head>
		<body>
			<xsl:apply-templates select="listview"/>
		</body>
		</html>
	</xsl:template>

	<xsl:template match="listview">
		<b><xsl:value-of select="@title"/></b>
		<xsl:apply-templates select="item"/><!--//-->
	</xsl:template>

	<xsl:template match="item">
		<div style="margin-left:10px; white-space:nowrap">
			<xsl:choose>
				<xsl:when test="count(child::*) > 0">
					<div>
						<img src="../image/treeplus.png" alt="plus" width="16" height="9" onclick="ClickEvent(this)"/>
						<xsl:apply-templates select="@text"/>
					</div>
					<div style="display:none">
						<xsl:apply-templates/>
					</div>
				</xsl:when>
				<xsl:otherwise>
					<div>
						<img src="../image/treenode.png" alt="node" width="16" height="9"/>
						<xsl:apply-templates select="@text"/>
					</div>
				</xsl:otherwise>
			</xsl:choose>
		</div>
	</xsl:template>

	<xsl:template match="@text">
		<xsl:choose>
			<xsl:when test="../@href">
				<xsl:choose>
					<xsl:when test="../@target">
					<a href="{ ../@href }" target="{ ../@target }">
						<xsl:value-of select="."/>
					</a>
					</xsl:when>
					<xsl:otherwise>
					<a href="{ ../@href }">
						<xsl:value-of select="."/>
					</a>
					<xsl:apply-templates select="../@newmsg_img"/>
					</xsl:otherwise>
				</xsl:choose>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="."/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="@newmsg_img">
		<xsl:element name="a">
			<xsl:attribute name="href">msglist.php</xsl:attribute>
			<xsl:element name="img">
				<xsl:attribute name="width">25</xsl:attribute>
				<xsl:attribute name="height">12</xsl:attribute>
				<xsl:attribute name="border">0</xsl:attribute>
				<xsl:attribute name="src"><xsl:value-of select="../@newmsg_img"/></xsl:attribute>
			</xsl:element>
		</xsl:element>
	</xsl:template>
	<xsl:template match="had_newmsg">
		<xsl:element name="BGSOUND">
			<xsl:attribute name="loop">1</xsl:attribute>
			<xsl:attribute name="autostart">false</xsl:attribute>
			<xsl:attribute name="src"><xsl:value-of select="@src"/></xsl:attribute>
		</xsl:element>
	</xsl:template>
</xsl:stylesheet>
