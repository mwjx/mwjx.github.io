<?php
//------------------------------
//create time:2008-1-2
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:ֻ������
//------------------------------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> ���ľ�ѡ|www.mwjx.com </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<script type="text/javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
function init()
{
	//txt_source.value = "";
	return;
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
function pick()
{
	//��ʼ��ȡ
	//����:��
	//���:��
	//var a = "abcdefghijklmnopqrstuvwxyz";

	//return alert(a.substring(5));//��ȡ�ӵ���λ�Ժ�������ַ���

	//return alert(a.substring(5,5)); //��ȡ�ӵ�0����5 �Ժ�������ַ���
	
	//return alert("����δ���");
	txt_des.value = "";
	var key_s = document.all["key_s"].value;		
	var key_e = document.all["key_e"].value;
	var source = txt_source.value;
	var pos = 0,end=0,start=0,len = 0;
	var count = 0;
	while(-1 != (pos=source.indexOf(key_s,pos))){
		//return alert(source.substring(46,48));
		start = pos;
		pos += key_s.length;
		end = source.indexOf(key_e,pos)
		//return alert(start+":"+pos+":"+end+"");
		//if(-1 == end)
		//	len = source.length - start;
		//else
		//	len = end - start;
		if(-1 == end)
			pos = source.length;
		else
			pos = end;
		//alert(start+":"+end+"\n"+source.substring(start,end));
		if("" != txt_des.value)
			txt_des.value += "\n";
		if(-1 == end)
			txt_des.value +=  source.substring(start);
		else
			txt_des.value +=  source.substring(start,end);
		//if(count++ > 10)
		//	break;
	}
	//alert(key_s+"|"+key_e);
}
function front_page()
{
	//������ǰ���һҳ
	//����:��
	//���:��
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
	//����Ƿ��������
	//����:��
	//���:��
	//alert(document.all.ifm_down.readyState);
	//complete/loaded
	if("complete" == document.all.ifm_down.readyState){
		//alert(ifm_down.document.body.innerHTML);
		//alert("�������");
		//alert(ifm_down.dataSrc);
		//alert(document.all.ifm_down.innerText);		
		//alert(ifm_down.document);
		//alert(ifm_down.document.links.length);
		return;
	}
	//window.statue = "aa";
	window.setTimeout("check_ok()",500); //0.5��
}
</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" onload="javascript:init();">
<table width="100%" cellSpacing=0 cellPadding=0 align=center border=0><tr><td>
</td>
<td>
��ʼ��<input type="text" name="key_s" value="���ߣ������"/>
������<input type="text" name="key_e" value="���ߣ�"/>
</td>
</tr>
</table>
<table width="100%" cellSpacing=0 cellPadding=0 align=center border=0><tr><td>
<TEXTAREA ID="txt_source" name="txt_source" cols="60" rows="20">
</TEXTAREA>

</td>
<td>
<TEXTAREA ID="txt_des" name="txt_des" cols="60" rows="20">

</TEXTAREA>

</td>
</tr>
</table>
<table width="100%" cellSpacing=0 cellPadding=0 align=center border=0><tr><td align="center">
<button onclick="javascript:pick();"> �� ȡ </button>
</td></tr>
</table>

</BODY>
</HTML>
