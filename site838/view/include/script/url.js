//------------------------------
//create time:2007-1-10
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:url��غ���
//------------------------------
function getquerystring(str)
{
	var LocString=String(top.window.document.location.href);
	//this.show_init(LocString);
    var rs=new RegExp("(^|)"+str+"=([^\&]*)(\&|$)","gi").exec(LocString),tmp;
    if(tmp=rs)return tmp[2];
	return false;
}
function get_get_var(name)
{
	//ȡurl��get��ʽ��ֵ
	//���룺name��url���еı�����
	//�������ȷ��ֵ���쳣����false
	if(typeof(name) == "undefined")
		return false;
	return getquerystring(name);
}
function get_get_var2(name,url)
{
	//ȡurl��get��ʽ��ֵ
	//���룺name��url���еı�����,url��url�ַ���
	//�������ȷ��ֵ���쳣����false
	if(typeof(name) == "undefined")
		return false;
    var rs=new RegExp("(^|)"+name+"=([^\&]*)(\&|$)","gi").exec(url),tmp;
    if(tmp=rs)return tmp[2];
	return false;
}

