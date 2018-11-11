<?xml version="1.0" encoding="GB2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
<xsl:template match="/">
<HTML>
<HEAD>
<TITLE><xsl:apply-templates select="article/title"/>|妙文精选|www.mwjx.com</TITLE>
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
var m_bln_enable = false;  //文章区域是否可选择复制

//is_loaded();
function goto_url(state,cid,page,per)
{
	//去一个索引页
	//输入:state:static/dynamic(静态页面/动态页面)
	//cid类目ID,page页数,per每页记录数
	//输出:无
	if("" == state){
		//当前url中的来路
		if(null != get_get_var("state"))
			state = get_get_var("state");
		//return;
	}
	if(null != get_get_var("r_cid"))
		cid = get_get_var("r_cid");
	var url = "";
	var tmp = String(Math.random()*1000000);
	if("static" == state){ //静态
		url = "/data/"+cid+"_"+per+"_"+page+".xml";
		//url += ("?tmp="+tmp);
	}
	else{ //动态
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
	//初始
	//输入:无
	//输出:无
	//f_start();
	
	//set_height();
	//request_re_list(); //显示跟贴
}
function reply()
{
	//回复
	//输入:无
	//输出:无
	var content = document.all["message"].value;
	if("" == content)
		return alert("留言内容不能为空");
	if(content.length > 1000)
		return alert("留言长度不能超过1000");
	//return alert(document.all["aid"].value);
	if("" == document.all["aid"].value)
		return alert("异常，文章ID为空");
	if("" == document.all["reply_type"].value)
		return alert("异常，跟贴类型为空");
	if("" == document.all["fun"].value)
		return alert("异常，调用接口为空");
	if(!check_confcode('conf_reply'))
		return;
	//if("" == document.all["conf_reply"].value)
	//	return alert("请填写验证码");
	//alert("回复功能未完成");	
	//alert("回复:"+content);
	//return;
	//return alert("aa="+document.all["r_cid"].value);
	//----------提交---------
	//alert(document.all["frmsubmit"]);
	//document.all["hd_clist"].value = list;
	document.all["frmsubmit"].action = '../cmd.php';
	//document.all["txt_title"].value = list;
	//alert(document.all["frmsubmit"].action);
	document.all["frmsubmit"].submit();

}
function check_confcode(str)
{
	//检查验证码是否填写
	//输入:str(string)验证码输入框名
	//输出:true已填,false未填写
	if("" == document.all[str].value){
		alert("请填写验证码");
		return false;
	}
	return true;
}
/*
function email_page()
{
	//邮寄页面
	//输入:无
	//输出:无
	var tmp = get_cookie("email_page");
	if(null == tmp)
		tmp = "";
	var name = window.prompt("请输入要发送到哪个邮箱",tmp);
	if("" == name)
		return alert("邮箱地址不能为空");
	if(!check_email(name))
		return alert("怀疑你输入的邮箱无效，请换个邮箱试试");
	document.all["hd_email"].value = name;
	SetCookie("email_page",name); //以备下次使用
	form_mailpage.submit();
}
function check_email(email)
{
	//mail地址有效性检测，有效返回true，无效返回false
	//输入:email邮箱字符串
	//输出:true,false
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
<!--<center>Copyright 2002-2006, 版权所有 MWJX.COM</center>//-->
</BODY>
</HTML>
	</xsl:template>
<xsl:template match="article">
	<TABLE cellSpacing="1" cellPadding="3" width="778" align="center" 
bgColor="#FFFFFF" border="0" ><thead>
	<tr><td width="100%">
	
(得票数:<b><xsl:value-of select="vote_num"/></b>)(阅读数:<b><xsl:value-of select="article_info/click"/></b>)
	
	</td></tr>
	<tr><td width="100%">
<IFRAME align="center" marginWidth="0" marginHeight="0" src="/data/last_728_90.xml" frameBorder="0" width="760" scrolling="no" height="90" topmargin="0" leftmargin="0"></IFRAME>	
	</td></tr>
	<tr><td width="100%">
	<H2>
	<xsl:if test="good='Y'">
	<font color="red">[精华]</font>
	</xsl:if>		
	<xsl:value-of select="title"/></H2> 
	</td></tr>
	<tr><td width="100%">
	<xsl:element name="a">
	<xsl:attribute name="href">/index.html</xsl:attribute>
	<xsl:attribute name="target">_blank</xsl:attribute>
	<b>网站首页</b>
	</xsl:element>
<span style="width:10px"></span>
<xsl:apply-templates select="article_info/my_class"/>
	</td></tr>

	</thead><TBODY>
	<TR><TD width="100%"><xsl:apply-templates select="txt"/>
	</TD></TR>
	<TR><TD width="100%"><!--为获得最佳浏览效果，请使用Internet Explorer(IE6)//-->
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
//来路
var fromr = top.document.referrer;
//var fromr = document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
//当前页
var c_page=location.href;
c_page = (c_page ==""? top.location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
if(agent_version()){ //ie才显示,firefox下会出错
	//alert(c_page);
	//alert("来路:"+fromr+"\n"+"当前页:"+c_page);
	document.write('<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="废墟流量统计" border="0"/></a>');	
}
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="废墟流量统计" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
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
		上一页
	</xsl:element>
	<span style="width:20px"></span>
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_article.php?id=<xsl:value-of select="../next_id"/>&amp;state=dynamic&amp;r_cid=12</xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<img src="/mwjx/images/icon_arrow_rb.gif" border="0"/>
		下一页
	</xsl:element>
	<span style="width:40px"></span>
	<b>所属类目</b>：<xsl:apply-templates select="../article_info/my_class/f_class"/>
</td></tr>
<!--
<tr><td>
<IFRAME align="left" marginWidth="0" marginHeight="0" src="/data/article_links.html" frameBorder="0" width="100%" scrolling="no" height="240"></IFRAME>
</td></tr>//-->		
            <tr bgColor="#ffffff"><td>			
			发表日期：<i><xsl:value-of select="../article_info/date"/></i>
			原作者：<i><xsl:value-of select="../article_info/author"/></i>      
			<br/>
			荐稿人：<i><xsl:value-of select="../poster_info/name"/></i>			
<span style="width:20px;"/>给 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=<xsl:value-of select="../poster_info/id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
		<xsl:value-of select="../poster_info/name"/>
	</xsl:element>
 发站内短信			
 <span style="width:20px;"/>去 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/myhome.php?id=<xsl:value-of select="../poster_info/id"/></xsl:attribute>
		<xsl:attribute name="target">_self</xsl:attribute>
		<img src="/mwjx/images/home.gif" border="0"/>
		<xsl:value-of select="../poster_info/name"/>		
	</xsl:element>
 的个人主页			
 <span style="width:20px;"/>如果有更新，订阅 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/mail_update.php#daily_mail</xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
		邮件		
	</xsl:element>
 更新通知			
			</td></tr>
<tr bgColor="#ffffff"><td>
		<TABLE align="left" width="100%" border="0">
		<TBODY>
			<tr><td><a href="#" onclick="javascript:tr_da_1.style.display='block';tr_da_2.style.display='block';return false;" title="点击显示">操作本文&gt;&gt;</a></td></tr>
			<tr id="tr_da_1" style="display:none;">
			<td>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/src_php/phpmailer/fish_mailer.php?id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<xsl:attribute name="name">form_mailpage</xsl:attribute>
		<a href="#" target="_self" onclick="javascript:email_page();return false;"><img src="/mwjx/images/icon_email.gif" border="0"/>邮寄本文给朋友</a>
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('可以将这篇文章发送给自己或朋友，以作保存分享');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>
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
		验证码:<img src="/mwjx/pic.php?t=vote" onclick="this.src='/mwjx/pic.php?t=vote'" alt="看不清楚，更换图片" style="cursor:hand;"/><input type="text" name="conf_vote" size="5" value=""/><br/>
		<a href="#" target="_self" onclick="if(check_confcode('conf_vote'))form_good.submit();return false;"><img src="/mwjx/images/goodbt_2.gif" border="0"/>写得好，投一票</a>

		<!--<button onclick="this.form.submit();">写得好，投一票</button>//-->
	</xsl:element>
	</td><td>
	<!--<a href="/data/14.html" target="_blank">作家类目</a>中作家其他作品//-->
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=collections&amp;type=A&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		<xsl:attribute name="name">form_collections</xsl:attribute>
	
		<a href="#" target="_self" onclick="form_collections.submit();return false;">不错，纳入我的个人图书馆！</a>

		<!--<button onclick="this.form.submit();">写得好，投一票</button>//-->
	</xsl:element>
	</td>
<td>
	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/data_all_class.php?type=post&amp;aid=<xsl:value-of select="../id"/></xsl:attribute>
		编辑本文
	</xsl:element>				
			</td>
			</tr><tr id="tr_da_2" style="display:none;">
	<td>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=recommend_article&amp;id=<xsl:value-of select="../id"/>&amp;cid=<xsl:value-of select="../forumid"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		验证码:<img src="/mwjx/pic.php?t=recommend" onclick="this.src='/mwjx/pic.php?t=recommend'" alt="看不清楚，更换图片" style="cursor:hand;"/><input type="text" name="conf_recommend" size="5" value=""/><br/>
		<button onclick="if(check_confcode('conf_recommend'))this.form.submit();">推荐到类目</button> 
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('推荐的文章会被显示在类目首页的最新推荐，让妙文得到更多人关注');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>
	</xsl:element>
	</td><td>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=rm_article&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		验证码:<img src="/mwjx/pic.php?t=delarticle" onclick="this.src='/mwjx/pic.php?t=delarticle'" alt="看不清楚，更换图片" style="cursor:hand;"/><input type="text" name="conf_delarticle" size="5" value=""/><br/>
		<button onclick="if(!check_confcode('conf_delarticle'))return false;if(confirm('删除文章是种很严重的行为，确定要删除吗？'))this.form.submit();">删除本文</button>
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('不适合出现在妙文精选的文章都可以删除，欢迎大家来清理妙文精选');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>	
	</xsl:element>
	</td><td>
	<xsl:if test="count(../article_info/img_star) > 0">
	本文星级:
	<xsl:apply-templates select="../article_info/img_star"/>
	</xsl:if>
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=set_star&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		验证码:<a title="点击更新验证码"><img src="/mwjx/pic.php?t=star" border="0" align="absmiddle" id="p_img_star" onclick="this.src='/mwjx/pic.php?t=star'" alt="看不清楚，更换图片" style="cursor:hand;"/></a><input type="text" name="conf_star" size="5" value=""/><br/>

		评级:
		<select id="slt_star" name="slt_star" >
		<option value="-1">取消星级</option>
		<option selected="selected" value="3">3星</option>
		<option value="4">4星</option>
		<option value="5">5星</option>
		</select>
		<button onclick="if(check_confcode('conf_star'))this.form.submit();">评级</button>
		<span style="width:5px;"></span><a href="#" onclick="javascript:alert('评级宗旨:\n既不能曲高和寡，也不能口水得毫无深度。最好的文章应该是有内容而且观赏性强。\n评级标准:\n值得收藏:1分\n思想性，有启发，引人思考:最多2分\n观赏性，通俗易懂，看完大呼过瘾:最多2分\n根据上面3个指标评分，合计3分为3星文章，4分为4星文章，5分为5星文章。最低3星，最高5星。\n');"><img src="/mwjx/images/whats_this.gif" border="0"/></a>
	</xsl:element>
	</td><td>
	<xsl:choose>
		<xsl:when test="../good='Y'">
			<xsl:element name="form">
				<xsl:attribute name="action">/mwjx/cmd.php?fun=good_article&amp;good=N&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
				<xsl:attribute name="method">POST</xsl:attribute>
				<xsl:attribute name="target">submitframe</xsl:attribute>
				验证码:<img src="/mwjx/pic.php?t=clgood" onclick="this.src='/mwjx/pic.php?t=clgood'" alt="看不清楚，更换图片" style="cursor:hand;"/><input type="text" name="conf_clgood" size="5" value=""/><br/>
				
				<button onclick="if(check_confcode('conf_clgood'))this.form.submit();">取消精华</button>
			</xsl:element>
		</xsl:when>
		<xsl:otherwise>
			<xsl:element name="form">
				<xsl:attribute name="action">/mwjx/cmd.php?fun=good_article&amp;good=Y&amp;id=<xsl:value-of select="../id"/></xsl:attribute>
				<xsl:attribute name="method">POST</xsl:attribute>
				<xsl:attribute name="target">submitframe</xsl:attribute>
				验证码:<img src="/mwjx/pic.php?t=good" onclick="this.src='/mwjx/pic.php?t=good'" alt="看不清楚，更换图片" style="cursor:hand;"/><input type="text" name="conf_good" size="5" value=""/><br/>
				<button onclick="if(check_confcode('conf_good'))this.form.submit();">设为精华</button>
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
			<b>相关链接：(同在阅读本文的网友喜欢看的其他文章)</b>
		</td></tr>
		<tr><td>
		<xsl:apply-templates select="../links/item"/>
		</td></tr>
<tr><td style="width:100%;word-break:break-all;">

<xsl:apply-templates select="../reply_list"/>	  

<table width="93%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td height="29" align="left" background="images/titbg01.jpg" class="newtext">　　　发表评论：</td>
  </tr>
<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">
<input type="hidden" name="hd_gid" value=""/>
  <tr>
	<td align="center">
	  <table width="92%" border="0" cellpadding="0" cellspacing="0">
		<!--<tr>
		  <td width="10%" height="32" align="right">标题：</td>
		  <td width="90%" align="left"><input type="text" name="txt_title" /></td>
		</tr>//-->
		<tr>
		  <td align="right">内容：</td>
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
		  <td height="28" align="right">验证码：</td>
		  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="9%"><input type="text" name="conf_reply" size="5" value=""/></td>
			  <td width="16%"><a title="点击更新验证数字" onclick="p_img_reply.src='/mwjx/pic.php?t=reply'"><img src="/mwjx/pic.php?t=reply" width="52" height="20" border="0" 
							align="absmiddle" 
							id="p_img_reply" /></a></td>
			  <td width="58%"><input type="button" name="Submit32" value="发表" onclick="javascript:reply();"/></td>
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
		更多网友评论...
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
