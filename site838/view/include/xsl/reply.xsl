<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
		<html>
		<head>
			<title>评论|妙文精选|www.mwjx.com</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<LINK rev="stylesheet" media="screen" 
href="../css/reply.css" type="text/css" rel="stylesheet"/>
<SCRIPT src="../include/script/webtabs.js" type="text/javascript"></SCRIPT>
<SCRIPT src="../include/script/cookie.js" type="text/javascript"></SCRIPT>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript" src="../include/script/reply.js"></script>
<script type="text/javascript" src="../include/script/url.js"></script>
<script type="text/javascript">
<![CDATA[
function goto_url(id,page,per,gt)
{
	//去一个索引页
	//输入:id文章ID,page页数,per每页记录数
	//gt留言主题类型C/A(类目/文章)
	//输出:无
	var url = "";
	url = "/mwjx/src_php/reply.php?gtype="+gt+"&id="+id+"&per="+per+"&page="+page;
	//alert(url);
	window.location.href=(url);
}
function init()
{
	//alert("aaa");
	try{
		f_start(0);
	}
	catch(err){
		//alert(err.message);
	}
}
function reply()
{
	//回复
	//输入:无
	//输出:无
	var content = document.all["message"].value;
	if("" == content)
		return alert("留言内容不能为空");
	if(content.length > 200)
		return alert("留言长度不能超过200");
	if("" == document.all["cid"].value)
		return alert("异常，类目ID为空");
	if("" == document.all["reply_type"].value)
		return alert("异常，跟贴类型为空");
	if("" == document.all["fun"].value)
		return alert("异常，调用接口为空");
	//alert("回复功能未完成");	
	//alert("回复:"+content);
	//return alert(document.all["cid"].value);
	//----------提交---------
	//alert(document.all["frmsubmit"]);
	//document.all["hd_clist"].value = list;
	document.all["frmsubmit"].action = '../cmd.php';
	//document.all["txt_title"].value = list;
	//alert(document.all["frmsubmit"].action);
	document.all["frmsubmit"].submit();
}
]]>
			</script>
<STYLE type="text/css">
<![CDATA[

]]>
</STYLE>
		</head>
<xsl:element name="body">
	<xsl:attribute name="leftMargin">0</xsl:attribute>
	<xsl:attribute name="topMargin">0</xsl:attribute>
	<xsl:attribute name="marginheight">0</xsl:attribute>
	<xsl:attribute name="marginwidth">0</xsl:attribute>
<xsl:apply-templates select="listview/pagelist"/>
<xsl:apply-templates select="listview"/>

<iframe name="submitframe" width="0" height="0"></iframe>
</xsl:element>

</html>
	</xsl:template>
	<xsl:template match="listview">
			<xsl:apply-templates select="reply"/>        				
	  <TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
       border="0">
		<TR><TD align="right">
<script language="JavaScript" type="text/javascript">
function agent_version()
{
	//浏览器版本
	//输入:无
	//输出:true是IE,异常(非IE都为异常)返回false
	
	try{
		if(navigator.userAgent.toLowerCase().indexOf("firefox") != -1)
			return false;
		if(!window.clientInformation){
			return false;
		}
		if(window.clientInformation.appName.toLowerCase()!="microsoft internet explorer"){
			return false;
		}
		if(window.clientInformation.appVersion.toLowerCase().indexOf("msie")==-1){
			return false;
		}
		var str = window.clientInformation.appVersion.toLowerCase();
		if(-1 == str.indexOf("msie"))		
			return false;
		return true;
	}
	catch(exception){
	}
	
	return false;
}
//alert(agent_version());
</script>

