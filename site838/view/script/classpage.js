//------------------------------
//create time:2008-4-9
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�Ƽ���Ŀ
//------------------------------
function vote_book(id)
{
	//����ĿͶƱ
	//����:ҪͶƱ����ĿID
	//���:��
	//return alert(ls);
	//----------�ύ---------
	str = ("fun=vote_book&id="+id);
	//return alert(str);
	var o_http = submit_str2(str,"/site838/view/cmd.php");
	if(false === o_http)
		return alert("�ύʧ��");
	//return;
	//�ظ�
	if(4 != o_http.readyState)
		return alert("�ύû���յ��ظ�");
	if(o_http.status != 200)
		return alert("�ظ�״̬�쳣");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("�ظ�Ϊ��");
	//return alert(o_http.responseText);
	//if("FAIL" == o_http.responseText){
	//	alert("ͶƱʧ�ܣ����ȵ�¼��ͶƱ");
	//}
	//else{
		//var arr = o_http.responseText.split(",");
	var msg = o_http.responseText;
	var arr = msg.split(":");
	var sigl = parseInt(arr[1],10);
	switch(sigl){
		case 0:
			return alert("ͶƱ�ɹ�");
		case -1:
			return alert("ͶƱʧ�ܣ��Ѿ�Ͷ��Ʊ");
		case -2:
			return alert("ͶƱʧ�ܣ�С˵��Ч");
		case -3:
			return alert("ͶƱʧ�ܣ����ȵ�¼��ͶƱ");
		default:
			return alert("ͶƱʧ�ܣ����ȵ�¼��ͶƱ");
	}
		//if("" != msg){
		//	msg = ("������Ŀ�ύʧ�ܣ�������Ŀ��Ч���Ѿ�����Ŀ��:\n"+msg);
		//}
		//alert(msg);
	//}
}
function recommend_link(id)
{
	//�Ƽ���Ŀ
	//����:Ҫ�Ƽ�����ĿID
	//���:��
	var str = "77_"+id;
	//return alert(ls);
	//----------�ύ---------
	str = ("fun=link_class&info="+str);
	//return alert(str);
	var o_http = submit_str2(str,"/site838/view/cmd.php");
	if(false === o_http)
		return alert("�ύʧ��");
	//return;
	//�ظ�
	if(4 != o_http.readyState)
		return alert("�ύû���յ��ظ�");
	if(o_http.status != 200)
		return alert("�ظ�״̬�쳣");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("�ظ�Ϊ��");
	//return alert(o_http.responseText);
	if("OK" == o_http.responseText){
		alert("�ύ�ɹ�");
	}
	else if("FAIL" == o_http.responseText){
		alert("�ύʧ�ܣ���Ȩ��");
	}
	else{
		//var arr = o_http.responseText.split(",");
		//var msg = o_http.responseText;
		var msg = "";
		//if("" != msg){
			msg = ("������Ŀ�ύʧ�ܣ�������Ŀ��Ч���Ѿ�����Ŀ��:\n");
		//}
		alert(msg);
	}
	//m_arr_ed = Array(); //����ύ����		
	/*
	*/
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
/*
function add_link()
{
	//����������Ŀ
	//����:��
	//���:��
	//return alert("aaa");
	//var id = 2;
	var unid = classid_un_ed(0);
	var edid = classid_un_ed(1);
	if("" == edid)
		return alert("��ĿID��Ч,��ѡ��һ��ѡ������Ŀ"); //��ĿID��Ч
	var o = document.all["class_list_un"];
	if("" == o.src)
		return alert("��������ʧ�ܣ�û��ѡ����Ŀ");
	var o2 = document.all["class_list_ed"];
	if("" == o2.src)
		return alert("��������ʧ�ܣ�û��ѡ����Ŀ");
	//----------
	var str_list = class_list_un.get_idlist_selected();
	if("" == str_list)
		return alert("��������ʧ�ܣ���ѡ����Ŀ");
	var arr = str_list.split(",");
	var i,id = "",title = "";
	if(null == m_arr_ed[edid])
		m_arr_ed[edid] = Array();
	for(i = 0;i < arr.length; ++i){
		id = arr[i];
		title = class_list_un.get_title(id);
		//alert(id+":"+title);
		if("" == title)
			continue;
		if(ed_had(edid,id))	
			continue;		
		//article_links.add(id,title);		
		m_arr_ed[edid][m_arr_ed[edid].length] = Array(id,title,unid);	
		//o.del(id);
		//o = article_list_ed;
		class_list_ed.add(id,title);	
	}
	//alert(str_list);
}
*/