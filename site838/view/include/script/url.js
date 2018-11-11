//------------------------------
//create time:2007-1-10
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:url相关函数
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
	//取url中get方式的值
	//输入：name是url当中的变量名
	//输出：正确的值，异常返回false
	if(typeof(name) == "undefined")
		return false;
	return getquerystring(name);
}
function get_get_var2(name,url)
{
	//取url中get方式的值
	//输入：name是url当中的变量名,url是url字符串
	//输出：正确的值，异常返回false
	if(typeof(name) == "undefined")
		return false;
    var rs=new RegExp("(^|)"+name+"=([^\&]*)(\&|$)","gi").exec(url),tmp;
    if(tmp=rs)return tmp[2];
	return false;
}

