<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
		<html>
		<head>
			<title>�����б� - (���ľ�ѡ�ṩ)</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<LINK rev="stylesheet" media="screen" 
href="../css/reply.css" type="text/css" rel="stylesheet"/>
<SCRIPT src="../include/script/cookie.js" type="text/javascript"></SCRIPT>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript" src="../include/script/reply.js"></script>
<script type="text/javascript" src="../include/script/url.js"></script>
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
	window.open(url);
	//window.location.href=(url);
}
function init()
{
	/*
	try{
		f_start();
	}
	catch(err){
		//alert(err.message);
	}
	*/
}
function reply()
{
	//�ظ�
	//����:��
	//���:��
	var content = document.all["message"].value;
	if("" == content)
		return alert("�������ݲ���Ϊ��");
	if(content.length > 200)
		return alert("���Գ��Ȳ��ܳ���200");
	if("" == document.all["cid"].value)
		return alert("�쳣����ĿIDΪ��");
	if("" == document.all["reply_type"].value)
		return alert("�쳣����������Ϊ��");
	if("" == document.all["fun"].value)
		return alert("�쳣�����ýӿ�Ϊ��");
	//alert("�ظ�����δ���");	
	//alert("�ظ�:"+content);
	//return alert(document.all["cid"].value);
	//----------�ύ---------
	//alert(document.all["frmsubmit"]);
	//document.all["hd_clist"].value = list;
	document.all["frmsubmit"].action = '../cmd.php';
	//document.all["txt_title"].value = list;
	//alert(document.all["frmsubmit"].action);
	document.all["frmsubmit"].submit();
}
function check_confcode(str)
{
	//�����֤���Ƿ���д
	//����:str(string)��֤���������
	//���:true����,falseδ��д
	if("" == document.all[str].value){
		alert("����д��֤��");
		return false;
	}
	return true;
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
	<xsl:attribute name="onload">javascript:init();</xsl:attribute>
<h2>
<xsl:apply-templates select="listview/info/fid"/>
<xsl:value-of select="listview/info/name"/>
</h2>
<xsl:apply-templates select="listview"/>
<script src="/online_back.php"></script>
<iframe name="submitframe" width="0" height="0"></iframe>
</xsl:element>

</html>
	</xsl:template>
<xsl:template match="listview">
	<!--����Ŀ//-->
	<TABLE align="center" width="100%">
	<TBODY>
	<TR><TD>
		<xsl:apply-templates select="info/f_class"/>
	</TD></TR>
	<TR><TD>
		<xsl:apply-templates select="info/son_class"/>
	</TD></TR>
	</TBODY></TABLE>

	<!--ά�����б���������//-->
	<TABLE align="center" width="100%" border="0">
	<TBODY>
	<TR>
		<TD colspan="4" align="left">
		������:
		<xsl:element name="a">
			<xsl:attribute name="href">#</xsl:attribute>
			<xsl:value-of select="info/creator_name"/>
		</xsl:element>	
		ά����:<xsl:apply-templates select="manager"/>
		</TD>
	</TR>
	<TR>
		<TD colspan="1" align="right">
		</TD>
		<TD colspan="1" align="right">					
<!--<IFRAME marginWidth="0" marginHeight="0" src="/data/marquee.html" frameBorder="0" width="100%" height="18" scrolling="no" topmargin="0" leftmargin="0" align="left" valign="top"></IFRAME>//-->
		</TD>
		<TD colspan="1" align="right">					
			<form name="query" action="/mwjx/home.php" method="get" visable="false" target="_blank"><img src="/mwjx/images/searchsite.gif" width="78" height="18"/>
			<input type="hidden" name="main" value="./src_php/data_class.php"/>
			<input type="hidden" name="type" value="search"/>
			<input type="hidden" name="page" value="1"/>
			<input type="hidden" name="per" value="10"/>
			<input type="hidden" name="show_type" value="dynamic"/>
			<input type="hidden" name="cid" value="0"/>
			<input style="BORDER-RIGHT: 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" maxlength="12" size="26" name="str"/>
			<input style="BORDER-RIGHT: 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" type="submit" value=" ���� "/></form>			

		</TD>
		<TD colspan="1" align="right">					
		<xsl:element name="a">
			<xsl:attribute name="href">http://www.mwjx.com/mwjx/login.php</xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<img src="/mwjx/images/user_login.gif" border="0"/>
			��¼
		</xsl:element>	
		<xsl:element name="a">
			<xsl:attribute name="href">http://www.mwjx.com/mwjx/reg.php</xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<img src="/mwjx/images/user_reg.gif" border="0"/>
			ע��
		</xsl:element>	

		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/src_php/post_book.php?id=<xsl:value-of select="info/cid"/></xsl:attribute>
			<img src="/mwjx/images/post.gif" border="0"/>
			�ϴ��鼮
		</xsl:element>	
		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/src_php/data_all_class.php?type=post&amp;id=<xsl:value-of select="info/cid"/></xsl:attribute>
			<img src="/mwjx/images/post.gif" border="0"/>
			��������
		</xsl:element>	
		</TD>
	</TR>
	</TBODY>
	</TABLE>		
	<xsl:if test="class_dir">
	<xsl:apply-templates select="class_dir"/>
	</xsl:if>
	<!--�������¼��Ƽ�//-->
	<TABLE cellSpacing="0" cellPadding="5" width="100%" bgColor="#ffffff" border="0">
	<TBODY>
	<TR>
	<TD vAlign="top" align="left" width="70%">
	<xsl:apply-templates select="article_new"/>
	</TD>	
	<TD vAlign="top" align="left" width="30%">
	<xsl:apply-templates select="recommend"/>
	<span style="width:20px;"/>����и��£��� 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/mail_update.php#daily_mail</xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
		�ʼ�		
	</xsl:element>
 ֪ͨ��			
 <br/>
	<!--
	<xsl:if test="count(../article_info/img_star) > 0">
	�����Ǽ�:
	<xsl:apply-templates select="../article_info/img_star"/>
	</xsl:if>
	//-->
	<xsl:if test="count(./img_star) > 0">
	����Ŀ��ǰ����:<xsl:apply-templates select="./img_star"/>
	</xsl:if>	
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=set_star&amp;otype=class&amp;id=<xsl:value-of select="info/cid"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		��֤��:<input type="text" name="conf_star" size="5" value=""/><img src="/mwjx/pic.php?t=star" id="p_img_star" onclick="p_img_star.src='/mwjx/pic.php?t=star'" alt="��������������ͼƬ��֤��" style="cursor:hand;"/><br/>

		����:
		<select id="slt_star" name="slt_star" >
		<option value="-1">ȡ���Ǽ�</option>
		<option selected="selected" value="3">3��</option>
		<option value="4">4��</option>
		<option value="5">5��</option>
		</select>
		<button onclick="if(check_confcode('conf_star'))this.form.submit();">����</button>
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('������ּ:\n�Ȳ������ߺ͹ѣ�Ҳ���ܿ�ˮ�ú�����ȡ���õ�����Ӧ���������ݶ��ҹ�����ǿ��\n������׼:\nֵ���ղ�:1��\n˼���ԣ�������������˼��:���2��\n�����ԣ�ͨ���׶������������:���2��\n��������3��ָ�����֣��ϼ�3��Ϊ3�����£�4��Ϊ4�����£�5��Ϊ5�����¡����3�ǣ����5�ǡ�\n');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>
	</xsl:element>
	</TD>	

	</TR>
	<TR><TD colspan="2" align="right">
	</TD></TR>
	</TBODY></TABLE>

	<!--����//-->
	<TABLE cellSpacing="0" cellPadding="5" width="100%" bgColor="#ffffff" border="0">
	<TBODY>
	<TR>
	<TD vAlign="top" align="middle" width="100%">
	<xsl:apply-templates select="reply_list"/>	  
	</TD></TR></TBODY></TABLE>

	<!--���ۿ�//-->
	<TABLE align="center" width="100%" border="0">
	<TBODY><TR><TD>
	<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">

	<TABLE cellSpacing="0" cellPadding="5" width="575" bgColor="#ffffff" border="0">
	  <TBODY>
	  <TR>
		<TD style="TEXT-ALIGN: center">
		<TEXTAREA style="WIDTH: 545px; HEIGHT: 115px" name="message"></TEXTAREA>
		<input name="fun" type="hidden" value="reply"/>
		<input name="reply_type" type="hidden" value="class"/>
		<xsl:element name="input">
			<xsl:attribute name="name">cid</xsl:attribute>
			<xsl:attribute name="type">hidden</xsl:attribute>
			<xsl:attribute name="value"><xsl:value-of select="./info/cid"/></xsl:attribute>
		</xsl:element>
		</TD></TR>
	  <TR>
		<TD style="TEXT-ALIGN: left">
		  <TABLE  id="tbl_commit" cellSpacing="0" cellPadding="5" border="0" style="display:block">
			<TBODY>
			<TR>
			  <TD class="comment-btn2" align="middle"><INPUT onclick="javascript:reply();" id="bt_commit" style="display:block" type="button" value="" name="Submit32"/> 
			  </TD>
			  <TD class="comment-btn3"> 
			  </TD>
			  <TD>��CTRL+�س� ֱ���ύ���ۣ���������������ľ�ѡ��Ա,<A 
				href="http://www.mwjx.com/mwjx/reg.php" target="_blank"><FONT 
				color="#035c9e">��ӭע��</FONT></A><span style="width:12px"></span><A 
				href="http://www.mwjx.com/mwjx/login.php" target="_blank"><FONT 
				color="#035c9e">��¼</FONT></A>				
				</TD></TR>
			<TR>
			  <TD colspan="3">
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
<script type="text/javascript" src="http://fishcounter.3322.org/script/md5.js"></script>
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
//��ǰҳ
var c_page=location.href;
c_page = (c_page ==""? top.location.href : c_page);

var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
if(agent_version()){ //ie����ʾ,firefox�»����
	document.write('<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="��������ͳ��" border="0"/></a>');	
}
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="��������ͳ��" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>
<script src="/online_back.php"></script>			  
			  </TD></TR>
				</TBODY></TABLE></TD></TR></TBODY></TABLE>
	</form></TD>

	<TD align="left">
	<!--
	<IFRAME align="right" marginWidth="0" marginHeight="0" src="/mwjx/include/ad/d_class_200_200.html" frameBorder="0" width="200" scrolling="no" height="200"></IFRAME>
	//-->
	</TD></TR>
	</TBODY>
	</TABLE>

</xsl:template>

	<xsl:template match="listview/item">
		<TR>
			<TD>
				<img src="/mwjx/images/unknown.gif" alt="[   ]"/>
			</TD>
			<TD>
				<xsl:element name="a">
					<xsl:attribute name="href"><xsl:value-of select="./url"/>&amp;r_cid=<xsl:value-of select="../info/cid"/></xsl:attribute>
					<xsl:value-of select="./title"/>
				</xsl:element>
			</TD>
			<TD>
			    <xsl:value-of select="./poster"/>

			</TD>
			<TD>
				<xsl:value-of select="./dte"/>  
			</TD>
		</TR>
	</xsl:template>
	<xsl:template match="listview/manager">
		<xsl:for-each select="item">
			<xsl:element name="a">
				<xsl:attribute name="href">#</xsl:attribute>
				<xsl:value-of select="./name"/>
			</xsl:element>;
		</xsl:for-each>
	</xsl:template>
	<xsl:template match="listview/info/f_class">
		<b>�ϼ���Ŀ</b>:<xsl:apply-templates select="item"/>
	</xsl:template>
	<xsl:template match="listview/info/son_class">
		<b>�¼���Ŀ</b>:<xsl:apply-templates select="item"/>
	</xsl:template>

	<xsl:template match="info/son_class/item | info/f_class/item">
		<img src="/mwjx/images/folder.gif" alt="[   ]"/>
		<xsl:element name="a">
			<xsl:attribute name="href">
			class_homepage.php?cid=<xsl:value-of select="./id"/>
			</xsl:attribute>
			<xsl:value-of select="./name"/>
		</xsl:element>
		  <span style="width:10px"></span>
	</xsl:template>	
	<xsl:template match="listview/reply_list">
	  <TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
      bgColor="#cccccc" border="0">
        <THEAD>
        <TR bgColor="#ffffff">
          <TD align="middle" width="16%"><STRONG><FONT 
            color="#546fa4">ʱ��</FONT></STRONG></TD>
		  <TD align="middle" width="16%"><STRONG><FONT 
            color="#546fa4">�û���</FONT></STRONG></TD>
          <TD align="middle" width="68%"><STRONG><FONT color="#546fa4">�� �� �� 
            ��</FONT></STRONG></TD>

		</TR></THEAD>
        
		<TBODY>
			<xsl:apply-templates select="item"/>        
		</TBODY>
</TABLE>
	</xsl:template>
	<xsl:template match="listview/reply_list/item">
		<TR bgColor="#ffffff">
          <TD valign="top" width="16%"><xsl:value-of select="./time"/></TD>
		 <TD valign="top" width="16%"><FONT 
            color="#546fa4"><xsl:value-of select="./name"/></FONT></TD>
          <TD valign="top" width="68%">
			<xsl:call-template name="br">
			<xsl:with-param name="string" select="./content"/>
			</xsl:call-template>		  
		  </TD>
		</TR>	
	</xsl:template>
	<xsl:template match="listview/article_new">
		<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
		bgColor="#cccccc" border="0">
		<THEAD>
		<TR bgColor="#ffffff">
		<TD align="middle" width="100%" colspan="3" class="bgr3"><STRONG>��������</STRONG></TD>
		</TR>
		<TR bgColor="#ffffff">
		<TD align="middle" width="16%"><STRONG><FONT 
		color="#546fa4">ʱ��</FONT></STRONG></TD>
		<TD align="middle" width="68%"><STRONG><FONT color="#546fa4">����</FONT></STRONG></TD>
		<TD align="middle" width="16%"><STRONG><FONT 
		color="#546fa4">������</FONT></STRONG></TD>
		</TR></THEAD>

		<TBODY>
		<xsl:apply-templates select="item"/>        
		</TBODY>
		<TFOOT>
		<TR bgColor="#ffffff">
		<TD colspan="3" align="right" width="100%">
		<xsl:element name="a">
			<xsl:attribute name="href">#</xsl:attribute>
			<xsl:attribute name="onclick">javascript:goto_url('dynamic','<xsl:value-of select="../info/cid"/>','1','20');</xsl:attribute>
			<STRONG><FONT 
		color="#546fa4">ȫ������...</FONT></STRONG>
		</xsl:element>		
		</TD>
		</TR>
		</TFOOT>
		</TABLE>
	</xsl:template>
	<xsl:template match="listview/article_new/item">
		<TR bgColor="#ffffff">
          <TD valign="top" width="16%"><xsl:value-of select="./dte"/></TD>
          <TD valign="top" width="68%">
				<xsl:element name="a">
					<xsl:attribute name="target">_blank</xsl:attribute>					
					<xsl:attribute name="href"><xsl:value-of select="./url"/>&amp;r_cid=<xsl:value-of select="../info/cid"/></xsl:attribute>
					<xsl:value-of select="./title"/>
				</xsl:element>		  
		  </TD>
		 <TD valign="top" width="16%"><FONT 
            color="#546fa4"><xsl:value-of select="./poster"/></FONT></TD>
		</TR>	
	</xsl:template>
	<xsl:template match="listview/info/fid">
		<b>
<img src="/mwjx/images/back.gif" alt="[DIR]"/>	
			<!--			
			<xsl:element name="a">
				<xsl:attribute name="href">#</xsl:attribute>
				<xsl:attribute name="onclick">javascript:goto_url('<xsl:value-of select="../state"/>','<xsl:value-of select="../fid"/>','1','<xsl:value-of select="../per"/>');</xsl:attribute>
				<xsl:value-of select="../fname"/>
			</xsl:element>
			//-->
			<xsl:element name="a">
				<xsl:attribute name="href">
				class_homepage.php?cid=<xsl:value-of select="../fid"/>
				</xsl:attribute>
				<xsl:value-of select="../fname"/>
			</xsl:element>
		</b> / 

	</xsl:template>
	<xsl:template match="listview/recommend">
		<div style="width:100%;line-height:18px;" class="BG3">
			<div class="bgr3" style="padding-left:8px;padding-top:5px;" align="center"><STRONG><xsl:value-of select="@name"/></STRONG></div>
			<div id="dre" class="pad10L" style="padding-top:4px;padding-bottom:5px;table-layout:fixed; word-break :break-all;">
			<xsl:apply-templates select="item"/>
			</div>
		</div>
	</xsl:template>
	<xsl:template match="recommend/item">
		<xsl:apply-templates select="./img_star"/>	
		
		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="./id"/>&amp;state=dynamic&amp;r_cid=<xsl:value-of select="./cid"/></xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<xsl:attribute name="title"><xsl:value-of select="./title_more"/></xsl:attribute>
			<xsl:value-of select="./title"/>
		</xsl:element><br/>
	</xsl:template>
	<xsl:template match="listview/img_star">
		<xsl:element name="img">
			<xsl:attribute name="src"><xsl:value-of select="../path_img"/></xsl:attribute>
		</xsl:element>
	</xsl:template>
	<xsl:template match="img_star">
		<xsl:element name="img">
			<xsl:attribute name="src"><xsl:value-of select="../../../path_img"/></xsl:attribute>
		</xsl:element>
	</xsl:template>
	<xsl:template match="listview/class_dir">
		<TABLE cellSpacing="0" cellPadding="5" width="100%" bgColor="#ffffff" border="0">
		<TBODY>
		<xsl:apply-templates select="dir"/>
		</TBODY></TABLE>
	</xsl:template>
	<xsl:template match="listview/class_dir/dir">
		<tr><td>
		<div style="width:100%;line-height:18px;" class="BG3">
			<div class="bgr3" style="padding-left:8px;padding-top:5px;" align="center"><STRONG><xsl:value-of select="@title"/></STRONG></div>
			<div id="dre" class="pad10L" style="padding-top:4px;padding-bottom:5px;table-layout:fixed; word-break :break-all;">
			<xsl:apply-templates select="item"/>
			</div>
		</div>		
		</td></tr>
	</xsl:template>
	<xsl:template match="listview/class_dir/dir/item">
		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="./id"/>&amp;state=dynamic&amp;r_cid=<xsl:value-of select="../../../info/cid"/></xsl:attribute>
			<xsl:attribute name="target">_self</xsl:attribute>
			<xsl:attribute name="title"><xsl:value-of select="./title"/></xsl:attribute>
			<xsl:value-of select="./title"/>
		</xsl:element>
		<span style="width:20px;"></span>
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
