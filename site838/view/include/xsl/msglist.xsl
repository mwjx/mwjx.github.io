<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
		<html>
		<head>
			<title>文章列表 - (妙文精选提供)</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<SCRIPT src="../include/script/cookie.js" type="text/javascript"></SCRIPT>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript">
<![CDATA[
function goto_url(state,cid,page,per)
{
	//去一个索引页
	//输入:state:static/dynamic(静态页面/动态页面)
	//cid类目ID,page页数,per每页记录数
	//输出:无
	var url = "";
	if("static" == state){ //静态
		url = "/data/"+cid+"_"+per+"_"+page+".xml";
	}
	else{ //动态
		url = "/mwjx/src_php/data_class.php?cid="+cid+"&per="+per+"&page="+page;
		if(false != get_get_var("type")){
			//return alert(get_get_var("type"));
			if("search" == get_get_var("type")){ //搜索
				var show_type = get_get_var("show_type");
				var str = get_get_var("str");
				if(false == show_type || false == str)
					return alert("搜索条件无效，跳转页面失败");
				url += ("&type=search&show_type="+show_type+"&str="+str);
			}
			if("user_article" == get_get_var("type")){ //用户文章
				var show_type = get_get_var("show_type");
				var str = get_get_var("str");
				if(false == show_type || false == str)
					return alert("搜索条件无效，跳转页面失败");
				url += ("&type=user_article&show_type="+show_type+"&str="+str);
			}
		}
	}
	window.location.href=(url);
}
function init()
{
	try{
		f_start();
	}
	catch(err){
		//alert(err.message);
	}
}
]]>
			</script>
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
.BG3{border:1px solid #cccccc;margin-top:0px}
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
<br/><br/><br/>
<script src="/online_back.php"></script>
<iframe name="submitframe" width="0" height="0"></iframe>
</xsl:element>

</html>
	</xsl:template>
<xsl:template match="listview">
<xsl:apply-templates select="action"/>
<xsl:apply-templates select="msg_receive"/>
<xsl:apply-templates select="msg_send"/>


</xsl:template>
<xsl:template match="listview/action">
<center><h2>待审核动作列表</h2></center>
<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
bgColor="#cccccc" border="0">
<TR bgColor="#ffffff">
  <TD align="middle" width="5%">(未完成)批量审核：
  <button>允许</button>
  <button>拒绝</button></TD>
</TR>
</TABLE>
<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
bgColor="#cccccc" border="0">
<THEAD>
<TR bgColor="#ffffff">
  <TD align="middle" width="5%">选择</TD>
  <TD align="middle" width="10%"><STRONG><FONT 
	color="#546fa4">类型</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">提请人</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">提请时间</FONT></STRONG></TD>
  <TD align="middle" width="40%"><STRONG><FONT color="#546fa4">内容说明</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">操作</FONT></STRONG></TD>

</TR></THEAD>

<TBODY>
	<xsl:apply-templates select="item"/>        
</TBODY>
</TABLE>

</xsl:template>
<xsl:template match="listview/msg_receive">
<center><h2>站内短信（我收到的）</h2></center>
<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
bgColor="#cccccc" border="0">
<THEAD>
<TR bgColor="#ffffff">
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">发件人</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">发件时间</FONT></STRONG></TD>
  <TD align="middle" width="55%"><STRONG><FONT color="#546fa4">内容</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">是否已读</FONT></STRONG></TD>

</TR></THEAD>

<TBODY>
	<xsl:apply-templates select="item"/>        
</TBODY>
</TABLE>

</xsl:template>
<xsl:template match="listview/msg_send">
<center><h2>站内短信（我发出的）</h2></center>
<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
bgColor="#cccccc" border="0">
<THEAD>
<TR bgColor="#ffffff">
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">收件人</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">发件时间</FONT></STRONG></TD>
  <TD align="middle" width="55%"><STRONG><FONT color="#546fa4">内容</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">是否已读</FONT></STRONG></TD>

</TR></THEAD>

<TBODY>
	<xsl:apply-templates select="item"/>        
</TBODY>
</TABLE>

</xsl:template>

<xsl:template match="listview/action/item">
	<TR bgColor="#ffffff">
	 <TD align="middle" width="5%">
		<xsl:element name="input">
		<xsl:attribute name="type">checkbox</xsl:attribute>
		<xsl:attribute name="name">box_<xsl:value-of select="id"/></xsl:attribute>
		</xsl:element>
	 
	 </TD>
	  <TD align="middle" width="10%"><xsl:value-of select="tname"/></TD>
	  <TD align="middle" width="15%"><xsl:apply-templates select="requester"/></TD>
	  <TD align="middle" width="15%"><xsl:value-of select="atime"/></TD>
	  <TD align="middle" width="40%"><xsl:apply-templates select="content"/></TD>
	  <TD align="middle" width="15%"><xsl:apply-templates select="id"/></TD>		
	</TR>	
</xsl:template>
<xsl:template match="listview/msg_receive/item">

	<TR bgColor="#ffffff">
	  <TD align="middle" width="15%"><xsl:apply-templates select="sender"/></TD>
	  <TD align="middle" width="15%"><xsl:value-of select="modify"/></TD>
	  <TD align="middle" width="55%">标题:<font color="red"><xsl:value-of select="title"/></font><br/><xsl:apply-templates select="content"/></TD>
	  <TD align="middle" width="15%"><xsl:apply-templates select="had"/></TD>		
	</TR>	
</xsl:template>
<xsl:template match="listview/msg_send/item">

	<TR bgColor="#ffffff">
	  <TD align="middle" width="15%"><xsl:apply-templates select="receiver"/></TD>
	  <TD align="middle" width="15%"><xsl:value-of select="modify"/></TD>
	  <TD align="middle" width="55%">标题:<font color="red"><xsl:value-of select="title"/></font><br/><xsl:apply-templates select="content"/></TD>
	  <TD align="middle" width="15%"><xsl:apply-templates select="had"/></TD>		
	</TR>	
</xsl:template>
<xsl:template match="sender | receiver">
<xsl:value-of select="name"/><br/>
给 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=<xsl:value-of select="id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<xsl:value-of select="name"/> 
	</xsl:element>
 发站内短信
</xsl:template>
<xsl:template match="action/item/requester">
<xsl:value-of select="name"/><br/>
给 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=<xsl:value-of select="id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<xsl:value-of select="name"/> 
	</xsl:element>
 发站内短信
</xsl:template>
<xsl:template match="content/txt">
<xsl:value-of select="."/><br/>
</xsl:template>
<xsl:template match="content">
<xsl:apply-templates select="txt"/>
<xsl:apply-templates select="article"/>
<xsl:apply-templates select="class"/>
</xsl:template>
<xsl:template match="msg_receive/item/had | msg_send/item/had">
<xsl:choose>
	<xsl:when test=". = 'Y'">
		已读
	</xsl:when>
	<xsl:otherwise>
		未读
	</xsl:otherwise>
</xsl:choose>

</xsl:template>

<xsl:template match="listview/action/item/id">

	<table><tr>
	<td>
	<xsl:element name="form">
		<xsl:attribute name="action">/site838/view/cmd.php?fun=run_action&amp;id=<xsl:value-of select="."/>&amp;effect=Y&amp;tid=<xsl:value-of select="../tid"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<button onclick="this.form.submit();">允许</button> 
	</xsl:element>
	</td>
	<td>
	<xsl:element name="form">
		<xsl:attribute name="action">/site838/view/cmd.php?fun=run_action&amp;id=<xsl:value-of select="."/>&amp;effect=N&amp;tid=<xsl:value-of select="../tid"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<button onclick="this.form.submit();">拒绝</button> 
	</xsl:element>

	</td>
	</tr></table>

</xsl:template>
<xsl:template match="article">
	 <xsl:call-template name="br">
	 <xsl:with-param name="string" select="./text"/>
	 </xsl:call-template>
	<xsl:element name="a">
		<xsl:attribute name="href">/site838/view/track/show.php?id=<xsl:value-of select="./id"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:attribute name="title"><xsl:value-of select="./title"/></xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element><br/>
</xsl:template>
<xsl:template match="class">
	 <xsl:call-template name="br">
	 <xsl:with-param name="string" select="./text"/>
	 </xsl:call-template>
	<xsl:element name="a">
		<xsl:attribute name="href">
		class_homepage.php?cid=<xsl:value-of select="./id"/>
		</xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element>
</xsl:template>
<xsl:template name="br">
	<xsl:param name="string"/>
	<xsl:choose>
	<xsl:when test="contains($string,'&#10;')">
	 <xsl:value-of select="substring-before($string,'&#10;')"/><br/>
	 <xsl:call-template name="br">
	 <xsl:with-param name="string" select="substring-after($string,'&#10;')"/>
	 </xsl:call-template>
	</xsl:when>
	<xsl:otherwise>
	 <xsl:value-of select="$string"/>
	</xsl:otherwise>
	</xsl:choose>
</xsl:template>
</xsl:stylesheet>
