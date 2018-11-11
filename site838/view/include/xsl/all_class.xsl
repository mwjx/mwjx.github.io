<?xml version="1.0"  encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
		<head>
			<title>menu</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
			<link rel="stylesheet" href="../css/all.css" type="text/css"/>
			<script type="text/javascript" src="../include/script/xmldom.js"></script>
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
	function add_class(id,fname)
	{
		//�����Ŀ���봰
		//����:id(string)����ĿID,fname(string)����Ŀ����
		//���:��
		var name = window.prompt("����Ŀ��"+fname+"���½���һ������Ŀ������������Ŀ������:","");
		if(null == name)
			return;
		if("" == name)
			return alert("��Ŀ���Ʋ���Ϊ��");
		var xmldoc = new_xmldom();
		if(false === xmldoc)
			return alert("����xmldom����ʧ��");
		var url = "../cmd.php?fun=new_class&fid="+id+"&name="+name;
		xmldoc.async="false";
		xmldoc.load(url);
		var str_confrim = "������Ŀʧ��";
		//alert(xmldoc.xml);
		if(null != xmldoc.documentElement.childNodes[0])
			str_confrim = xmldoc.documentElement.childNodes[0].text;
		alert(str_confrim);
	}
	function del_class(id,name)
	{
		//ɾ����Ŀ
		//����:id(string)����ĿID,name(string)��Ŀ����
		//���:��
		if("" == id || "" == name)
			return alert("��ĿID�����Ʋ���Ϊ��");
		if(!confirm("���Ҫɾ������Ŀ��"+name+"����"))
			return;			
		var xmldoc = new_xmldom();
		if(false === xmldoc)
			return alert("����xmldom����ʧ��");
		var url = "../cmd.php?fun=del_class&id="+id;
		xmldoc.async="false";
		xmldoc.load(url);
		var str_confrim = "ɾ����Ŀʧ��";
		//alert(xmldoc.xml);
		if(null != xmldoc.documentElement.childNodes[0])
			str_confrim = xmldoc.documentElement.childNodes[0].text;
		alert(str_confrim);		
	}
]]>
			</script>
			<base target="roll"/>
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
		<div style="margin-left:20px; white-space:nowrap">
			<xsl:choose>
				<xsl:when test="count(child::*) > 0">
					<div>
						<img src="../image/treeminus.png" alt="plus" width="16" height="9" onclick="ClickEvent(this)"/>
						<xsl:apply-templates select="@text"/>
					</div>
					<div style="display:block">
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
		<xsl:value-of select="."/>
		==>		
		<xsl:element name="img">
			<xsl:attribute name="src">../image/bsall3.gif</xsl:attribute>
			<xsl:attribute name="width">9</xsl:attribute>
			<xsl:attribute name="height">9</xsl:attribute>
			<xsl:attribute name="alt">�����Ŀ</xsl:attribute>
		</xsl:element>			
		<xsl:element name="span">
			<xsl:attribute name="style">cursor:hand;text-decoration:underline;</xsl:attribute>
			<xsl:attribute name="onclick">javascript:add_class(<xsl:value-of select="../@id"/>,"<xsl:value-of select="../@text"/>");</xsl:attribute>���</xsl:element>

		<xsl:element name="span">
			<xsl:attribute name="style">width:15px;</xsl:attribute>		
		</xsl:element>

		<xsl:element name="img">
			<xsl:attribute name="src">../image/bsall4.gif</xsl:attribute>
			<xsl:attribute name="width">9</xsl:attribute>
			<xsl:attribute name="height">9</xsl:attribute>
			<xsl:attribute name="alt">ɾ����Ŀ</xsl:attribute>
		</xsl:element>
		<xsl:element name="span">
			<xsl:attribute name="style">cursor:hand;text-decoration:underline;</xsl:attribute>
			<xsl:attribute name="onclick">javascript:del_class(<xsl:value-of select="../@id"/>,"<xsl:value-of select="../@text"/>");</xsl:attribute>ɾ��</xsl:element>
	</xsl:template>
</xsl:stylesheet>
