<?php
//------------------------------
//create time:2007-1-4
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:文章管理
//------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 文章管理 </TITLE>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312"/>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<script type="text/javascript" src="../include/script/url.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
//被选中文章
//选中类目ID(str)=>array({文章ID(str),标题(str),来源类目ID(str)})
var m_arr_ed = Array(); 
var m_str_search = ""; //当前查询内容
//window.onload = "init()";
function init_toolbar()
{
	//初始化工具区
	//输入:无
	//输出:无

}
function unlink(id)
{
	//取消选中区文章在类目的链接
	//输入:id(string)文章ID
	//输出:无
	var edid = classid_un_ed(1);
	if("" == edid)
		return alert("取消链接失败，选中区类目无效");
	//alert(edid+":"+id);
	//----------提交---------
	str = ("fun=unlink_article&cid="+edid+"&id="+id);
	var o_http = submit_str(str);
	if(false === o_http)
		return alert("提交失败");
	//回复
	if(4 != o_http.readyState)
		return alert("提交没有收到回复");
	if(o_http.status != 200)
		return alert("回复状态异常");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("回复为空");
	
	if("OK" == o_http.responseText){
		article_list_ed.del(id);		
		alert("取消链接成功");
	}
	else{
		var msg = o_http.responseText;
		alert(msg);
	}	
}
function search_str()
{
	//当前搜索字符串
	//输入:无
	//输出:字符串
	return m_str_search;
}
function search(str)
{
	//提交查询
	//输入:str(string)查询条件
	//输出:无
	m_str_search = str;
	var o = frame_toolbar;
	var area = o.search_area();
	var url = "./data_class.php?page=1&per=10&type=search&e="+area+"&str=";
	url += (m_str_search); 
	if("un" == area)
		document.all["article_list_un"].src = url;
	else
		document.all["article_list_ed"].src = url;
}
function submit_str(str)
{
	//向服务器提交查询,同步，post方式
	//输入:str变量字符串，格式:submit1=Submit&text1=scsdfsd
	//输出:http对象,异常返回false
	var o_http = new_xmlhttp();
	if(false === o_http)
		return false;
	//str = ("fun=set_article&info="+str);
	o_http.Open("POST","../cmd.php",false); //同步提交
	o_http.setRequestHeader("Content-Length",str.length);  
	o_http.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");	
	o_http.Send(str);
	return o_http;
}
function commit()
{
	//提交修改
	//输入:无
	//输出:无
	if(count(m_arr_ed) < 1)
		return alert("没有改动，不用提交");
	var str = "",tmp = "";
	var i;
	for(key in m_arr_ed){
		tmp = "";
		for(i = 0;i < m_arr_ed[key].length; ++i){
			if("" == tmp)
				tmp += (key);
			tmp += ("_"+m_arr_ed[key][i][0]);
		}
		if("" != tmp){
			if("" != str)
				str += ",";
			str += tmp;
		}
	}
	//----------提交---------
	str = ("fun=set_article&info="+str);
	var o_http = submit_str(str);
	if(false === o_http)
		return alert("提交失败");
	//回复
	if(4 != o_http.readyState)
		return alert("提交没有收到回复");
	if(o_http.status != 200)
		return alert("回复状态异常");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("回复为空");
	
	if("OK" == o_http.responseText){
		alert("提交成功");
	}
	else if("FAIL" == o_http.responseText){
		alert("提交失败，无权限");
	}
	else{
		var arr = o_http.responseText.split(",");
		var msg = "";
		for(var i = 0;i < arr.length; ++i){
			var row = arr[i].split("_");
			if(row.length < 2)
				continue;
			var cid = row[0];
			if(null == m_arr_ed[cid])
				continue;
			for(var j = 1;j < row.length; ++j){
				var title = get_title(cid,row[j]);
				if("" == title)
					continue;
				//if(m_arr_ed[cid][row[j]])
				msg += (title+"\n");								
			}
		}
		if("" != msg){
			msg = ("以下文章提交失败，可能文章无效或已经在类目中:\n"+msg);
		}
		alert(msg);
	}
	m_arr_ed = Array(); //清空提交集合		
	//alert(str);
	/*
strA = "submit1=Submit&text1=scsdfsd";
var oReq = new ActiveXObject("MSXML2.XMLHTTP");
oReq.open("POST","http://ServerName/VDir/TstResult.asp",false);
oReq.setRequestHeader("Content-Length",strA.length);  
oReq.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");
oReq.send(strA);
	*/
}
function get_title(cid,aid)
{
	//文章标题 
	//输入:cid(string)类目ID,aid(string)文章ID
	//输出:文章标题,异常返回空字符串
	if(null == m_arr_ed[cid])
		return "";
	for(var i = 0;i < m_arr_ed[cid].length; ++i){
		if(aid == m_arr_ed[cid][i][0])
			return m_arr_ed[cid][i][1];
	}
	return "";
}
function mv2ed(id)
{
	//将文章从待选区移到选中区
	//输入:id(string)文章ID
	//输出:无
	var unid = classid_un_ed(0);
	var edid = classid_un_ed(1);
	//"" == unid || 
	if("" == edid)
		return alert("类目ID无效,请选择一个选中区类目"); //类目ID无效
	if(ed_had(edid,id))	
		return alert("不要重复将同一篇文章归入同一个类目");
	var o = article_list_un;
	var title = o.get_title(id);
	if("" == title)
		return alert("文章标题无效");
	if(null == m_arr_ed[edid])
		m_arr_ed[edid] = Array();
	m_arr_ed[edid][m_arr_ed[edid].length] = Array(id,title,unid);	
	//o.del(id);
	o = article_list_ed;
	o.add(id,title);
	
	//alert(id+":from "+unid+" to "+ edid+" title="+title);
}
function add_link()
{
	//批量加入文章
	//输入:无
	//输出:无
	//return alert("aaa");
	//var id = 2;
	var unid = classid_un_ed(0);
	var edid = classid_un_ed(1);
	if("" == edid)
		return alert("类目ID无效,请选择一个选中区类目"); //类目ID无效
	var o = document.all["article_list_un"];
	if("" == o.src)
		return alert("加入链接失败，没有选中文章");
	var o2 = document.all["article_list_ed"];
	if("" == o2.src)
		return alert("加入链接失败，没有选中文章");
	//----------
	var str_list = article_list_un.get_idlist_selected();
	if("" == str_list)
		return alert("加入链接失败，请选择文章");
	var arr = str_list.split(",");
	var i,id = "",title = "";
	if(null == m_arr_ed[edid])
		m_arr_ed[edid] = Array();
	for(i = 0;i < arr.length; ++i){
		id = arr[i];
		title = article_list_un.get_title(id);
		//alert(id+":"+title);
		if("" == title)
			continue;
		if(ed_had(edid,id))	
			continue;		
		//article_links.add(id,title);		
		m_arr_ed[edid][m_arr_ed[edid].length] = Array(id,title,unid);	
		//o.del(id);
		//o = article_list_ed;
		article_list_ed.add(id,title);	
	}
	//alert(str_list);
}
function classid_un_ed(flag)
{
	//待选区或选中区类目ID
	//输入:flag(int)(0/1)(待选区/选中区)
	//输出:类目ID字符串，异常返回空字符串
	var o = null;
	if(0 == flag)
		o = document.all["article_list_un"];
	else
		o = document.all["article_list_ed"];
	var val = (get_get_var2("cid",o.src));
	if(false === val)
		return "";
	return val;
}
function get_class_ed(id)
{
	//返回一个类目被加入的文章列表
	//输入:id(string)类目ID
	//输出:文章数组,array({id(str),title(str),fromcid(str)})
	//异常返回空数组
	if(null == m_arr_ed[id])
		return Array();
	return m_arr_ed[id]
}
function ed_had(cid,id)
{
	//选中列表当前类目已经有该文章
	//输入:cid(string)选中类目ID,id(string)文章ID
	//输出:true已经存在,false不存在
	if(null == m_arr_ed[cid])
		return false;
	var i;
	for(i = 0;i < m_arr_ed[cid].length; ++i){
		if(id == m_arr_ed[cid][i][0])
			return true;
	}
	return false;
}
</script>
</HEAD>
<FRAMESET frameBorder="1" frameSpacing="0" rows="85%,15%">
	<FRAMESET frameBorder="1" frameSpacing="0" cols="50%,50%">
		<FRAMESET frameBorder="1" frameSpacing="0" rows="40%,60%">
			<FRAME frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src="./data_all_class.php?type=article"></FRAME>
			<FRAME id="article_list_un" frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src=""></FRAME>
		</FRAMESET>
		<FRAMESET frameBorder="1" frameSpacing="0" rows="40%,60%">
			<FRAME frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src="./data_all_class.php?type=article_ed"></FRAME>
			<FRAME id="article_list_ed" frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src=""></FRAME>
		</FRAMESET>
	</FRAMESET>
	<FRAME id="frame_toolbar" frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src="./toolbar.php" onload="javascript:init_toolbar();"></FRAME>
</FRAMESET>
<BODY>
</BODY>
</HTML>
