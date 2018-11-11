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
					//ɾ������
					//����:��
					//���:��
					alert(window.parent.document.all.roll.src);
					//alert("ɾ������");
				}
				function good_article(flag)
				{
					//��������
					//����:flag(bool)true/false(����/ȥ������)
					//���:��
					alert("��������");
				}
			]]>
			</script>
			<base target="roll"/>
		</head>
		<body leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
			<table width="778" align="center"><tr><td>
			<xsl:apply-templates select="listview"/>
			</td></tr></table>
		</body>
		</html>
	</xsl:template>

	<xsl:template match="listview">
		<b><xsl:value-of select="title"/></b><span style="width:30px;"></span>
		<!--<a href="mailto:liang0735@gmail.com?subject=">����Ȩ��</a>//-->
		<xsl:apply-templates select="res_type"/>
	</xsl:template>

	<xsl:template match="res_type">
		
		<div style="margin-left:0px;">		
			<img src="../image/treenode.png" alt="node" width="16" height="9"/>��Դ����:<xsl:value-of select="name"/><br/>
			<xsl:apply-templates select="res"/>
		</div>
	</xsl:template>

	<xsl:template match="res">
		<div style="margin-left:20px;">
		<img src="../image/treenode.png" alt="node" width="16" height="9"/>��Դ���ƻ�ID:<xsl:value-of select="name"/>

			<div style="margin-left:20px;word-break:break-all;width:700px;">
			<img src="../image/treenode.png" alt="node" width="16" height="9"/>����Ȩ��:<xsl:apply-templates select="action"/>
			</div>
		</div>
	</xsl:template>
	<xsl:template match="action">
		<xsl:element name="input">
			<xsl:attribute name="type">checkbox</xsl:attribute>
			<xsl:attribute name="disabled">true</xsl:attribute>
			<xsl:if test="enable='Y'">
				<xsl:attribute name="checked">true</xsl:attribute>
			</xsl:if>
		</xsl:element>
		<xsl:value-of select="name"/><span style="width:20px"></span>
	</xsl:template>
</xsl:stylesheet>
