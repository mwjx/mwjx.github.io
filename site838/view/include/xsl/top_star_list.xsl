<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
<html>
<head>
	<title>星级文章列表|妙文精选|www.mwjx.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
	<LINK href="/image/indeximage/content.css" type="text/css" rel="stylesheet"/>

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
.BG3{border:1px solid #cccccc;margin-top:10px}
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
<xsl:if test="listview/tbl = 1">
<script language="JavaScript" src="/top.js"></script>
<TABLE height="10" cellSpacing="0" cellPadding="0" width="778" align="center" border="0"><TBODY>
    <TR>
	    <TD width="1" bgColor="#8c8c8c"></TD>
    <TD width="225" bgColor="#cccccc"></TD>
    <TD width="1" bgColor="#8c8c8c"></TD>
    <TD width="550" bgColor="#cccccc" align="right">&#149;<a href="/sitemap.html">网站地图</a>&#149;</TD>
         <TD width="1" bgColor="#8c8c8c"></TD>
  </TR></TBODY></TABLE>
</xsl:if>

<TABLE height="10" cellSpacing="0" cellPadding="0" width="778" align="center" border="0"><TBODY>
    <TR>
	    <TD width="1" bgColor="#8c8c8c"></TD>
    <TD width="776" align="left">
<b>评级宗旨</b>:<br/>
既不能曲高和寡，也不能口水得毫无深度。最好的文章应该是有内容而且观赏性强。<br/>
<b>评级标准</b>:<br/>
值得收藏:1分<br/>
思想性，有启发，引人思考:最多2分<br/>
观赏性，通俗易懂，看完大呼过瘾:最多2分<br/>
根据上面3个指标评分，合计3分为3星文章，4分为4星文章，5分为5星文章。最低3星，最高5星。
</TD>
         <TD width="1" bgColor="#8c8c8c"></TD>
  </TR>
    <TR>
    <TD width="778" colspan="3" bgColor="#8c8c8c" height="1">
</TD>
  </TR>  
  </TBODY></TABLE>
<!--//-->

<xsl:apply-templates select="listview"/>
<TABLE cellSpacing="0" cellPadding="0" width="778" border="0" align="center"><TBODY><TR bgColor="#8c8c8c"><TD align="right">本站只支持IE系列5.0以上浏览器<span style="width:10px;"></span><a  href="mailto: liang_0735@21cn.com" title="" target="_blank">联系站长</a><span style="width:10px;"></span><a href="http://www.miibeian.gov.cn/" target="_blank">沪ICP备05010539号</a></TD></TR></TBODY></TABLE>
<iframe name="submitframe" width="0" height="0"></iframe>
<xsl:if test="listview/tbl = 1">
<script language="JavaScript" src="/bottom.js"></script>
</xsl:if>
</xsl:element>
</html>
</xsl:template>
<xsl:template match="listview">
	<TABLE height="10" cellSpacing="0" cellPadding="0" width="778" align="center" border="0">
	<TBODY>
	<TR valign="top">
	<TD width="100%" align="center">	
<div class="bgr3" style="padding-left:0px;padding-top:0px;"><h2>类目</h2></div>
	</TD>
	</TR>	
	<xsl:apply-templates select="class/star"/>	
	<TR valign="top">
	<TD width="100%" align="center">	
<div class="bgr3" style="padding-left:0px;padding-top:0px;"><h2>文章</h2></div>
	</TD>
	</TR>	

	<xsl:apply-templates select="article/star"/>	
	</TBODY>
	</TABLE>
</xsl:template>
<xsl:template match="listview/article/star | listview/class/star">
	<TR valign="top">
	<TD width="100%">	
	<div style="width:100%;line-height:0px;" class="BG3">			
		<div class="bgr3" style="padding-left:8px;padding-top:0px;">
		<xsl:value-of select="@num"/>星级
		<xsl:apply-templates select="img_star"/>
		</div>
		<div id="dre" class="pad10L" style="padding-top:4px;padding-bottom:5px;table-layout:fixed; word-break :break-all;">
		<xsl:apply-templates select="item"/>
		</div>
	</div>
	</TD>
	</TR>
</xsl:template>
<xsl:template match="article/star/item">
	<xsl:value-of select="./aday"/><span style="width:20px"/>
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_article.php&amp;id=<xsl:value-of select="./id"/>&amp;state=dynamic&amp;r_cid=<xsl:value-of select="./cid"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:attribute name="title"><xsl:value-of select="./title_more"/></xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element>
	<span style="width:20px"/>荐稿人:<xsl:value-of select="./poster"/>
	<span style="width:20px"/><br/>
</xsl:template>
<xsl:template match="class/star/item">	
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/home.php?main=./src_php/class_homepage.php&amp;cid=<xsl:value-of select="./id"/></xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:attribute name="title"><xsl:value-of select="./title_more"/></xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element>
	<span style="width:20px"/>
</xsl:template>
<xsl:template match="img_star">
	<xsl:element name="img">
		<xsl:attribute name="src"><xsl:value-of select="../../../path_img"/></xsl:attribute>
	</xsl:element>
</xsl:template>
<xsl:template match="set_star">
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=set_star&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<select id="slt_star" name="slt_star" >
		<option value="-1">取消星级</option>
		<option selected="selected" value="3">3星</option>
		<option value="4">4星</option>
		<option value="5">5星</option>
		</select>
		<button onclick="this.form.submit();">评级</button>
	</xsl:element>
</xsl:template>
</xsl:stylesheet>
