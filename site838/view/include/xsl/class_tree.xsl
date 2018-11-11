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
	function list_class(id)
	{
		//展开类目
		//输入:id(string)是类目ID
		//输出:无
		
		//alert(parent.document.all.article_list_ed.src);
		//window.location.href
		var url = "./data_class.php?cid="+id+"&page=1&per=20&type=manager";
		//if(-1 == window.location.href.indexOf("article_ed"))
		//	parent.document.all.article_list_un.src = url+"&e=un";
		//else
		//	parent.document.all.article_list_ed.src = url+"&e=ed";
		if(-1 != window.location.href.indexOf("article_ed")){
			parent.document.all.article_list_ed.src = url+"&e=ed";
		}
		else if(-1 != window.location.href.indexOf("class_link_un")){
			url = "./son_class.php?cid="+id+"&page=1&per=20&e=un";
			parent.document.all.class_list_un.src = url;
			//alert("类目链接未选");
		}
		else if(-1 != window.location.href.indexOf("class_link_ed")){
			url = "./son_class.php?cid="+id+"&page=1&per=20&e=ed";
			parent.document.all.class_list_ed.src = url;
			//alert("类目链接已选");
		}
		else{
			parent.document.all.article_list_un.src = url+"&e=un";		
		}
		//alert(parent.article_list_ed.src);
		//alert(parent.frames.article_list_un.innerText);
		//alert(window.parent.frames.article_list_un.src);
		//alert(window.location.href);
		//window.parent.article_list_un.src="../home.php";
		//alert(id);
		/*
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
		*/
	}
]]>
			</script>
			<base target="roll"/>
		</head>
		<body leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" >
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
		<xsl:element name="a">
			<xsl:attribute name="href">#</xsl:attribute>
			<xsl:attribute name="onclick">javascript:list_class(<xsl:value-of select="../@id"/>); return false;</xsl:attribute>
			<xsl:value-of select="."/>
		</xsl:element>

	</xsl:template>
</xsl:stylesheet>
