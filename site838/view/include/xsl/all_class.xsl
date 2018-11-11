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
		//添加类目输入窗
		//输入:id(string)父类目ID,fname(string)父类目名称
		//输出:无
		var name = window.prompt("在类目《"+fname+"》下建立一个子类目，请输入子类目的名称:","");
		if(null == name)
			return;
		if("" == name)
			return alert("类目名称不能为空");
		var xmldoc = new_xmldom();
		if(false === xmldoc)
			return alert("创建xmldom对象失败");
		var url = "../cmd.php?fun=new_class&fid="+id+"&name="+name;
		xmldoc.async="false";
		xmldoc.load(url);
		var str_confrim = "创建类目失败";
		//alert(xmldoc.xml);
		if(null != xmldoc.documentElement.childNodes[0])
			str_confrim = xmldoc.documentElement.childNodes[0].text;
		alert(str_confrim);
	}
	function del_class(id,name)
	{
		//删除类目
		//输入:id(string)是类目ID,name(string)类目名称
		//输出:无
		if("" == id || "" == name)
			return alert("类目ID或名称不能为空");
		if(!confirm("真的要删除该类目《"+name+"》吗？"))
			return;			
		var xmldoc = new_xmldom();
		if(false === xmldoc)
			return alert("创建xmldom对象失败");
		var url = "../cmd.php?fun=del_class&id="+id;
		xmldoc.async="false";
		xmldoc.load(url);
		var str_confrim = "删除类目失败";
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
			<xsl:attribute name="alt">添加类目</xsl:attribute>
		</xsl:element>			
		<xsl:element name="span">
			<xsl:attribute name="style">cursor:hand;text-decoration:underline;</xsl:attribute>
			<xsl:attribute name="onclick">javascript:add_class(<xsl:value-of select="../@id"/>,"<xsl:value-of select="../@text"/>");</xsl:attribute>添加</xsl:element>

		<xsl:element name="span">
			<xsl:attribute name="style">width:15px;</xsl:attribute>		
		</xsl:element>

		<xsl:element name="img">
			<xsl:attribute name="src">../image/bsall4.gif</xsl:attribute>
			<xsl:attribute name="width">9</xsl:attribute>
			<xsl:attribute name="height">9</xsl:attribute>
			<xsl:attribute name="alt">删除类目</xsl:attribute>
		</xsl:element>
		<xsl:element name="span">
			<xsl:attribute name="style">cursor:hand;text-decoration:underline;</xsl:attribute>
			<xsl:attribute name="onclick">javascript:del_class(<xsl:value-of select="../@id"/>,"<xsl:value-of select="../@text"/>");</xsl:attribute>删除</xsl:element>
	</xsl:template>
</xsl:stylesheet>
