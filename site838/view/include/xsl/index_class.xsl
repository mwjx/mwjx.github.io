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
		url = "/site838/view/src_php/data_class.php?cid="+cid+"&per="+per+"&page="+page;
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
	window.location.href=(url);
}
function init()
{
	//alert("aaa");
	try{
		f_start();
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
function select_all()
{
	//选择或取消所有checkbox
	//输入:无
	//输出:无
	var bln_checked = null;  //选中
	//遍历所有checkbox
	for(index in document.all){
		if("undefined" == typeof(document.all[index]))
			continue;
		if("INPUT" != document.all[index].tagName)
			continue;
		if("checkbox" != document.all[index].type)
			continue;
		if(null == bln_checked){  //以第一个判断是全选还是全否
			if(document.all[index].checked)
				bln_checked = false;
			else
				bln_checked = true;
		}
		if(bln_checked){
			document.all[index].checked = true;
			//var obj_tr = document.all[index].parentNode.parentNode;			
			//obj_tr.className = "listTr_live_selected";									
		}
		else{
			document.all[index].checked = false;
			//var obj_tr = document.all[index].parentNode.parentNode;
			//obj_tr.className = "listTr_live_normal";						
		}
	}
}
function commit_good()
{
	//提交精华设置
	//输入:无
	//输出:无
	//alert("提交精华设置:"+get_list_id_checked());
	//提交
	document.all["slist"].value = get_list_id_checked(1);
	document.all["frm_batchgood"].all["fun"].value = "batch_good";
	//document.all["frm_batchgood"].action='../class/cmd.php';
	document.all["frm_batchgood"].submit();
}
function commit_del()
{
	//提交删除列表,批量删除
	//输入:无
	//输出:无
	//return alert("批量删除:"+get_list_id_checked(2));
	//提交
	//return alert(document.all["frm_batchgood"].all.length);
	document.all["slist"].value = get_list_id_checked(2);
	document.all["frm_batchgood"].all["fun"].value = "batch_del";
	//document.all["frm_batchgood"].action='../class/cmd.php';
	document.all["frm_batchgood"].submit();
}

function get_list_id_checked(flag)
{
	//返回被精华设置状态
	//输入:flag(int)标志1/2(批量精华/批量删除)
	//输出:批量精华:字符串"Y_id,id...;N_id,id..."(Y精华,N非精华)
	//批量删除:字符串,"id,id,..."被选中的ID列表
	var index,id="",str="",name="";
	//var slist = "";
	var str_y = "",str_n = "";
	for(index in document.all){
		if("undefined" == typeof(document.all[index].value))
			continue;
		name = document.all[index].value;
		if(name.length < 5)
			continue;
		str = name.substr(0,3);
		if("box" != str)
			continue;
		id = parseInt(name.substr(4),10);
		//if("" != slist)
		//	slist += ",";
		//slist += (id+"_");
		if(true == document.all[index].checked) //选中
			str_y += ((""==str_y)?id:(","+id));
		else //未选中
			str_n += ((""==str_n)?id:(","+id));
		//result[result.length] = id;
		//alert(id);						
	}
	if(2 == flag)
		return str_y;
	return ("Y_"+str_y+";N_"+str_n);
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
	<xsl:attribute name="onload">javascript:init();</xsl:attribute>
<xsl:apply-templates select="listview/pagelist"/>
<h2>
<xsl:apply-templates select="listview/info/fid"/>
<xsl:value-of select="listview/info/name"/>
</h2>
<xsl:apply-templates select="listview"/>
<iframe name="submitframe" width="0" height="0"></iframe>
</xsl:element>

</html>
	</xsl:template>
	<xsl:template match="listview">
		<TABLE align="center" width="100%">
		<TBODY><TR><TD>
			<xsl:apply-templates select="son_class"/>
		</TD></TR>
		<xsl:apply-templates select="ls_class"/>
		</TBODY>
		</TABLE>

		<TABLE align="center" width="100%" border="0">
		<thead>
		<xsl:apply-templates select="info"/>
		<TR>
			<TD colspan="3" align="right">					
				<form name="query" action="/site838/view/home.php" method="get" visable="false" target="_blank"><img src="/site838/view/images/searchsite.gif" width="78" height="18"/>
				<input type="hidden" name="main" value="./src_php/data_class.php"/>
				<input type="hidden" name="type" value="search"/>
				<input type="hidden" name="page" value="1"/>
				<input type="hidden" name="per" value="10"/>
				<input type="hidden" name="show_type" value="dynamic"/>
				<input type="hidden" name="cid" value="0"/>
				<input style="BORDER-RIGHT: 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" maxlength="12" size="26" name="str"/>

				<input style="BORDER-RIGHT: 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" type="submit" value=" 提交 "/></form>			

			</TD>
			<TD colspan="1" align="right">					
			<xsl:element name="a">
				<xsl:attribute name="href">http://www.fish838.com/site838/view/login.php</xsl:attribute>
				<xsl:attribute name="target">_blank</xsl:attribute>
				<img src="/site838/view/images/user_login.gif" border="0"/>
				登录
			</xsl:element>	
			<xsl:element name="a">
				<xsl:attribute name="href">http://www.fish.com/site838/view/reg.php</xsl:attribute>
				<xsl:attribute name="target">_blank</xsl:attribute>
				<img src="/site838/view/images/user_reg.gif" border="0"/>
				注册
			</xsl:element>	

			<xsl:element name="a">
				<xsl:attribute name="href">/site838/view/src_php/data_all_class.php?type=post&amp;id=<xsl:value-of select="info/cid"/></xsl:attribute>
				<img src="/site838/view/images/post.gif" border="0"/>
				发布文章
			</xsl:element>	

		
			</TD>
		</TR>
		<TR>
			<TD width="5%">
				<img src="/site838/view/images/bsall3.gif" alt="是否精华/全选/全否" onclick="javascript:select_all();"/>
			</TD>
			<TD width="50%">
			Title
			</TD>
			<TD width="25%">
			Poster
			</TD>
			<TD width="20%">
			Last modified
			</TD>
		</TR>
		</thead>
		<TBODY>
			<xsl:apply-templates select="item"/>		
		</TBODY>
		<tfoot>
		<TR>
			<TD colspan="4" align="right">
	<form id="frm_batchgood" name="frm_batchgood" action="../cmd.php" method="POST" target="submitframe">
		<input name="fun" type="hidden" value="batch_good"/>
		<input name="slist" type="hidden" value=""/>
	</form>
	<button onclick="javascript:commit_del();">批量逻辑删除</button>
	<span style="width:100px;"></span>
	<button onclick="javascript:commit_good();">批量设置精华</button>
</TD>
		</TR>
		</tfoot>
		</TABLE>		

<TABLE align="center" width="100%" border="0">
<TBODY><TR><TD>

<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">

<TABLE cellSpacing="0" cellPadding="5" width="575" bgColor="#ffffff" border="0">
  <TBODY>
  <TR>
    <TD vAlign="top" align="middle" width="100%">

<xsl:apply-templates select="reply_list"/>	  

  </TD></TR></TBODY></TABLE>
<TABLE cellSpacing="0" cellPadding="5" width="575" bgColor="#ffffff" border="0">
  <TBODY>
  <TR>
    <TD style="TEXT-ALIGN: left" height="30">
      <TABLE id="tbl_login_input" cellSpacing="0" cellPadding="3" border="0" style="display:none">
        <TBODY>
        <TR>
		  <TD>登陆名:</TD>
          <TD><INPUT 
            style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 90px; BORDER-BOTTOM: 1px solid; HEIGHT: 22px" 
            name="username"/></TD>
          <TD>密码:</TD>
          <TD><INPUT 
            style="BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid; BORDER-LEFT: 1px solid; WIDTH: 90px; BORDER-BOTTOM: 1px solid; HEIGHT: 22px" 
            type="password" name="password"/></TD>
          <TD class="comment-btn1"><INPUT onclick="javascript:login();" type="button" value="" name="Submit2222"/></TD></TR></TBODY></TABLE></TD></TR>
  <TR>
    <TD style="TEXT-ALIGN: center">
	<TEXTAREA style="WIDTH: 545px; HEIGHT: 115px" name="message">不要尝试留言,留言功能未完成</TEXTAREA>
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
          <TD class="comment-btn2" align="middle"><INPUT onclick="javascript:reply();" id="bt_commit" style="display:none" type="button" value="" name="Submit32"/> 
          </TD>
          <TD class="comment-btn3"> 
          </TD>
          <TD>（CTRL+回车 直接提交评论）如果您还不是妙文精选会员,<A 
            href="/index.html" target="_blank"><FONT 
            color="#035c9e">欢迎注册</FONT></A><span style="width:12px"></span><A 
            href="/index.html" target="_blank"><FONT 
            color="#035c9e">登录</FONT></A></TD></TR></TBODY>
			</TABLE></TD></TR></TBODY></TABLE>
</form>			
</TD>
<TD align="left">
</TD></TR>
</TBODY>
</TABLE>

	</xsl:template>

	<xsl:template match="listview/item">
		<TR>
			<TD>
	<xsl:element name="input">
		<xsl:attribute name="type">checkbox</xsl:attribute>
		<xsl:if test="good='Y'">
			<xsl:attribute name="checked">true</xsl:attribute>
		</xsl:if>
		<xsl:attribute name="value">box_<xsl:value-of select="./id"/></xsl:attribute>

		<!--
		<xsl:choose>
			<xsl:when test="good='Y'">
				<xsl:attribute name="checked">true</xsl:attribute>
			</xsl:when>
			<xsl:otherwise>
				<xsl:attribute name="checked">false</xsl:attribute>
			</xsl:otherwise>
		</xsl:choose>
		//-->
	</xsl:element>
			</TD>
			<TD>
				<xsl:element name="a">
					<xsl:attribute name="href">/bbs/html/<xsl:value-of select="./url"/></xsl:attribute>
					<xsl:attribute name="target">_blank</xsl:attribute>
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
	<xsl:template match="listview/son_class">
		<xsl:for-each select="item">
					<img src="/site838/view/images/folder.gif" alt="[   ]"/>
					<xsl:element name="a">
						<xsl:attribute name="href">#</xsl:attribute>
						<xsl:attribute name="onclick">javascript:goto_url('<xsl:value-of select="../../info/state"/>','<xsl:value-of select="./id"/>','1','<xsl:value-of select="../../info/per"/>');</xsl:attribute>
						<xsl:value-of select="./name"/>
					</xsl:element>
					  <span style="width:10px"></span>
		</xsl:for-each>
	</xsl:template>
	<xsl:template match="listview/ls_class">
		<TR><TD>搜索到的类目:
		<xsl:for-each select="item">
					<img src="/site838/view/images/folder.gif" alt="[   ]"/>
					<xsl:element name="a">
						<!--<xsl:attribute name="href">/mwjx/src_php/class_homepage.php?cid=<xsl:value-of select="./id"/></xsl:attribute>//-->
						<xsl:attribute name="target">_blank</xsl:attribute>
						<xsl:attribute name="href">/data/<xsl:value-of select="./id"/>.html</xsl:attribute>
						<xsl:value-of select="./name"/>
					</xsl:element>
					  <span style="width:10px"></span>
		</xsl:for-each>
		</TD></TR>
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
          <TD valign="top" width="68%"><xsl:value-of select="./content"/></TD>

		</TR>	
	</xsl:template>
	<xsl:template match="listview/info">
		<TR>
			<TD colspan="4" align="left">
			创建人:
			<xsl:element name="a">
				<xsl:attribute name="href">#</xsl:attribute>
				<xsl:value-of select="creator_name"/>
			</xsl:element>	
			维护人:<xsl:apply-templates select="manager"/>
			</TD>
		</TR>
	</xsl:template>
	<xsl:template match="listview/info/fid">
		<b>
<img src="/site838/view/images/back.gif" alt="[DIR]"/>	
			<xsl:element name="a">
				<xsl:attribute name="href">#</xsl:attribute>
				<xsl:attribute name="onclick">javascript:goto_url('<xsl:value-of select="../state"/>','<xsl:value-of select="../fid"/>','1','<xsl:value-of select="../per"/>');</xsl:attribute>
				<xsl:value-of select="../fname"/>
			</xsl:element>
		</b> / 

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
					<xsl:attribute name="onclick">javascript:goto_url('<xsl:value-of select="../../../info/state"/>','<xsl:value-of select="../../../info/cid"/>','<xsl:value-of select="page"/>','<xsl:value-of select="../../num_per_page"/>');</xsl:attribute>
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
		<xsl:attribute name="onchange">javascript:goto_url('<xsl:value-of select="../../info/state"/>','<xsl:value-of select="../../info/cid"/>','1',select_per_page[select_per_page.selectedIndex].value);</xsl:attribute>
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
</xsl:stylesheet>
