//------------------------------
//create time:2006-12-27
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:xmldom���
//------------------------------
function g_agent()
{ 
	//������汾
	//����:��
	//���:ie/firefox/gg
	try{
		//var uaInfo = navigator.userAgent;
		var aginfo = navigator.userAgent.toLowerCase();
		if(aginfo.indexOf("firefox") != -1)
			return "firefox";
		if(aginfo.indexOf("safari") > -1 || aginfo.indexOf("chrome") > -1)
			return "gg";
		return "ie";
	}
	catch(exception){
		return "ie";
	}
}
function new_xmldom()
{
	//����DOMDocument����
	//���룺��
	//��������dom�����쳣����false
	var obj_dom = null;
	if(!document.all) //firefox
		return document.implementation.createDocument("", "", null);
	var arr_activex = ["MSXML.DOMDocument","MSXML4.DOMDocument", "MSXML3.DOMDocument", "MSXML2.DOMDocument", "Microsoft.XmlDom"];
	for(var i=0; i < arr_activex.length; i++){
		try{
			obj_dom = new ActiveXObject(arr_activex[i]);
			return obj_dom;
		}
		catch(err){
			return false;
		}
	}
	return false;
}
function new_xmlhttp()
{
	//�½�һ��xmlhttp����
	//���룺��
	//�������������xmlhttp�����쳣����false
	//alert("111");
	var obj_xmlhttp = null;
	var i_ver = agent_version();
	if(false == i_ver){ //��IE,���п�����firefox
		obj_xmlhttp = new XMLHttpRequest();
		//alert(obj_xmlhttp);
		return obj_xmlhttp;
	}

	var arr_activex = ["MSXML2.XMLHTTP","Microsoft.XMLHTTP","Msxml2.ServerXMLHTTP","WinHttp.WinHttpRequest","MSXML4.XMLHTTP", "MSXML3.XMLHTTP"];
	for(var i=0; i < arr_activex.length; i++){
		try{
			
			obj_xmlhttp = new ActiveXObject(arr_activex[i]);
			return obj_xmlhttp;

		}
		catch(err){
			obj_xmlhttp = null;
		}
	}
	throw(new Error('Cant Create XMLHTTP'));
	return false;
}
function agent_version()
{
	//������汾
	//����:��
	//���:�汾(����),�쳣(��IE��Ϊ�쳣)����false
	try{
		if(navigator.userAgent.toLowerCase().indexOf("firefox") != -1)
			return false;
		if(!window.clientInformation)return false;
		if(window.clientInformation.appName.toLowerCase()!="microsoft internet explorer")return false;
		if(window.clientInformation.appVersion.toLowerCase().indexOf("msie")==-1)return false;
		var a=window.clientInformation.appVersion.toLowerCase().split(";");
		for(var i=0;i<a.length;i++){
			a[i]=a[i].replace(" ","");
			if(a[i].indexOf("msie")==0){
				var version=a[i].substr(4,a[i].indexOf(".")-2);
				return version;
			}
		}
	}
	catch(exception){
	}
	return false;
}
