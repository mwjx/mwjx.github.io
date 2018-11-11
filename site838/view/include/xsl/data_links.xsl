<?xml version="1.0" encoding="gb2312"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html>
		<head>
			<title>文章列表 - (妙文精选提供)</title>
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
			<link rel="stylesheet" href="../css/all.css" type="text/css"/>
			<script type="text/javascript">
<![CDATA[
function init()
{
	//初始函数
	//输入:无
	//输出:无
	return;
	//alert(window.location.href);
	//return;
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
	for(i = 0;i < arr.length; ++i){ //加入文章
		add(arr[i][0],arr[i][1]);
	}
	/*
	*/
	//alert("init");	
}
function up_rc_num()
{
	//更新当前记录数
	//输入:无
	//输出:无
	var obj = document.all["a_list"];
	document.all["spn_rc_num"].innerText = obj.length;
}
function get_flag()
{
	//当前页面是待选区还是选中区
	//输入:无
	//输出:整形0/1(待选区/选中区)
	if(-1 != window.location.href.indexOf("e=ed"))
		return 1; //选中区
	return 0;
}
function is_search()
{
	//是否一个搜索结果页
	//输入:无
	//输出:true是，false不是
	if(-1 != window.location.href.indexOf("type=search"))
		return true; //选中区
	return false;
}
function show_links(id)
{
	//显示一篇主题文章的相关链接
	//输入:id(string)文章ID
	//输出:无
	parent.show_links(id);
}
function mv2ed(id)
{
	//将文章从待选区移到选中区
	//输入:id(string)文章ID
	//输出:无
	if(1 == get_flag())
		return parent.unlink(id); // alert("删除选中区文章"); 
	parent.mv2ed(id);
}
function get_title(id)
{
	//取列表中文章标题 
	//输入:id(string)文章ID
	//输出:标题字符串，异常返回空字符串
	var obj = document.all["a_list"];
	var i;
	for(i=0;i<obj.length;++i){
		if(id != obj.options[i].value)
			continue;
		return obj.options[i].text;
	}
	return "";
}
function get_master_id()
{
	return document.all["hd_master_id"].value;
}
function all_id_list()
{
	//形成所有ID列表，去掉重复
	//输入:无
	//输出:ID列表字符串,逗号分隔,异常返回空字符串
	var obj = document.all["a_list"];
	var i,id = -1;
	var arr = Array();
	for(i=0;i<obj.length;++i){
		id = parseInt(obj.options[i].value,10);
		if(id < 1)
			continue;
		if(null == arr[id])
			arr[id] = true;
	}
	var index,str = "";
	for(index in arr){
		if("" != str)
			str += ",";
		str += String(index);
	}
	return str;
	//up_rc_num();
}
function un_link()
{
	//取消选中的链接
	//输入:无
	//输出:无
	var obj = document.all["a_list"];
	var i;
	for(i=0;i<obj.length;++i){
		if(!obj.options[i].selected)
			continue;
		obj.options[i] = null;
		return un_link();
	}
}
function del(id)
{
	//删除列表中一项记录
	//输入:id(string)文章ID
	//输出:无
	var obj = document.all["a_list"];
	var i;
	for(i=0;i<obj.length;++i){
		if(id != obj.options[i].value)
			continue;
		obj.options[i] = null;
		return;
	}
	//up_rc_num();
}
function add(id,title)
{
	//列表中添加一项记录
	//输入:id(string)文章ID,title(string)标题
	//输出:无
	//alert("add:"+id);
	var oOption = document.createElement("OPTION");
	oOption.text = title;
	oOption.value = id;
	oOption.style.color = "#A9A9A9";
	var obj = document.all["a_list"];
	obj.add(oOption,0);
	//up_rc_num();
	/*
	*/
}
function goto_url(state,cid,page,per)
{
	//去一个索引页
	//输入:state:static/dynamic(静态页面/动态页面)
	//cid类目ID,page页数,per每页记录数
	//输出:无
	var str = ((0 == get_flag())?"&e=un":"&e=ed");
	var url = "";
	if("static" == state){ //静态
		url = "/data/"+cid+"_"+per+"_"+page+".xml";
	}
	else{ //动态
		url = "/mwjx/src_php/data_class.php?";
		if(is_search()){
			url += "per="+per+"&page="+page;
			url += "&type=search&str="+parent.search_str()+str;
		}
		else{
			url += "cid="+cid+"&per="+per+"&page="+page;
			url += "&type=manager"+str;
		}
	}

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
当前文章:(<xsl:value-of select="listview/info/id"/>)<b>
<xsl:value-of select="listview/info/title"/>
</b>
<xsl:element name="input">
	<xsl:attribute name="type">hidden</xsl:attribute>
	<xsl:attribute name="id">hd_master_id</xsl:attribute>
	<xsl:attribute name="value"><xsl:value-of select="listview/info/id"/></xsl:attribute>
</xsl:element>
<br/>
相关链接:<br/>
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
			<select id="a_list" SIZE="12" style="width:300px" MULTIPLE="true" ondblclick="javascript:del(this[this.selectedIndex].value);">
			<xsl:apply-templates select="item"/>		
			</select>
			</TD>
		</TR>
		</TBODY>
		</TABLE>
		
	</xsl:template>

	<xsl:template match="listview/item">
		<xsl:element name="option">
			<xsl:attribute name="value"><xsl:value-of select="./id"/></xsl:attribute>			
			<xsl:value-of select="./title"/>
		</xsl:element>;
	</xsl:template>
</xsl:stylesheet>
