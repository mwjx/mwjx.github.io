<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
		<head>
			<title>�����б� - (���ľ�ѡ�ṩ)</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
			<link rel="stylesheet" href="../css/all.css" type="text/css"/>
			<script type="text/javascript">
<![CDATA[
function init()
{
	//��ʼ����
	//����:��
	//���:��
	//alert(window.location.href);
	return;
	//return alert(get_flag());
	//alert(parent);
	//if("undefined" == (parent))
	//	return;
	up_rc_num();
	try{
		if(0 == get_flag())
			return;
		var cid = parent.classid_un_ed(get_flag());
	}	   
	catch(err){
		return;
	}
	if("" == cid)
		return;	
	var arr = parent.get_class_ed(cid);
	if(arr.length < 1)
		return;
	//alert("init:"+arr.length);
	var i;
	for(i = 0;i < arr.length; ++i){ //��������
		add(arr[i][0],arr[i][1]);
	}
	/*
	*/
	//alert("init");	
}
function up_rc_num()
{
	//���µ�ǰ��¼��
	//����:��
	//���:��
	var obj = document.all["a_list"];
	document.all["spn_rc_num"].innerText = obj.length;
}
function get_flag()
{
	//��ǰҳ���Ǵ�ѡ������ѡ����
	//����:��
	//���:����0/1(��ѡ��/ѡ����)
	if(-1 != window.location.href.indexOf("e=ed"))
		return 1; //ѡ����
	return 0;
}
function is_search()
{
	//�Ƿ�һ���������ҳ
	//����:��
	//���:true�ǣ�false����
	if(-1 != window.location.href.indexOf("type=search"))
		return true; //ѡ����
	return false;
}
function mv2ed(id)
{
	//����Ŀ�Ӵ�ѡ���Ƶ�ѡ������ȡ����Ŀ����
	//����:id(string)��ĿID
	//���:��
	if(1 == get_flag()){
		//return alert("�ݲ�֧��");
		return parent.unlink(id); // alert("ɾ��ѡ��������"); 
	}
	//alert(id);
	parent.mv2ed(id);
}
function get_idlist_selected()
{
	//���ص�ǰѡ�е�ID�б�
	//����:��
	//���:id�б��ַ��������ŷָ�,�쳣���ؿ��ַ���
	var obj = document.all["a_list"];
	var i;
	var str = "";
	for(i=0;i<obj.length;++i){
		if(!obj.options[i].selected)
			continue;
		if("" != str)
			str += ",";
		str += obj.options[i].value;
		//return parseInt(obj.options[i].value,10);
	}
	return str;
}
function get_id_selected()
{
	//���ص�ǰѡ�е�ID
	//����:��
	//���:id����,�쳣����-1
	var obj = document.all["a_list"];
	var i;
	for(i=0;i<obj.length;++i){
		if(!obj.options[i].selected)
			continue;
		return parseInt(obj.options[i].value,10);
	}
	return -1;
}
function get_title(id)
{
	//ȡ�б������±��� 
	//����:id(string)����ID
	//���:�����ַ������쳣���ؿ��ַ���
	var obj = document.all["a_list"];
	var i;
	for(i=0;i<obj.length;++i){
		if(id != obj.options[i].value)
			continue;
		return obj.options[i].text;
	}
	return "";
}
function del(id)
{
	//ɾ���б���һ���¼
	//����:id(string)����ID
	//���:��
	var obj = document.all["a_list"];
	var i;
	for(i=0;i<obj.length;++i){
		if(id != obj.options[i].value)
			continue;
		obj.options[i] = null;
		return;
	}
	up_rc_num();
}
function add(id,title)
{
	//�б������һ���¼
	//����:id(string)����ID,title(string)����
	//���:��
	//alert("add:"+id);
	var oOption = document.createElement("OPTION");
	oOption.text = title;
	oOption.value = id;
	oOption.style.color = "#A9A9A9";
	var obj = document.all["a_list"];
	obj.add(oOption,0);
	up_rc_num();
	/*
	*/
}
function goto_url(state,cid,page,per)
{
	//ȥһ������ҳ
	//����:state:static/dynamic(��̬ҳ��/��̬ҳ��)
	//cid��ĿID,pageҳ��,perÿҳ��¼��
	//���:��
	var str = ((0 == get_flag())?"&e=un":"&e=ed");
	var url = "";
	url = "/mwjx/src_php/son_class.php?";
	url += "cid="+cid+"&per="+per+"&page="+page;
	url += str;

	window.location.href=(url);
}
/*
*/
]]>
			</script>
		</head>
		<xsl:element name="body">
			<xsl:attribute name="leftMargin">0</xsl:attribute>
			<xsl:attribute name="topMargin">0</xsl:attribute>
			<xsl:attribute name="marginheight">0</xsl:attribute>
			<xsl:attribute name="marginwidth">0</xsl:attribute>
			<xsl:attribute name="onload">javascript:init();</xsl:attribute>
