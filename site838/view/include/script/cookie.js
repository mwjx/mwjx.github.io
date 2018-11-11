//------------------------------
//create time:2007-1-24
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:cookie或本地客户端存储相关信息
//------------------------------
//------------------cookie----------------
function get_cookie(name)
{
	//取cookie值　
	//输入:name(string)cookie变量名
	//输出:值字符串，异常返回null
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen){
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg) return getCookieVal (j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0) break;
	}
	return (null);
}
function getCookieVal(offset)
{
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1) endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}
function SetCookie(name, value)
{
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path    = (argc > 3) ? argv[3] : null;
	var domain  = (argc > 4) ? argv[4] : null;
	var secure  = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape (value) + ((expires == null) ? "" : ("; expires=" + expires.toUTCString())) + ((path == null) ? "" : ("; path=" + path)) + ((domain == null)  ? "" : ("; domain=" + domain)) + ((secure == true)  ? "; secure" : "");
	return true;
}
//------------------end cookie-----------