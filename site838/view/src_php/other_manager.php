<?php
//------------------------------
//create time:2007-1-20
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:杂项管理
//------------------------------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312"/>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<script type="text/javascript" src="../include/script/url.js"></script>
<script type="text/javascript" src="../include/script/global.js"></script>
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
function create_index()
{
	//生成网站及栏目首页
	//输入:无
	//输出:无
	//return alert("aaa");
	//----------提交---------
	var str = ("fun=create_index");
	var o_http = submit_str2(str,"../cmd.php");
	if(false === o_http)
		return alert("提交失败");
	//回复
	if(4 != o_http.readyState)
		return alert("提交没有收到回复");
	if(o_http.status != 200)
		return alert("回复状态异常");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("回复为空");
	
	var msg = o_http.responseText;
	alert(msg);
}
function create_link()
{
	//生成文章相关链接
	//输入:无
	//输出:无
	//return alert("aaa");
	//----------提交---------
	var str = ("fun=create_link");
	var o_http = submit_str2(str,"../cmd.php");
	if(false === o_http)
		return alert("提交失败");
	//回复
	if(4 != o_http.readyState)
		return alert("提交没有收到回复");
	if(o_http.status != 200)
		return alert("回复状态异常");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("回复为空");
	
	var msg = o_http.responseText;
	alert(msg);
}
</script>
</HEAD>
<BODY>
<button onclick="javascript:create_index();">生成网站首页</button>
<!--<button onclick="javascript:create_link();">生成文章相关链接</button>//-->
</BODY>
</HTML>