<hr/>
<b>
<xsl:value-of select="listview/info/name"/>
</b>		
<xsl:apply-templates select="listview/pagelist"/>
			<xsl:apply-templates select="listview"/>

			<iframe name="submitframe" width="0" height="0"></iframe>
		</xsl:element>
		</html>
	</xsl:template>
	<xsl:template match="listview">
		<TABLE align="left" width="100%">
		<TBODY>
		<TR>
			<TD>
			<select id="a_list" SIZE="12" style="width:300px" MULTIPLE="true" ondblclick="javascript:mv2ed(this[this.selectedIndex].value);">
			<xsl:apply-templates select="son_link/item"/>		
			</select>
			</TD>
		</TR>
		</TBODY>
		</TABLE>
		
	</xsl:template>

	<xsl:template match="listview/son_link/item">
		<xsl:element name="option">
			<xsl:attribute name="value"><xsl:value-of select="./id"/></xsl:attribute>			
			<xsl:value-of select="./title"/>
		</xsl:element>;
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
			<!--<xsl:element name="a">
				<xsl:attribute name="href">/data/<xsl:value-of select="./id"/>.xml</xsl:attribute>
				<xsl:value-of select="./name"/>
			</xsl:element>;
			//-->
			<TR>
				<TD>
					<img src="/mwjx/images/folder.gif" alt="[   ]"/>
				</TD>
				<TD>
					<xsl:element name="a">
						<xsl:attribute name="href">#</xsl:attribute>
						<xsl:attribute name="onclick">javascript:goto_url('<xsl:value-of select="../../info/state"/>','<xsl:value-of select="./id"/>','1','<xsl:value-of select="../../info/per"/>');</xsl:attribute>
						<xsl:value-of select="./name"/>

					</xsl:element>
				</TD>
				<TD>
				</TD>
				<TD>
				</TD>
			</TR>
		</xsl:for-each>
	</xsl:template>
	<xsl:template match="listview/info/fid">
		<b>
<img src="/mwjx/images/back.gif" alt="[DIR]"/>	
			<xsl:element name="a">
				<xsl:attribute name="href">#</xsl:attribute>
				<xsl:attribute name="onclick">javascript:goto_url('<xsl:value-of select="../state"/>','<xsl:value-of select="../fid"/>','1','<xsl:value-of select="../per"/>');</xsl:attribute>
				<xsl:value-of select="../fname"/>
			</xsl:element>
		</b> / 

	</xsl:template>


	<xsl:template match="listview/pagelist">
	<TABLE width="100%" border="1" cellspacing="0" cellpadding="0" >
	<TR>
		<TD width="50%" align="left">
		<xsl:apply-templates select="go_page_list/go_page"/></TD>
		<TD width="50%" align="left">
<xsl:apply-templates select="per_list"/> ��¼/ҳ
		</TD>
	</TR>
	<TR>
		<TD colspan="2">
			<table><tr>
				<TD width="30%" align="left">
				��ǰҳ:<xsl:value-of select="current"/>
				</TD>
				<TD width="30%" align="left">
				��ǰ��¼:<span id="spn_rc_num">0</span>
				</TD>
				<TD width="40%" align="right">
				��¼����:<xsl:value-of select="count"/></TD>	
			</tr>
			</table>
		</TD>
	</TR>
	</TABLE>
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
