<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
<html>
<head>
<title>�Ƽ�����</title>
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
		//���ٷ���
		//����:obj����������
		//���:true�ɹ�,falseʧ��
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
		//�ύ����
		//����:��
		//���:��
		//alert("bbb");
		var list = "";		
		for(var i = 0;i < cb_class.length; ++i){
			if(cb_class[i].checked){
				if("" != list)
					list += ",";
				list += cb_class[i].id;
			}
		}
		if("" == document.all["hd_aid"].value){ //���Ǳ༭��Ҫѡ��Ŀ
			if("" == list)
				return alert("��ѡ��Ҫ����������Ŀ��ѡ��!");
		}
		if("" == document.all["txt_title"].value)
			return alert("���ⲻ��Ϊ��!");
		if("" == document.all["txt_content"].value)
			return alert("���ݲ���Ϊ��!");
		if(document.all["txt_content"].value.length >50000)
			return alert("���ݳ��Ȳ������50000");

		//----------�ύ---------
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
		//----------�ύ---------
		var title = document.all["txt_title"].value.replace(/&/g,'��');
		var content = document.all["txt_content"].value.replace(/&/g,'��');

		var str = ("fun=post_article&title="+title+"&content="+content+"&clist="+list);
		var o_http = submit_str2(str,"../cmd.php");
		if(false === o_http)
			return alert("�ύʧ��");
		//�ظ�
		if(4 != o_http.readyState)
			return alert("�ύû���յ��ظ�");
		if(o_http.status != 200)
			return alert("�ظ�״̬�쳣");
		if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
			return alert("�ظ�Ϊ��");
		//return alert(o_http.responseText);		
		if("FAIL" == o_http.responseText){
			alert("�ύʧ��");
		}
		else{
			//alert("�ύ�ɹ�:"+o_http.responseText);
			var arr = list.split(",");
			goto_url(o_http.responseText,arr[0]);
		}
		*/
		//alert("�ύ����:"+list);
	}
	function goto_url(id,cid)
	{
		//ȥһ������ҳ
		//����:id����ID
		//���:��
		var url = "";
		url = "/mwjx/src_php/data_article.php?id="+id+"&r_cid="+cid;
	
		window.location.href=(url);
	}
	function init()
	{
		//��ʼ��
		//����:��
		//���:��
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
		document.all["txt_title"].value = "�����й���%#$^%$KDFGKR&^)&)%$)^";
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
    <td width="100%" align="left">����(����)��
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
    <td>����(����)��</td>
  </tr>
  <tr bgcolor="#f4f4f4"> 
    <td>�� 
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
		<button onclick="javascript:post();"> �����ύ </button>
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
<input type="submit" value="�ϴ�ͼƬ"/>		
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
			<xsl:attribute name="alt">ѡ����Ŀ</xsl:attribute>
		</xsl:element>			
		<xsl:element name="input">
			<xsl:attribute name="type">checkbox</xsl:attribute>
			<xsl:attribute name="name">cb_class</xsl:attribute>
			<xsl:attribute name="id"><xsl:value-of select="../@id"/></xsl:attribute>
		</xsl:element>

	</xsl:template>
</xsl:stylesheet>
