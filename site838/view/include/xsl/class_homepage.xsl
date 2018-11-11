<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="gb2312"  version="4.0"/> 
	<xsl:template match="/">
		<html>
		<head>
			<title>文章列表 - (妙文精选提供)</title>
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
	<!--子类目//-->
	<TABLE align="center" width="100%">
	<TBODY>
	<TR><TD>
		<xsl:apply-templates select="info/f_class"/>
	</TD></TR>
	<TR><TD>
		<xsl:apply-templates select="info/son_class"/>
	</TD></TR>
	</TBODY></TABLE>

	<!--维护人列表，及搜索框//-->
	<TABLE align="center" width="100%" border="0">
	<TBODY>
	<TR>
		<TD colspan="4" align="left">
		创建人:
		<xsl:element name="a">
			<xsl:attribute name="href">#</xsl:attribute>
			<xsl:value-of select="info/creator_name"/>
		</xsl:element>	
		维护人:<xsl:apply-templates select="manager"/>
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
			<input style="BORDER-RIGHT: 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" type="submit" value=" 搜索 "/></form>			

		</TD>
		<TD colspan="1" align="right">					
		<xsl:element name="a">
			<xsl:attribute name="href">http://www.mwjx.com/mwjx/login.php</xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<img src="/mwjx/images/user_login.gif" border="0"/>
			登录
		</xsl:element>	
		<xsl:element name="a">
			<xsl:attribute name="href">http://www.mwjx.com/mwjx/reg.php</xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<img src="/mwjx/images/user_reg.gif" border="0"/>
			注册
		</xsl:element>	

		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/src_php/post_book.php?id=<xsl:value-of select="info/cid"/></xsl:attribute>
			<img src="/mwjx/images/post.gif" border="0"/>
			上传书籍
		</xsl:element>	
		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/src_php/data_all_class.php?type=post&amp;id=<xsl:value-of select="info/cid"/></xsl:attribute>
			<img src="/mwjx/images/post.gif" border="0"/>
			发布文章
		</xsl:element>	
		</TD>
	</TR>
	</TBODY>
	</TABLE>		
	<xsl:if test="class_dir">
	<xsl:apply-templates select="class_dir"/>
	</xsl:if>
	<!--最新文章及推荐//-->
	<TABLE cellSpacing="0" cellPadding="5" width="100%" bgColor="#ffffff" border="0">
	<TBODY>
	<TR>
	<TD vAlign="top" align="left" width="70%">
	<xsl:apply-templates select="article_new"/>
	</TD>	
	<TD vAlign="top" align="left" width="30%">
	<xsl:apply-templates select="recommend"/>
	<span style="width:20px;"/>如果有更新，发 
 	<xsl:element name="a">
		<xsl:attribute name="href">/mwjx/src_php/mail_update.php#daily_mail</xsl:attribute>
		<xsl:attribute name="target">_blank</xsl:attribute>
		<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
		邮件		
	</xsl:element>
 通知我			
 <br/>
	<!--
	<xsl:if test="count(../article_info/img_star) > 0">
	本文星级:
	<xsl:apply-templates select="../article_info/img_star"/>
	</xsl:if>
	//-->
	<xsl:if test="count(./img_star) > 0">
	本类目当前评级:<xsl:apply-templates select="./img_star"/>
	</xsl:if>	
	<xsl:element name="form">
		<xsl:attribute name="action">/mwjx/cmd.php?fun=set_star&amp;otype=class&amp;id=<xsl:value-of select="info/cid"/></xsl:attribute>
		<xsl:attribute name="method">POST</xsl:attribute>
		<xsl:attribute name="target">submitframe</xsl:attribute>
		验证码:<input type="text" name="conf_star" size="5" value=""/><img src="/mwjx/pic.php?t=star" id="p_img_star" onclick="p_img_star.src='/mwjx/pic.php?t=star'" alt="看不清楚，点击换图片验证码" style="cursor:hand;"/><br/>

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
	</TD>	

	</TR>
	<TR><TD colspan="2" align="right">
	</TD></TR>
	</TBODY></TABLE>

	<!--评论//-->
	<TABLE cellSpacing="0" cellPadding="5" width="100%" bgColor="#ffffff" border="0">
	<TBODY>
	<TR>
	<TD vAlign="top" align="middle" width="100%">
	<xsl:apply-templates select="reply_list"/>	  
	</TD></TR></TBODY></TABLE>

	<!--评论框//-->
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
			  <TD>（CTRL+回车 直接提交评论）如果您还不是妙文精选会员,<A 
				href="http://www.mwjx.com/mwjx/reg.php" target="_blank"><FONT 
				color="#035c9e">欢迎注册</FONT></A><span style="width:12px"></span><A 
				href="http://www.mwjx.com/mwjx/login.php" target="_blank"><FONT 
				color="#035c9e">登录</FONT></A>				
				</TD></TR>
			<TR>
			  <TD colspan="3">
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
<script type="text/javascript" src="http://fishcounter.3322.org/script/md5.js"></script>
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
//当前页
var c_page=location.href;
c_page = (c_page ==""? top.location.href : c_page);

var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
if(agent_version()){ //ie才显示,firefox下会出错
	document.write('<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="废墟流量统计" border="0"/></a>');	
}
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="废墟流量统计" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
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
		<b>上级类目</b>:<xsl:apply-templates select="item"/>
	</xsl:template>
	<xsl:template match="listview/info/son_class">
		<b>下级类目</b>:<xsl:apply-templates select="item"/>
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
            color="#546fa4">时间</FONT></STRONG></TD>
		  <TD align="middle" width="16%"><STRONG><FONT 
            color="#546fa4">用户名</FONT></STRONG></TD>
          <TD align="middle" width="68%"><STRONG><FONT color="#546fa4">评 论 内 
            容</FONT></STRONG></TD>

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
		<TD align="middle" width="100%" colspan="3" class="bgr3"><STRONG>最新文章</STRONG></TD>
		</TR>
		<TR bgColor="#ffffff">
		<TD align="middle" width="16%"><STRONG><FONT 
		color="#546fa4">时间</FONT></STRONG></TD>
		<TD align="middle" width="68%"><STRONG><FONT color="#546fa4">标题</FONT></STRONG></TD>
		<TD align="middle" width="16%"><STRONG><FONT 
		color="#546fa4">发布者</FONT></STRONG></TD>
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
		color="#546fa4">全部更多...</FONT></STRONG>
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
