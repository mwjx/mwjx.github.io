<?php
//------------------------------
//create time:2007-5-14
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�������ӹ���
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
//��ѡ������
//ѡ����ĿID(str)=>array({����ID(str),����(str),��Դ��ĿID(str)})
var m_arr_ed = Array(); 
var m_str_search = ""; //��ǰ��ѯ����
//window.onload = "init()";
function init_toolbar()
{
	//��ʼ��������
	//����:��
	//���:��

}
function un_link()
{
	//ȡ��ѡ�е�����
	//����:��
	//���:��
	var o = document.all["article_links"];
	if("" == o.src)
		return alert("ȡ��ʧ�ܣ�û��ѡ������");
	article_links.un_link();
}
function search_str()
{
	//��ǰ�����ַ���
	//����:��
	//���:�ַ���
	return m_str_search;
}
function search(str)
{
	//�ύ��ѯ
	//����:str(string)��ѯ����
	//���:��
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
	//��������ύ��ѯ,ͬ����post��ʽ
	//����:str�����ַ�������ʽ:submit1=Submit&text1=scsdfsd
	//���:http����,�쳣����false
	var o_http = new_xmlhttp();
	if(false === o_http)
		return false;
	//str = ("fun=set_article&info="+str);
	o_http.Open("POST","../cmd.php",false); //ͬ���ύ
	o_http.setRequestHeader("Content-Length",str.length);  
	o_http.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");	
	o_http.Send(str);
	return o_http;
}
function commit()
{
	//�ύ�޸�
	//����:��
	//���:��
	//alert(all_id_list);
	var o2 = document.all["article_links"];
	if("" == o2.src)
		return alert("�ύʧ�ܣ�û����������");
	//��������ID
	//----------
	var str_list = article_links.all_id_list();
	//if("" == str_list)
	//	return alert("�ύʧ�ܣ�û���������");
	var master_id = (article_links.get_master_id());
	if("" == master_id)
		return alert("�ύʧ�ܣ���������ID��Ч");
	//----------�ύ---------
	str = ("fun=set_article_links&list="+str_list+"&id="+master_id);
	var o_http = submit_str(str);
	if(false === o_http)
		return alert("�ύʧ��");
	//�ظ�
	if(4 != o_http.readyState)
		return alert("�ύû���յ��ظ�");
	if(o_http.status != 200)
		return alert("�ظ�״̬�쳣");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("�ظ�Ϊ��");
	
	if("OK" == o_http.responseText){
		alert("�ύ�ɹ�");
	}
	else if("FAIL" == o_http.responseText){
		alert("�ύʧ�ܣ���Ȩ��");
	}
	else{
		alert(o_http.responseText);
	}
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
function run_link()
{
	//����ǰѡ�е����������໥����
	//����:��
	//���:��
	//alert("����ǰѡ�е����������໥����");
	var o = document.all["article_list_un"];
	if("" == o.src)
		return alert("�໥����ʧ�ܣ�û��ѡ������!");
	//var o2 = document.all["article_links"];
	//if("" == o2.src)
	//	return alert("�໥����ʧ�ܣ�û��ѡ������");
	//----------
	var str_list = article_list_un.get_idlist_selected();
	if("" == str_list)
		return alert("�໥����ʧ�ܣ���ѡ������");
	if(-1 == str_list.indexOf(","))
		return alert("�໥����ʧ�ܣ�����Ҫ��ƪ����");
	//alert(str_list);
	//-----------�ύ------------
	var str = ("fun=run_article_links&list="+str_list);
	var o_http = submit_str(str);
	if(false === o_http)
		return alert("�ύʧ��");
	//�ظ�
	if(4 != o_http.readyState)
		return alert("�ύû���յ��ظ�");
	if(o_http.status != 200)
		return alert("�ظ�״̬�쳣");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("�ظ�Ϊ��");
	
	if("OK" == o_http.responseText){
		alert("�ύ�ɹ�");
	}
	else if("FAIL" == o_http.responseText){
		alert("�ύʧ�ܣ���Ȩ��");
	}
	else{
		alert(o_http.responseText);
	}
}
function add_link()
{
	//��������
	//����:��
	//���:��
	//return alert("aaa");
	//var id = 2;
	var o = document.all["article_list_un"];
	if("" == o.src)
		return alert("��������ʧ�ܣ�û��ѡ������");
	var o2 = document.all["article_links"];
	if("" == o2.src)
		return alert("��������ʧ�ܣ�û��ѡ������");
	//----------
	var str_list = article_list_un.get_idlist_selected();
	if("" == str_list)
		return alert("��������ʧ�ܣ���ѡ������");
	var arr = str_list.split(",");
	var i,id = "",title = "";
	for(i = 0;i < arr.length; ++i){
		id = arr[i];
		title = article_list_un.get_title(id);
		if("" == title)
			continue;
		article_links.add(id,title);		
	}
	//alert(str_list);
}
function show_article()
{
	//��ʾһƪ�������µ��������
	//����:��
	//���:��
	var id = -1;
	var o = document.all["article_list_un"];
	if("" == o.src)
		return alert("�鿴����ʧ�ܣ�û��ѡ������");
	//alert(); //article_list_un
	var id = article_list_un.get_id_selected();
	//return alert(id);

	if(-1 == id)
		return alert("�鿴����ʧ�ܣ�û��ѡ������");
	show_links(String(id));
}
function show_links(id)
{
	//��ʾһƪ�������µ��������
	//����:id(string)����ID
	//���:��
	//return alert(id);
	//article_links
	var sFc_uniqid = Math.round(Math.random() * 2147483647);
	var url = "./data_links.php?page=1&per=10&id="+id;
	url += "&tmp="+String(sFc_uniqid);
	document.all["article_links"].src = url;
}
/*
function get_title(cid,aid)
{
	//���±��� 
	//����:cid(string)��ĿID,aid(string)����ID
	//���:���±���,�쳣���ؿ��ַ���
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
	//�����´Ӵ�ѡ���Ƶ�ѡ����
	//����:id(string)����ID
	//���:��
	var unid = classid_un_ed(0);
	var edid = classid_un_ed(1);
	//"" == unid || 
	if("" == edid)
		return alert("��ĿID��Ч,��ѡ��һ��ѡ������Ŀ"); //��ĿID��Ч
	if(ed_had(edid,id))	
		return alert("��Ҫ�ظ���ͬһƪ���¹���ͬһ����Ŀ");
	var o = article_list_un;
	var title = o.get_title(id);
	if("" == title)
		return "���±�����Ч";
	if(null == m_arr_ed[edid])
		m_arr_ed[edid] = Array();
	m_arr_ed[edid][m_arr_ed[edid].length] = Array(id,title,unid);	
	//o.del(id);
	o = article_list_ed;
	o.add(id,title);
	
	//alert(id+":from "+unid+" to "+ edid+" title="+title);
}
function classid_un_ed(flag)
{
	//��ѡ����ѡ������ĿID
	//����:flag(int)(0/1)(��ѡ��/ѡ����)
	//���:��ĿID�ַ������쳣���ؿ��ַ���
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
	//����һ����Ŀ������������б�
	//����:id(string)��ĿID
	//���:��������,array({id(str),title(str),fromcid(str)})
	//�쳣���ؿ�����
	if(null == m_arr_ed[id])
		return Array();
	return m_arr_ed[id]
}
function ed_had(cid,id)
{
	//ѡ���б�ǰ��Ŀ�Ѿ��и�����
	//����:cid(string)ѡ����ĿID,id(string)����ID
	//���:true�Ѿ�����,false������
	if(null == m_arr_ed[cid])
		return false;
	var i;
	for(i = 0;i < m_arr_ed[cid].length; ++i){
		if(id == m_arr_ed[cid][i][0])
			return true;
	}
	return false;
}

function unlink(id)
{
	//ȡ��ѡ������������Ŀ������
	//����:id(string)����ID
	//���:��
	var edid = classid_un_ed(1);
	if("" == edid)
		return alert("ȡ������ʧ�ܣ�ѡ������Ŀ��Ч");
	//alert(edid+":"+id);
	//----------�ύ---------
	str = ("fun=unlink_article&cid="+edid+"&id="+id);
	var o_http = submit_str(str);
	if(false === o_http)
		return alert("�ύʧ��");
	//�ظ�
	if(4 != o_http.readyState)
		return alert("�ύû���յ��ظ�");
	if(o_http.status != 200)
		return alert("�ظ�״̬�쳣");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("�ظ�Ϊ��");
	
	if("OK" == o_http.responseText){
		article_list_ed.del(id);		
		alert("ȡ�����ӳɹ�");
	}
	else{
		var msg = o_http.responseText;
		alert(msg);
	}	
}
*/

</script>
</HEAD>
<FRAMESET frameBorder="1" frameSpacing="0" rows="85%,15%">
	<FRAMESET frameBorder="1" frameSpacing="0" cols="50%,50%">
		<FRAMESET frameBorder="1" frameSpacing="0" rows="40%,60%">
			<FRAME frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src="./data_all_class.php?type=article"></FRAME>
			<FRAME id="article_list_un" frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src=""></FRAME>
		</FRAMESET>
		<FRAMESET frameBorder="1" frameSpacing="0" rows="99%,1%">
			<FRAME id="article_links" frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src=""></FRAME>
			<FRAME frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src=""></FRAME>
		</FRAMESET>
	</FRAMESET>
	<FRAME id="frame_toolbar" frameBorder="0" marginHeight="0" marginWidth="0"  noResize="yes" scrolling="auto" src="./link_toolbar.php" onload="javascript:init_toolbar();"></FRAME>
</FRAMESET>
<BODY>
</BODY>
</HTML>
