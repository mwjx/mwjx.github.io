<?php
//------------------------------
//create time:2007-1-20
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�������
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
	//������վ����Ŀ��ҳ
	//����:��
	//���:��
	//return alert("aaa");
	//----------�ύ---------
	var str = ("fun=create_index");
	var o_http = submit_str2(str,"../cmd.php");
	if(false === o_http)
		return alert("�ύʧ��");
	//�ظ�
	if(4 != o_http.readyState)
		return alert("�ύû���յ��ظ�");
	if(o_http.status != 200)
		return alert("�ظ�״̬�쳣");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("�ظ�Ϊ��");
	
	var msg = o_http.responseText;
	alert(msg);
}
function create_link()
{
	//���������������
	//����:��
	//���:��
	//return alert("aaa");
	//----------�ύ---------
	var str = ("fun=create_link");
	var o_http = submit_str2(str,"../cmd.php");
	if(false === o_http)
		return alert("�ύʧ��");
	//�ظ�
	if(4 != o_http.readyState)
		return alert("�ύû���յ��ظ�");
	if(o_http.status != 200)
		return alert("�ظ�״̬�쳣");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("�ظ�Ϊ��");
	
	var msg = o_http.responseText;
	alert(msg);
}
</script>
</HEAD>
<BODY>
<button onclick="javascript:create_index();">������վ��ҳ</button>
<!--<button onclick="javascript:create_link();">���������������</button>//-->
</BODY>
</HTML>
