<?php
//------------------------------
//create time:2007-1-10
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:文章管理,工具区
//------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<meta http-equiv="Content-Type" content="text/html;charset=gb2312"/>
<link rel="stylesheet" href="../css/all.css" type="text/css"/>
<script language="javascript">
function search_area()
{
	//查询的区域
	//输入:无
	//输出:字符串，un/ed(待选区/选中区)
	return "un";
	/*
	if(radio[0].checked)
		return "un";
	return "ed";
	*/
}
</script>
</HEAD>

<BODY>
<table width="100%">
<tr><td align="left">
查询:<input style="BORDER-RIGHT: 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" maxlength="12" size="16" id="querytext" onkeydown="javascript:if(13 == event.keyCode){parent.search(querytext.value);}">

<input style="BORDER-RIGHT: 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: 1px solid; BORDER-BOTTOM: 1px solid" type="button" value=" 提交 " id="submit" onclick="javascript:parent.search(querytext.value);"/>
<br/>
<button onclick="javascript:parent.show_article();">查看文章链接</button><br/>
<button onclick="javascript:parent.add_link();">加入链接</button>&nbsp;&nbsp;
<button onclick="javascript:parent.run_link();">相互链接</button><br/>
</td><td align="left">
<button onclick="javascript:parent.un_link();">取消链接</button><br/>
<button onclick="javascript:parent.commit();">提交修改</button>
</td></tr>
</table>
</BODY>
</HTML>
