<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
		<html>
		<head>
			<title>������˽��״̬ - (���ľ�ѡ�ṩ)</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<SCRIPT src="../include/script/cookie.js" type="text/javascript"></SCRIPT>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript">
<![CDATA[
function goto_url(state,cid,page,per)
{
	//ȥһ������ҳ
	//����:state:static/dynamic(��̬ҳ��/��̬ҳ��)
	//cid��ĿID,pageҳ��,perÿҳ��¼��
	//���:��
	var url = "";
	if("static" == state){ //��̬
		url = "/data/"+cid+"_"+per+"_"+page+".xml";
	}
	else{ //��̬
		url = "/mwjx/src_php/data_class.php?cid="+cid+"&per="+per+"&page="+page;
		if(false != get_get_var("type")){
			//return alert(get_get_var("type"));
			if("search" == get_get_var("type")){ //����
				var show_type = get_get_var("show_type");
				var str = get_get_var("str");
				if(false == show_type || false == str)
					return alert("����������Ч����תҳ��ʧ��");
				url += ("&type=search&show_type="+show_type+"&str="+str);
			}
			if("user_article" == get_get_var("type")){ //�û�����
				var show_type = get_get_var("show_type");
				var str = get_get_var("str");
				if(false == show_type || false == str)
					return alert("����������Ч����תҳ��ʧ��");
				url += ("&type=user_article&show_type="+show_type+"&str="+str);
			}
		}
	}
	//
	//alert(url);
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
div,td{font-family: ����;}
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
/*�������������ʽ*/
.BG3{border:1px solid #cccccc;margin-top:0px}
.bgr3{background-color:#eeeeee;height:24px;line-height:24px}
.pad5L{padding-left:5px; }
/*����Ϊҳ����ʽ*/
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
<script src="/online_back.php"></script>
<iframe name="submitframe" width="0" height="0"></iframe>
</xsl:element>

</html>
	</xsl:template>
<xsl:template match="listview">
<xsl:apply-templates select="action"/>
</xsl:template>
<xsl:template match="listview/action">
<center><h2>�ο����붯�����״̬</h2></center>
<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
bgColor="#cccccc" border="0">
<THEAD>
<TR bgColor="#ffffff">
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">����</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">������</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">����ʱ��</FONT></STRONG></TD>
  <TD align="middle" width="40%"><STRONG><FONT color="#546fa4">����˵��</FONT></STRONG></TD>
  <TD align="middle" width="15%"><STRONG><FONT 
	color="#546fa4">״̬</FONT></STRONG></TD>

</TR></THEAD>

<TBODY>
	<xsl:apply-templates select="item"/>        
</TBODY>
</TABLE>
<script language="JavaScript" type="text/javascript">
function agent_version()
{
	//������汾
	//����:��
	//���:true��IE,�쳣(��IE��Ϊ�쳣)����false
	
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
//----------�ͻ���Ωһ����----------
var cookieString = new String(document.cookie);
var cookieHeader = "fc_uniqid=" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = "";
if (beginPosition == -1){  //û��cookie,��ֲ
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
//--------end Ωһ����-------------------
var fromr = top.document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==""? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
if(agent_version()){ //ie����ʾ,firefox�»����
	document.write('<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="��������ͳ��" border="0"/></a>');	
}
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="��������ͳ��" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>
</xsl:template>
<xsl:template match="listview/action/item">
	<TR bgColor="#ffffff">
	  <TD align="middle" width="15%"><xsl:value-of select="tname"/></TD>
	  <TD align="middle" width="15%"><xsl:apply-templates select="requester"/></TD>
	  <TD align="middle" width="15%"><xsl:value-of select="atime"/></TD>
	  <TD align="middle" width="40%"><xsl:apply-templates select="content"/></TD>
	  <TD align="middle" width="15%"><xsl:value-of select="effect"/></TD>		
	</TR>	
</xsl:template>
<xsl:template match="sender">
<xsl:value-of select="name"/><br/>
�� 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=<xsl:value-of select="id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<xsl:value-of select="name"/> 
	</xsl:element>
 ��վ�ڶ���
</xsl:template>
<xsl:template match="action/item/requester">
<xsl:value-of select="name"/><br/>
�� 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=<xsl:value-of select="id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<xsl:value-of select="name"/> 
	</xsl:element>
 ��վ�ڶ���
</xsl:template>
<xsl:template match="content/txt">
<xsl:value-of select="."/><br/>
</xsl:template>
<xsl:template match="content">
<xsl:apply-templates select="txt"/>
<xsl:apply-templates select="article"/>
<xsl:apply-templates select="class"/>
</xsl:template>
<xsl:template match="article">
	 <xsl:call-template name="br">
	 <xsl:with-param name="string" select="./text"/>
	 </xsl:call-template>
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_article.php&amp;id=<xsl:value-of select="./id"/>&amp;state=dynamic&amp;r_cid=<xsl:value-of select="./cid"/></xsl:attribute>
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