<script language="JavaScript" type="text/javascript">
//----------客户端惟一代号----------
var cookieString = new String(document.cookie);
var cookieHeader = "fc_uniqid=" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = "";
if (beginPosition == -1){  //没有cookie,种植
	sFc_uniqid = Math.round(Math.random() * 2147483647);
	document.cookie = cookieHeader+sFc_uniqid+";expires=Sun, 18 Jan 2038 00:00:00 GMT;"+"path=/";
}
else{
	var pos_end = cookieString.indexOf(";",beginPosition);
	var pos_start = beginPosition+cookieHeader.length;
	if(-1 != pos_end){
		sFc_uniqid = cookieString.substr(pos_start,(pos_end - pos_start));
	}
}
//--------end 惟一代号-------------------
var fromr = top.document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==""? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
if(agent_version()){ //ie才显示,firefox下会出错
	document.write('<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="废墟流量统计" border="0"/></a>');	
}
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="废墟流量统计" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>
<a href="#" onclick="javascript:history.go(-1);">返回</a>

		</TD></TR></TABLE>
	</xsl:template>

	<xsl:template match="listview/reply">
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FCD6EA">
	<TBODY>

			<xsl:apply-templates select="item"/>        
	</TBODY>
	</table>

	</xsl:template>
	<xsl:template match="listview/reply/item">
	<tr><td bgcolor="#FFFFFF"><img src="/mwjx/images/tie.gif" border="0"/></td><td bgcolor="#FFFFFF">
	<table cellspacing="0" cellpadding="0" width="100%" 
	border="0"><tbody>
	<tr>
	<td></td>
	<td 
	height="18" align="left"><strong></strong></td>
	<td></td>
	</tr>
	<tr>
	<td></td>
	<td align="left"><p class="MsoNormal" 
	style="MARGIN: 0cm 0cm 0pt; TEXT-INDENT: 24pt; TEXT-ALIGN: left; mso-char-indent-count: 2.0; mso-pagination: widow-orphan" 
	align="left">
		<xsl:call-template name="br">
		<xsl:with-param name="string" select="./content"/>
		</xsl:call-template>	  

	</p></td>
	<td></td>
	</tr>
	<tr>
	<td></td>
	<td align="left"></td>
	<td></td>
	</tr>
	<tr>
	<td></td>
	<td align="left"><img height="1" src="" width="530" /></td>
	<td></td>
	</tr>
	<tr>
	<td></td>
	<td align="left"><div 
	align="right"><span style="15px"></span><strong><xsl:value-of select="./name"/></strong><span style="5px;"></span>发表于：<xsl:value-of select="./time"/></div></td>
	<td>		<xsl:element name="form">
			<xsl:attribute name="action">/mwjx/cmd.php?fun=rm_reply&amp;id=<xsl:value-of select="./id"/>&amp;type=<xsl:value-of select="./old_new"/></xsl:attribute>
			<xsl:attribute name="method">POST</xsl:attribute>
			<xsl:attribute name="target">submitframe</xsl:attribute>
			<button onclick="if(confirm('删除是种很严重的行为，确定要删除吗？'))this.form.submit();">删</button>
			<span style="width:5px;"></span><a href="#" onclick="javascript:alert('不适合出现在妙文精选的文章都可以删除，欢迎大家来清理妙文精选');return false;"><img src="/mwjx/images/whats_this.gif" border="0"/></a>	
		</xsl:element></td>
	</tr>
	<tr>
	<td height="8"></td>
	<td height="8"></td>
	<td height="8"></td>
	</tr>
	</tbody>
	</table></td>
	</tr>

	</xsl:template>

	<xsl:template match="listview/pagelist">
	 <table border="0" width="100%" cellspacing="0" cellpadding="0"
	  style="font-size: 10pt"><tr>
	<td width="100%" valign="bottom" align="left">
	<TABLE width="100%" border="1" class="fenyeTable" cellspacing="0" cellpadding="0" >
	<TR>
		<TD width="30%" align="left">
		<xsl:apply-templates select="go_page_list/go_page"/></TD>
		<TD width="40%" align="right">
<xsl:apply-templates select="per_list"/> 记录/页
		</TD>
		<TD width="10%" align="right">
		当前页:<xsl:value-of select="current"/>
		</TD>
		<TD width="20%" align="right">
		总量:<xsl:value-of select="count"/> 记录</TD>
	</TR>
	</TABLE>
	</td></tr></table>
	</xsl:template>	
	<xsl:template match="listview/pagelist/go_page_list/go_page">
		<xsl:choose>
			<xsl:when test="enable">
				   <xsl:value-of select="name"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:element name="a">
					<xsl:attribute name="href">#</xsl:attribute>
					<xsl:attribute name="onclick">javascript:goto_url('<xsl:value-of select="../../../gid"/>','<xsl:value-of select="page"/>','<xsl:value-of select="../../num_per_page"/>','<xsl:value-of select="../../../gt"/>');</xsl:attribute>
					<xsl:attribute name="target">_self</xsl:attribute>
					<xsl:value-of select="name"/> 
				</xsl:element>  
			</xsl:otherwise>
		</xsl:choose>
		<xsl:choose>
			<xsl:when test="end">
			</xsl:when>
			<xsl:otherwise>
				|  
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="listview/pagelist/per_list">
		<xsl:element name="select">
		<xsl:attribute name="name">select_per_page</xsl:attribute>
		<xsl:attribute name="onchange">javascript:goto_url('<xsl:value-of select="../../gid"/>','1',select_per_page[select_per_page.selectedIndex].value,'<xsl:value-of select="../../gt"/>');</xsl:attribute>
			<xsl:for-each select="per_page">
				<xsl:element name="option">
				<xsl:if test="num = ../../num_per_page">
				<xsl:attribute name="selected">true</xsl:attribute>
				</xsl:if>
				<xsl:attribute name="value"><xsl:value-of select="num"/></xsl:attribute>
				<xsl:value-of select="name"/>
				</xsl:element>
			</xsl:for-each>
		</xsl:element>  		
	</xsl:template>
	<xsl:template name="br">
		<xsl:param name="string"/>
		<xsl:choose>
			<xsl:when test="contains($string,'[img]')">
				<xsl:call-template name="br">
				<xsl:with-param name="string" select="substring-before($string,'[img]')"/>
				</xsl:call-template>				
				<xsl:call-template name="img">
				<xsl:with-param name="string" select="substring-after($string,'[img]')"/>
				</xsl:call-template>
				<!--//-->
				<!--
				<xsl:element name="img">
					<xsl:attribute name="src">			
						http://localhost/data/up_pics/decdf062cab63a52dd4001733d98363d.jpg
					</xsl:attribute> 
				</xsl:element>  
				//-->
				<xsl:call-template name="br">
				<xsl:with-param name="string" select="substring-after($string,'[/img]')"/>
				</xsl:call-template>
			</xsl:when>
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
	<xsl:template name="img">
		<xsl:param name="string"/>
		<xsl:element name="img">
			<xsl:attribute name="src">			
				<!--http://localhost/data/up_pics/decdf062cab63a52dd4001733d98363d.jpg//-->
				<xsl:value-of select="substring($string,0,70)"/>
			</xsl:attribute> 
		</xsl:element>  
		
	</xsl:template>
</xsl:stylesheet>

