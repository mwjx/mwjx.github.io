//------------------------------
//create time:
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:
//------------------------------
function count(arr)
{
	//ͳ������Ԫ�ظ���
	//����:arrҪͳ�Ƶ�����
	//���:Ԫ�ظ�������
	var count = 0;
	var key;
	for(key in arr){
		++ count;
	}
	return count;
}
function submit_str2(str,url)
{
	//��������ύ��ѯ,ͬ����post��ʽ
	//����:str�����ַ�������ʽ:submit1=Submit&text1=scsdfsd
	//url������յ�ַ
	//���:http����,�쳣����false
	//
	//new_xmlhttp��Ҫxmlhttp��֧��
	//alert();
	var o_http = new_xmlhttp();
	if(false === o_http)
		return false;
	//return alert("aaaa");
	
	//str = ("fun=set_article&info="+str);
	o_http.Open("POST",url,false); //ͬ���ύ
	o_http.setRequestHeader("Content-Length",str.length);  
	o_http.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");	
	o_http.setRequestHeader("Content-Type","text/html; encoding=gb18030");
	//<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
	//o_http.setRequestHeader("CONTENT-TYPE","text/html;charset=gb2312");
	o_http.Send(str);
	return o_http;
}
