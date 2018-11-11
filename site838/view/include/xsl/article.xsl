<?xml version="1.0" encoding="GB2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
<xsl:template match="/">
<HTML>
<HEAD>
<TITLE><xsl:apply-templates select="article/title"/>|���ľ�ѡ|www.mwjx.com</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<LINK rev="stylesheet" media="screen" 
href="../css/reply.css" type="text/css" rel="stylesheet"/>

<style>
a:link,a:visited,a:hover,a:active{color:#0000ff;cursor:hand;}
body,table,ul,li{font-size:10px;margin:0px;padding:0px}
body{background-color:#ffffff;font-family:arial,sans-serif;height:100%}
DIV.last_article {
	left: 130px; 
	WIDTH: 215px; 
	POSITION: absolute; 
	TOP: 500px;
}
DIV.last_article H3 {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; FONT-SIZE: 14px; PADDING-BOTTOM: 5px; MARGIN: 0px 0px 15px; COLOR: #cc9900; PADDING-TOP: 0px; BORDER-BOTTOM: #e7dc87 1px solid
}
DIV.last_article P {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 5px 0px; PADDING-TOP: 0px
}

</style>
<SCRIPT src="../include/script/cookie.js" type="text/javascript"></SCRIPT>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript" src="../include/script/reply.js"></script>
<script type="text/javascript" src="../include/script/email_page.js"></script>
<SCRIPT LANGUAGE="javascript">
                    <xsl:comment><![CDATA[
var m_bln_enable = false;  //���������Ƿ��ѡ����

//is_loaded();
function goto_url(state,cid,page,per)
{
	//ȥһ������ҳ
	//����:state:static/dynamic(��̬ҳ��/��̬ҳ��)
	//cid��ĿID,pageҳ��,perÿҳ��¼��
	//���:��
	if("" == state){
		//��ǰurl�е���·
		if(null != get_get_var("state"))
			state = get_get_var("state");
		//return;
	}
	if(null != get_get_var("r_cid"))
		cid = get_get_var("r_cid");
	var url = "";
	var tmp = String(Math.random()*1000000);
	if("static" == state){ //��̬
		url = "/data/"+cid+"_"+per+"_"+page+".xml";
		//url += ("?tmp="+tmp);
	}
	else{ //��̬
		url = "/mwjx/src_php/data_class.php?cid="+cid+"&per="+per+"&page="+page;
		//url += ("&tmp="+tmp);
	}
	//alert(url);
	//top.roll.src= url;
	//window.location.replace(url);
	//alert(window.location.href);
	//window.open(url);
	//url = "http://localhost"+url;
	window.location.href= url;
	//alert(window.location.href);
}
function init()
{
	//��ʼ
	//����:��
	//���:��
	//f_start();
	
	//set_height();
	//request_re_list(); //��ʾ����
}
function reply()
{
	//�ظ�
	//����:��
	//���:��
	var content = document.all["message"].value;
	if("" == content)
		return alert("�������ݲ���Ϊ��");
	if(content.length > 1000)
		return alert("���Գ��Ȳ��ܳ���1000");
	//return alert(document.all["aid"].value);
	if("" == document.all["aid"].value)
		return alert("�쳣������IDΪ��");
	if("" == document.all["reply_type"].value)
		return alert("�쳣����������Ϊ��");
	if("" == document.all["fun"].value)
		return alert("�쳣�����ýӿ�Ϊ��");
	if(!check_confcode('conf_reply'))
		return;
	//if("" == document.all["conf_reply"].value)
	//	return alert("����д��֤��");
	//alert("�ظ�����δ���");	
	//alert("�ظ�:"+content);
	//return;
	//return alert("aa="+document.all["r_cid"].value);
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
/*
function email_page()
{
	//�ʼ�ҳ��
	//����:��
	//���:��
	var tmp = get_cookie("email_page");
	if(null == tmp)
		tmp = "";
	var name = window.prompt("������Ҫ���͵��ĸ�����",tmp);
	if("" == name)
		return alert("�����ַ����Ϊ��");
	if(!check_email(name))
		return alert("�����������������Ч���뻻����������");
	document.all["hd_email"].value = name;
	SetCookie("email_page",name); //�Ա��´�ʹ��
	form_mailpage.submit();
}
function check_email(email)
{
	//mail��ַ��Ч�Լ�⣬��Ч����true����Ч����false
	//����:email�����ַ���
	//���:true,false
	if("undefined" == typeof(email) || "" == email)
		return false;
	var re=/^[\w.-]+@([0-9a-z][\w-]+\.)+[a-z]{2,3}$/i;
	if(re.test(email))
		return true;
	return false;
}
*/
]]>//</xsl:comment>
                </SCRIPT>
<STYLE type="text/css">
<![CDATA[
]]>
</STYLE>
</HEAD>
<BODY leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" onload="javascript:init();">
<xsl:apply-templates select="article"/>
<!--
//-->

<iframe name="submitframe" width="0" height="0" src="/online_back.php"></iframe>
<!--<center>Copyright 2002-2006, ��Ȩ���� MWJX.COM</center>//-->
</BODY>
</HTML>
	</xsl:template>
<xsl:template match="article">
	<TABLE cellSpacing="1" cellPadding="3" width="778" align="center" 
bgColor="#FFFFFF" border="0" ><thead>
	<tr><td width="100%">
	
(��Ʊ��:<b><xsl:value-of select="vote_num"/></b>)(�Ķ���:<b><xsl:value-of select="article_info/click"/></b>)
	
	</td></tr>
	<tr><td width="100%">
<IFRAME align="center" marginWidth="0" marginHeight="0" src="/data/last_728_90.xml" frameBorder="0" width="760" scrolling="no" height="90" topmargin="0" leftmargin="0"></IFRAME>	
	</td></tr>
	<tr><td width="100%">
	<H2>
	<xsl:if test="good='Y'">
	<font color="red">[����]</font>
	</xsl:if>		
	<xsl:value-of select="title"/></H2> 
	</td></tr>
	<tr><td width="100%">
	<xsl:element name="a">
	<xsl:attribute name="href">/index.html</xsl:attribute>
	<xsl:attribute name="target">_blank</xsl:attribute>
	<b>��վ��ҳ</b>
	</xsl:element>
<span style="width:10px"></span>
<xsl:apply-templates select="article_info/my_class"/>
	</td></tr>

	</thead><TBODY>
	<TR><TD width="100%"><xsl:apply-templates select="txt"/>
	</TD></TR>
	<TR><TD width="100%"><!--Ϊ���������Ч������ʹ��Internet Explorer(IE6)//-->
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
//��·
var fromr = top.document.referrer;
//var fromr = document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
//��ǰҳ
var c_page=location.href;
c_page = (c_page ==""? top.location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
if(agent_version()){ //ie����ʾ,firefox�»����
	//alert(c_page);
	//alert("��·:"+fromr+"\n"+"��ǰҳ:"+c_page);
	document.write('<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="��������ͳ��" border="0"/></a>');	
}
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="��������ͳ��" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>

	</TD></TR>
	</TBODY></TABLE>

</xsl:template>
<xsl:template match="txt">

        <table style="TABLE-LAYOUT: fixed" width="100%" cellpadding="3" id="main_content">
			<tr>
			<td width="100%" >
			<table cellSpacing="1" cellPadding="1" width="100%" align="center" 
  bgColor="#cccccc" border="0">
  <tr align="left" bgColor="#ffffff">	  
	  <td valign="top"  style="word-break:break-all;word-wrap:break-word;width:760px;FONT-SIZE: 11pt;">
<IFRAME align="right" marginWidth="0" marginHeight="0" src="/mwjx/include/ads_google_336_280.html" frameBorder="0" scrolling="no" width="336" height="630"></IFRAME>
<!--<script language="javascript" src="/mwjx/include/new_article.php?id=1"></script>//-->
<!--<xsl:element name="script">
	<xsl:attribute name="language">javascript</xsl:attribute>
	<xsl:attribute name="src">/mwjx/include/new_article.php?id=<xsl:value-of select="../article_info/my_class/f_class/id"/></xsl:attribute>
</xsl:element>//-->
  <!--
<IFRAME align="right" marginWidth="0" marginHeight="0" src="/mwjx/include/sp_recommend.html" frameBorder="0" scrolling="no" width="345" height="850"></IFRAME>
  
 //-->
 <xsl:call-template name="br">
 <xsl:with-param name="string" select="."/>
 </xsl:call-template>
	  </td>
				</tr>
<tr bgColor="#ffffff"><td>
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="../pre_id"/>&amp;state=dynamic&amp;r_cid=12</xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<img src="/mwjx/images/icon_arrow_rb.gif" border="0"/>
		��һҳ
	</xsl:element>
	<span style="width:20px"></span>
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="../next_id"/>&amp;state=dynamic&amp;r_cid=12</xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<img src="/mwjx/images/icon_arrow_rb.gif" border="0"/>
		��һҳ
	</xsl:element>
	<span style="width:40px"></span>
	<b>������Ŀ</b>��<xsl:apply-templates select="../article_info/my_class/f_class"/>
</td></tr>
<!--
<tr><td>
<IFRAME align="left" marginWidth="0" marginHeight="0" src="/data/article_links.html" frameBorder="0" width="100%" scrolling="no" height="240"></IFRAME>
</td></tr>//-->		
            <tr bgColor="#ffffff"><td>			
			�������ڣ�<i><xsl:value-of select="../article_info/date"/></i>
			ԭ���ߣ�<i><xsl:value-of select="../article_info/author"/></i>      
			<br/>
			�����ˣ�<i><xsl:value-of select="../poster_info/name"/></i>			
<span style="width:20px;"/>�� 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=<xsl:value-of select="../poster_info/id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
		<xsl:value-of select="../poster_info/name"/>
	</xsl:element>
 ��վ�ڶ���			
 <span style="width:20px;"/>ȥ 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/myhome.php?id=<xsl:value-of select="../poster_info/id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<img src="/mwjx/images/home.gif" border="0"/>
		<xsl:value-of select="../poster_info/name"/>		
	</xsl:element>
 �ĸ�����ҳ			
 <span style="width:20px;"/>����и��£����� 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/mail_update.php#daily_mail</xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
		�ʼ�		
	</xsl:element>
 ����֪ͨ			
			</td></tr>
<tr bgColor="#ffffff"><td>
		<TABLE align="left" width="100%" border="0">
		<TBODY>
			<tr><td><a href="#" onclick="javascript:tr_da_1.style.display='block';tr_da_2.style.display='block';return false;" title="�����ʾ">��������&gt;&gt;</a></td></tr>
			<tr id="tr_da_1" style="display:none;">
			<td>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/src_php/phpmailer/fish_mailer.php?id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<xsl:attribute name="name">form_mailpage</xsl:attribute>
		<a href="#" target="_self" onclick="javascript:email_page();return false;"><img src="/mwjx/images/icon_email.gif" border="0"/>�ʼı��ĸ�����</a>
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('���Խ���ƪ���·��͸��Լ������ѣ������������');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>
		<xsl:element name="input">
			<xsl:attribute name="type">hidden</xsl:attribute>
			<xsl:attribute name="name">hd_email</xsl:attribute>
			<xsl:attribute name="value"></xsl:attribute>
		</xsl:element>
	</xsl:element>
	</td><td>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=vote_article&amp;type=good&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<xsl:attribute name="name">form_good</xsl:attribute>
		��֤��:<img src="/mwjx/pic.php?t=vote" onclick="this.src='/mwjx/pic.php?t=vote'" alt="�������������ͼƬ" style="cursor:hand;"/><input type="text" name="conf_vote" size="5" value=""/><br/>
		<a href="#" target="_self" onclick="if(check_confcode('conf_vote'))form_good.submit();return false;"><img src="/mwjx/images/goodbt_2.gif" border="0"/>д�úã�ͶһƱ</a>

		<!--<button onclick="this.form.submit();">д�úã�ͶһƱ</button>//-->
	</xsl:element>
	</td><td>
	<!--<a href="/data/14.html" target="_blank">������Ŀ</a>������������Ʒ//-->
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=collections&amp;type=A&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<xsl:attribute name="name">form_collections</xsl:attribute>
	
		<a href="#" target="_self" onclick="form_collections.submit();return false;">���������ҵĸ���ͼ��ݣ�</a>

		<!--<button onclick="this.form.submit();">д�úã�ͶһƱ</button>//-->
	</xsl:element>
	</td>
<td>
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_all_class.php?type=post&amp;aid=<xsl:value-of select="../id"/></xsl:attribute>
		�༭����
	</xsl:element>				
			</td>
			</tr><tr id="tr_da_2" style="display:none;">
	<td>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=recommend_article&amp;id=<xsl:value-of select="../id"/>&amp;cid=<xsl:value-of select="../forumid"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		��֤��:<img src="/mwjx/pic.php?t=recommend" onclick="this.src='/mwjx/pic.php?t=recommend'" alt="�������������ͼƬ" style="cursor:hand;"/><input type="text" name="conf_recommend" size="5" value=""/><br/>
		<button onclick="if(check_confcode('conf_recommend'))this.form.submit();">�Ƽ�����Ŀ</button> 
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('�Ƽ������»ᱻ��ʾ����Ŀ��ҳ�������Ƽ��������ĵõ������˹�ע');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>
	</xsl:element>
	</td><td>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=rm_article&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		��֤��:<img src="/mwjx/pic.php?t=delarticle" onclick="this.src='/mwjx/pic.php?t=delarticle'" alt="�������������ͼƬ" style="cursor:hand;"/><input type="text" name="conf_delarticle" size="5" value=""/><br/>
		<button onclick="if(!check_confcode('conf_delarticle'))return false;if(confirm('ɾ���������ֺ����ص���Ϊ��ȷ��Ҫɾ����'))this.form.submit();">ɾ������</button>
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('���ʺϳ��������ľ�ѡ�����¶�����ɾ������ӭ������������ľ�ѡ');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>	
	</xsl:element>
	</td><td>
	<xsl:if test="count(../article_info/img_star) > 0">
	�����Ǽ�:
	<xsl:apply-templates select="../article_info/img_star"/>
	</xsl:if>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=set_star&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		��֤��:<a title="���������֤��"><img src="/mwjx/pic.php?t=star" border="0" align="absmiddle" id="p_img_star" onclick="this.src='/mwjx/pic.php?t=star'" alt="�������������ͼƬ" style="cursor:hand;"/></a><input type="text" name="conf_star" size="5" value=""/><br/>

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
	</td><td>
	<xsl:choose>
		<xsl:when test="../good='Y'">
			<xsl:element name="form">
				<xsl:attribute name="action">/mwjx/cmd.php?fun=good_article&amp;good=N&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
				<xsl:attribute name="method">POST</xsl:attribute>
				<xsl:attribute name="target">submitframe</xsl:attribute>
				��֤��:<img src="/mwjx/pic.php?t=clgood" onclick="this.src='/mwjx/pic.php?t=clgood'" alt="�������������ͼƬ" style="cursor:hand;"/><input type="text" name="conf_clgood" size="5" value=""/><br/>
				
				<button onclick="if(check_confcode('conf_clgood'))this.form.submit();">ȡ������</button>
			</xsl:element>
		</xsl:when>
		<xsl:otherwise>
			<xsl:element name="form">
				<xsl:attribute name="action">/mwjx/cmd.php?fun=good_article&amp;good=Y&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
				<xsl:attribute name="method">POST</xsl:attribute>
				<xsl:attribute name="target">submitframe</xsl:attribute>
				��֤��:<img src="/mwjx/pic.php?t=good" onclick="this.src='/mwjx/pic.php?t=good'" alt="�������������ͼƬ" style="cursor:hand;"/><input type="text" name="conf_good" size="5" value=""/><br/>
				<button onclick="if(check_confcode('conf_good'))this.form.submit();">��Ϊ����</button>
			</xsl:element>
		</xsl:otherwise>
	</xsl:choose>	
	</td>
			</tr>

		</TBODY></TABLE>	
</td></tr>
</table>
			</td>
            </tr>
		<tr><td>
			<b>������ӣ�(ͬ���Ķ����ĵ�����ϲ��������������)</b>
		</td></tr>
		<tr><td>
		<xsl:apply-templates select="../links/item"/>
		</td></tr>
<tr><td style="width:100%;word-break:break-all;">

<xsl:apply-templates select="../reply_list"/>	  

<table width="93%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td height="29" align="left" background="images/titbg01.jpg" class="newtext">�������������ۣ�</td>
  </tr>
<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">
<input type="hidden" name="hd_gid" value=""/>
  <tr>
	<td align="center">
	  <table width="92%" border="0" cellpadding="0" cellspacing="0">
		<!--<tr>
		  <td width="10%" height="32" align="right">���⣺</td>
		  <td width="90%" align="left"><input type="text" name="txt_title" /></td>
		</tr>//-->
		<tr>
		  <td align="right">���ݣ�</td>
		  <td align="left"><textarea name="message" cols="60" rows="5"></textarea>
			<input name="fun" type="hidden" value="reply"/>
			<input name="reply_type" type="hidden" value="article"/>
			<xsl:element name="input">
				<xsl:attribute name="name">aid</xsl:attribute>
				<xsl:attribute name="type">hidden</xsl:attribute>
				<xsl:attribute name="value"><xsl:value-of select="../id"/></xsl:attribute>
			</xsl:element>
			<xsl:element name="input">
				<xsl:attribute name="name">r_cid</xsl:attribute>
				<xsl:attribute name="type">hidden</xsl:attribute>
				<xsl:attribute name="value"><xsl:value-of select="../forumid"/></xsl:attribute>
			</xsl:element>
		  
		  </td>
		</tr>
		<tr>
		  <td height="28" align="right">��֤�룺</td>
		  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="9%"><input type="text" name="conf_reply" size="5" value=""/></td>
			  <td width="16%"><a title="���������֤����" onclick="p_img_reply.src='/mwjx/pic.php?t=reply'"><img src="/mwjx/pic.php?t=reply" width="52" height="20" border="0" 
							align="absmiddle" 
							id="p_img_reply" /></a></td>
			  <td width="58%"><input type="button" name="Submit32" value="����" onclick="javascript:reply();"/></td>
			  <td width="17%"></td>
			</tr>
		  </table></td>
		</tr>
	  </table>
	  </td>      
  </tr>
	  </form>
</table>

</td></tr>
			<tr>
			<td align="right">
<!--<IFRAME marginWidth="0" marginHeight="0" src="/data/article_links.html" frameBorder="0" width="100%" height="250" scrolling="no" topmargin="0" leftmargin="0" valign="top"></IFRAME>//-->
			</td></tr>

		</table>
		
</xsl:template>
<xsl:template match="article/reply_list">
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FCD6EA">
	<TBODY>
		<xsl:apply-templates select="item"/>        
	</TBODY>
	</table>
<xsl:if test="count(child::*) > 0">
<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
bgColor="#cccccc" border="0">
	<TR bgColor="#ffffff">
	  <TD align="right" width="100%">
	<xsl:element name="a">
		<xsl:attribute name="target">_blank</xsl:attribute>
		<xsl:attribute name="color">#035c9e</xsl:attribute>
		<xsl:attribute name="href">/mwjx/src_php/reply.php?page=1&amp;per=10&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		������������...
	</xsl:element>		  
	  </TD>
	</TR>
	</TABLE>
</xsl:if>

</xsl:template>
<xsl:template match="article/reply_list/item">
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
	align="right"><span style="15px"></span><strong><xsl:value-of select="./name"/></strong><span style="5px;"></span>�����ڣ�<xsl:value-of select="./time"/></div></td>
	<td>		<xsl:element name="form">
			<xsl:attribute name="action">/mwjx/cmd.php?fun=rm_reply&amp;id=<xsl:value-of select="./id"/>&amp;type=<xsl:value-of select="./old_new"/></xsl:attribute>
			<xsl:attribute name="method">POST</xsl:attribute>
			<xsl:attribute name="target">submitframe</xsl:attribute>
			<button onclick="if(confirm('ɾ�����ֺ����ص���Ϊ��ȷ��Ҫɾ����'))this.form.submit();">ɾ</button>
			<span style="width:5px;"></span><a href="#" onclick="javascript:alert('���ʺϳ��������ľ�ѡ�����¶�����ɾ������ӭ������������ľ�ѡ');return false;"><img src="/mwjx/images/whats_this.gif" border="0"/></a>	
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
<xsl:template match="article/new/rc">
	<xsl:element name="tr">
		<xsl:attribute name="height">20</xsl:attribute>
		<xsl:attribute name="align">left</xsl:attribute>
		<xsl:choose>
		<xsl:when test="bg=1">
		<xsl:attribute name="class">bgcolor_tr_1</xsl:attribute>
		</xsl:when>
		<xsl:otherwise>
		<xsl:attribute name="class">bgcolor_tr_2</xsl:attribute>
		</xsl:otherwise>
		</xsl:choose>
		<xsl:apply-templates select="title"/>
	</xsl:element>
</xsl:template>
<xsl:template match="article/links/item">
		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="id"/>&amp;state=dynamic&amp;r_cid=12</xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<xsl:value-of select="title"/>
		</xsl:element>
		<span style="width:20px"></span>
</xsl:template>
<xsl:template match="article/new/rc/title">
	<TD align="left">
		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_article.php&amp;id=<xsl:value-of select="../id"/>&amp;state=dynamic&amp;r_cid=12</xsl:attribute>
			<xsl:attribute name="class">a1</xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<xsl:value-of select="."/>
		</xsl:element>
		---&gt;<xsl:value-of select="../voter"/>
	</TD>
</xsl:template>
<xsl:template match="img_star">
	<xsl:element name="img">
		<xsl:attribute name="src"><xsl:value-of select="../path_img"/></xsl:attribute>
	</xsl:element>
</xsl:template>
<xsl:template match="my_class">
	<xsl:apply-templates select="f_class"/>	
</xsl:template>
<xsl:template match="f_class">
	<img src="/mwjx/images/folder.gif" alt="[DIR]"/><xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/class_homepage.php?cid=<xsl:value-of select="./id"/></xsl:attribute>
		<xsl:value-of select="./title"/>
	</xsl:element>
	<span style="width:10px;"></span>
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
