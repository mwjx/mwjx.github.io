<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
<html>
<head>
<title>推荐文章</title>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312"/>
<link rel="stylesheet" href="../css/all.css" type="text/css"/>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript" src="../include/script/url.js"></script>
<script type="text/javascript" encoding="GB2312">
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
	function quick_post(obj)
	{
		//快速发布
		//输入:obj被触发对象
		//输出:true成功,false失败
		if("title" == obj.name){
			if(13 != event.keyCode)
				return true;
			if("" == obj.value)
				return false;
			post();
			return false;
		}
		if(event.ctrlKey && (13 == event.keyCode))
			post();
	}
	function post()
	{
		//提交发布
		//输入:无
		//输出:无
		//alert("bbb");
		var list = "";		
		for(var i = 0;i < cb_class.length; ++i){
			if(cb_class[i].checked){
				if("" != list)
					list += ",";
				list += cb_class[i].id;
			}
		}
		if("" == document.all["hd_aid"].value){ //不是编辑，要选类目
			if("" == list)
				return alert("请选中要发布到的类目复选框!");
		}
		if("" == document.all["txt_title"].value)
			return alert("标题不能为空!");
		if("" == document.all["txt_content"].value)
			return alert("内容不能为空!");
		if(document.all["txt_content"].value.length >50000)
			return alert("内容长度不能起过50000");

		//----------提交---------
		document.all["hd_clist"].value = list;
		document.all["frmsubmit"].action = '../cmd.php';
		//document.all["txt_title"].value = list;
		//alert(document.all["frmsubmit"].action);
		//submitframe
		document.all["frmsubmit"].submit();
		//alert("aaa");
		return;
		/**/
		/*
		//----------提交---------
		var title = document.all["txt_title"].value.replace(/&/g,'＆');
		var content = document.all["txt_content"].value.replace(/&/g,'＆');

		var str = ("fun=post_article&title="+title+"&content="+content+"&clist="+list);
		var o_http = submit_str2(str,"../cmd.php");
		if(false === o_http)
			return alert("提交失败");
		//回复
		if(4 != o_http.readyState)
			return alert("提交没有收到回复");
		if(o_http.status != 200)
			return alert("回复状态异常");
		if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
			return alert("回复为空");
		//return alert(o_http.responseText);		
		if("FAIL" == o_http.responseText){
			alert("提交失败");
		}
		else{
			//alert("提交成功:"+o_http.responseText);
			var arr = list.split(",");
			goto_url(o_http.responseText,arr[0]);
		}
		*/
		//alert("提交发布:"+list);
	}
	function goto_url(id,cid)
	{
		//去一个文章页
		//输入:id文章ID
		//输出:无
		var url = "";
		url = "/mwjx/src_php/data_article.php?id="+id+"&r_cid="+cid;
	
		window.location.href=(url);
	}
	function init()
	{
		//初始化
		//输入:无
		//输出:无
		var id = get_get_var2("id",window.document.location.href);
		//id = "12";
		if(false === id)
			return;
		for(var i = 0;i < cb_class.length; ++i){
			if(id == cb_class[i].id){
				cb_class[i].checked = true;				
			}
		}
		/*
		//-----------------tests-----------
		//cb_class[i].checked = true;	
		document.all["txt_title"].value = "我是中国人%#$^%$KDFGKR&^)&)%$)^";
		document.all["txt_content"].value = "aaa&%$#^$%#^&%^$&";
		post();
		//alert(id);						
		*/
	}
]]>
			</script>
			<base target="roll"/>
		</head>
		<body onload = "javascript:init();">
			<xsl:apply-templates select="listview"/>
<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">
 <table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" >
  <tr bgcolor="#f4f4f4" height="30" valign="top"> 
    <td width="100%" align="left">标题(必填)：
	<xsl:element name="input">
		<xsl:attribute name="type">text</xsl:attribute>
		<xsl:attribute name="id">txt_title</xsl:attribute>
		<xsl:attribute name="name">title</xsl:attribute>
		<xsl:attribute name="size">50</xsl:attribute>
		<xsl:attribute name="onkeydown">javascript:return quick_post(this);</xsl:attribute>
		<xsl:attribute name="value"><xsl:value-of select="listview/article/title"/></xsl:attribute>
	</xsl:element>				
	</td>
  </tr>
  <tr bgcolor="#f4f4f4"> 
    <td>内容(必填)：</td>
  </tr>
  <tr bgcolor="#f4f4f4"> 
    <td>　 
	<xsl:element name="input">
		<xsl:attribute name="type">hidden</xsl:attribute>
		<xsl:attribute name="name">hd_aid</xsl:attribute>
		<xsl:attribute name="value"><xsl:value-of select="listview/article/id"/></xsl:attribute>
	</xsl:element>				
	<xsl:element name="textarea">
		<xsl:attribute name="cols">80</xsl:attribute>
		<xsl:attribute name="id">txt_content</xsl:attribute>
		<xsl:attribute name="name">content</xsl:attribute>
		<xsl:attribute name="rows">22</xsl:attribute>
		<xsl:attribute name="style">FONT-SIZE: 9pt</xsl:attribute>

		<xsl:attribute name="onkeydown">javascript:quick_post(this);</xsl:attribute>
		<xsl:value-of select="listview/article/content"/>
	</xsl:element>				
		 </td>
  </tr>
</table>
<input name="fun" type="hidden" value="post_article"/>
<input id="hd_clist" name="clist" type="hidden" value=""/>
		<center>
		<button onclick="javascript:post();"> 发布提交 </button>
		</center>
</form>
<form name="frm_article_pic" method="post" enctype="multipart/form-data" action="../src_php/recive_pic.php" target="submitframe">
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
      <tr>
        <td height="29" align="left">
<input type="file" name="file_img1" style="width:140px;"/>
<input type="file" name="file_img2" style="width:140px;"/>
<input type="file" name="file_img3" style="width:140px;"/>
<input type="file" name="file_img4" style="width:140px;"/>
<input type="file" name="file_img5" style="width:140px;"/>
<input type="submit" value="上传图片"/>		
		</td>
      </tr>
</table>
</form>

<iframe name="submitframe" width="0" height="0"></iframe>
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
		<xsl:value-of select="."/>
		==>		
		<xsl:element name="img">
			<xsl:attribute name="src">../image/bsall3.gif</xsl:attribute>
			<xsl:attribute name="width">9</xsl:attribute>
			<xsl:attribute name="height">9</xsl:attribute>
			<xsl:attribute name="alt">选择类目</xsl:attribute>
		</xsl:element>			
		<xsl:element name="input">
			<xsl:attribute name="type">checkbox</xsl:attribute>
			<xsl:attribute name="name">cb_class</xsl:attribute>
			<xsl:attribute name="id"><xsl:value-of select="../@id"/></xsl:attribute>
		</xsl:element>

	</xsl:template>
</xsl:stylesheet>
