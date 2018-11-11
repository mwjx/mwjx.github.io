<?php
//------------------------------
//create time:2007-10-23
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:提取网页链接
//------------------------------
//echo "hello";
//$content = file_get_contents("http://localhost/");
//echo $content;
//exit();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 妙文精选|www.mwjx.com </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
function init()
{
	//alert((ifm_fish_qq.document.links[9].innerText));
	//return;
	//alert(ifm_fish_qq.document.links.length);
	//http://localhost/index.html
	//ifm_fish_qq.src = "http://localhost/index.html";	
	var str = "";
	for(var i = 0;i < ifm_fish_qq.document.links.length;++i){
		str += "0`|)";
		str += (ifm_fish_qq.document.links[i].innerText+"`|)");
		//aa`|)bbb
		str += (ifm_fish_qq.document.links[i].href+"\n");
		//str += (ifm_fish_qq.document.links[i].innerText+"\n");
	}
	//alert(str);
	txt_out.value = str;
}
function down_page()
{
	//下载页面
	//输入:无
	//输出:无
	return alert("功能未完成");
	//alert(txt_out.value);
	//ifm_down
	front_page();
	window.setTimeout("check_ok()",500); //0.5秒
	/*
	var arr = txt_out.value.split("\n");
	var row=null,url = "";
	for(var i = 0;i < arr.length;++i){
		row = arr[i].split("`|)");
		if(3 != row.length)
			continue;
		url = row[2];
		//ifm_down.src = url;
		//alert(url);
		document.all.ifm_down.src= url;
		//document.all.ifm_down.src="http://localhost/";
		//ifm_down.body.location.href = "http://localhost/";
		break;
	}
	//alert("下载页面");
	*/
}
function front_page()
{
	//下载最前面的一页
	//输入:无
	//输出:无
	var arr = txt_out.value.split("\n");
	var row=null,url = "";
	for(var i = 0;i < arr.length;++i){
		row = arr[i].split("`|)");
		if(3 != row.length)
			continue;
		url = row[2];
		//ifm_down.src = url;
		//url = "http://localhost/ads.html";
		//url = "./down_page.php?url="+escape(url);
		//alert(url);
		document.all.ifm_down.src= url;
		//document.all.ifm_down.src="http://localhost/";
		//ifm_down.body.location.href = "http://localhost/";
		break;
	}
}
function frm_ok()
{
	//readyState
}
function check_ok()
{
	//检查是否下载完成
	//输入:无
	//输出:无
	//alert(document.all.ifm_down.readyState);
	//complete/loaded
	if("complete" == document.all.ifm_down.readyState){
		//alert(ifm_down.document.body.innerHTML);
		//alert("下载完成");
		//alert(ifm_down.dataSrc);
		//alert(document.all.ifm_down.innerText);		
		//alert(ifm_down.document);
		//alert(ifm_down.document.links.length);
		return;
	}
	//window.statue = "aa";
	window.setTimeout("check_ok()",500); //0.5秒
}
</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" onload="javascript:init();">
<table width="100%" cellSpacing=0 cellPadding=0 align=center border=0><tr><td>
<IFRAME align="left" marginWidth="0" marginHeight="0" src="http://localhost/links.html" frameBorder="0" scrolling="auto" name="ifm_fish_qq" style="width:100px;height:100px;"></IFRAME>
</td>
<td>
<IFRAME align="left" marginWidth="0" marginHeight="0" src="" frameBorder="0" scrolling="auto" id="ifm_down" name="ifm_down" style="width:300px;height:200px;"></IFRAME>
</td>
</tr>
</table>
<table width="100%" cellSpacing=0 cellPadding=0 align=center border=0><tr><td>
<TEXTAREA STYLE="overflow:hidden" ID="txt_out" name="txt_out" cols="70" rows="20">
</TEXTAREA>

</td>
<td>
<TEXTAREA STYLE="overflow:hidden" ID="txt_down" name="txt_down" cols="70" rows="20">
</TEXTAREA>

</td>
</tr>
</table>
<table width="100%" cellSpacing=0 cellPadding=0 align=center border=0><tr><td align="center">
<button onclick="javascript:down_page();"> 下 载 </button>
</td></tr>
</table>

</BODY>
</HTML>
