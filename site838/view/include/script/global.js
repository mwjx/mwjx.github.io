//------------------------------
//create time:
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:
//------------------------------
function count(arr)
{
	//统计数组元素个数
	//输入:arr要统计的数组
	//输出:元素个数整形
	var count = 0;
	var key;
	for(key in arr){
		++ count;
	}
	return count;
}
function submit_str2(str,url)
{
	//向服务器提交查询,同步，post方式
	//输入:str变量字符串，格式:submit1=Submit&text1=scsdfsd
	//url命令接收地址
	//输出:http对象,异常返回false
	//
	//new_xmlhttp需要xmlhttp库支持
	//alert();
	var o_http = new_xmlhttp();
	if(false === o_http)
		return false;
	//return alert("aaaa");
	
	//str = ("fun=set_article&info="+str);
	o_http.Open("POST",url,false); //同步提交
	o_http.setRequestHeader("Content-Length",str.length);  
	o_http.setRequestHeader("CONTENT-TYPE","application/x-www-form-urlencoded");	
	o_http.setRequestHeader("Content-Type","text/html; encoding=gb18030");
	//<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
	//o_http.setRequestHeader("CONTENT-TYPE","text/html;charset=gb2312");
	o_http.Send(str);
	return o_http;
}
