<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
		<head>
			<title>我的家 - (妙文精选提供)</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
			<link rel="stylesheet" href="../include/report.css" type="text/css"/>
			<script type="text/javascript">
			<![CDATA[

			]]>
			</script>
		</head>
		<xsl:element name="body">
			<xsl:attribute name="leftMargin">0</xsl:attribute>
			<xsl:attribute name="topMargin">0</xsl:attribute>
			<xsl:attribute name="marginheight">0</xsl:attribute>
			<xsl:attribute name="marginwidth">0</xsl:attribute>
			<xsl:apply-templates select="myhome"/>
			<iframe name="submitframe" width="0" height="0"></iframe>
		</xsl:element>
		</html>
	</xsl:template>
	<xsl:template match="i_ip">
		<xsl:element name="a">
			<xsl:attribute name="href">./data_history.php?ip=<xsl:value-of select="."/></xsl:attribute>
			<xsl:attribute name="target">_self</xsl:attribute>
			<xsl:value-of select="../name"/>最近阅读的文章
		</xsl:element>
		<br/>
	</xsl:template>
	<xsl:template match="msglist">
		<xsl:element name="a">
			<xsl:attribute name="href">./msglist.php</xsl:attribute>
			<xsl:attribute name="target">_self</xsl:attribute>
			消息列表
		</xsl:element>
		<br/>
	</xsl:template>
	<xsl:template match="myhome">
		用户名:<xsl:value-of select="name"/>
		<span style="width:20px;"/>给 
			<xsl:element name="a">
				<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=<xsl:value-of select="id"/></xsl:attribute>
				<xsl:attribute name="target">_self</xsl:attribute>
				<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
				<xsl:value-of select="name"/>
			</xsl:element>
		 发站内短信					
		<span style="width:20px;"/><xsl:value-of select="name"/>的
			<xsl:element name="a">
				<xsl:attribute name="href">/mwjx/src_php/my_power.php?id=<xsl:value-of select="id"/></xsl:attribute>
				<xsl:attribute name="target">_self</xsl:attribute>
				<!--<img src="/mwjx/images/ic_stfriend.gif" border="0"/>//-->
				权限
			</xsl:element>		
		<br/>
		注册日期:<xsl:value-of select="reg"/><span style="width:20px;"/>
		最近登录时间:<xsl:value-of select="entertime"/>
		<br/>
		登录次数:<xsl:value-of select="enternum"/><span style="width:20px;"/>
		妙文废墟币:@<xsl:value-of select="cash"/><br/>
		<br/>
		已结算人民币津贴:￥<xsl:value-of select="cny_settled"/><span style="width:20px;"/>
		未结算人民币本月预测津贴:￥<xsl:value-of select="cny_unsettled"/><span style="width:20px;"/>
		合计:￥<font color="red"><xsl:value-of select="cny"/></font><br/>
		<font color="red">
		已结算的人民币津贴超过100元可要求发放，请联系小鱼。</font>
		<span style="width:20px;"/>给 
			<xsl:element name="a">
				<xsl:attribute name="href">/mwjx/src_php/write_msg.php?receiver=200200067</xsl:attribute>
				<xsl:attribute name="target">_self</xsl:attribute>
				<img src="/mwjx/images/ic_stfriend.gif" border="0"/>
				小鱼
			</xsl:element>
		 发站内短信					
		<br/><br/>
		<xsl:apply-templates select="i_ip"/>
		发布文章数: <b>

		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_class.php&amp;type=user_article&amp;page=1&amp;per=10&amp;show_type=dynamic&amp;cid=0&amp;str=<xsl:value-of select="id"/></xsl:attribute>
			<xsl:attribute name="target">_top</xsl:attribute>
			<xsl:value-of select="article_num"/>			
		</xsl:element>
		</b>
		<span style="width:20px;"/><xsl:value-of select="name"/>的
		<b>
		<xsl:element name="a">
			<xsl:attribute name="href">/mwjx/home.php?main=./src_php/data_class.php&amp;type=user_article&amp;page=1&amp;per=10&amp;show_type=dynamic&amp;cid=0&amp;str=<xsl:value-of select="id"/></xsl:attribute>
			<xsl:attribute name="target">_top</xsl:attribute>
			所有文章			
		</xsl:element>		
		</b>
		<span style="width:20px;"/>
		文章页面总访问数:<xsl:value-of select="my_pv"/>
		<br/>
		<xsl:apply-templates select="msglist"/>

		<!--
		/mwjx/home.php?main=.%2Fsrc_php%2Fdata_class.php&type=search&page=1&per=10&show_type=dynamic&cid=0&str=aaa
		//-->
		<xsl:apply-templates select="article_new"/>
	</xsl:template>
	<xsl:template match="myhome/article_new">
		<TABLE cellSpacing="1" cellPadding="3" width="100%" align="center" 
		bgColor="#cccccc" border="0">
		<THEAD>
		<TR bgColor="#ffffff">
		<TD align="middle" width="100%" colspan="3" class="bgr3"><STRONG><xsl:value-of select="../name"/>最新发布文章</STRONG></TD>
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
		<!--
		<TFOOT>
		<TR bgColor="#ffffff">
		<TD colspan="3" align="right" width="100%">
		<xsl:element name="a">
			<xsl:attribute name="href">#</xsl:attribute>
			<xsl:attribute name="onclick">javascript:goto_url('dynamic','<xsl:value-of select="../info/cid"/>','1','20');</xsl:attribute>
			<STRONG><FONT 
		color="#546fa4">更多...</FONT></STRONG>
		</xsl:element>		
		</TD>
		</TR>
		</TFOOT>
		//-->
		</TABLE>
	</xsl:template>
	<xsl:template match="myhome/article_new/item">
		<TR bgColor="#ffffff">
          <TD valign="top" width="16%"><xsl:value-of select="./dte"/></TD>
          <TD valign="top" width="68%">
				<xsl:element name="a">
					<xsl:attribute name="href"><xsl:value-of select="./url"/></xsl:attribute>
					<xsl:value-of select="./title"/>
				</xsl:element>		  
		  </TD>
		 <TD valign="top" width="16%"><FONT 
            color="#546fa4"><xsl:value-of select="./poster"/></FONT></TD>
		</TR>	
	</xsl:template>

</xsl:stylesheet>
