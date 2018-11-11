//------------------------------
//create time:2008-4-9
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:推荐类目
//------------------------------
function vote_book(id)
{
	//给类目投票
	//输入:要投票的类目ID
	//输出:无
	//return alert(ls);
	//----------提交---------
	str = ("fun=vote_book&id="+id);
	//return alert(str);
	var o_http = submit_str2(str,"/site838/view/cmd.php");
	if(false === o_http)
		return alert("提交失败");
	//return;
	//回复
	if(4 != o_http.readyState)
		return alert("提交没有收到回复");
	if(o_http.status != 200)
		return alert("回复状态异常");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("回复为空");
	//return alert(o_http.responseText);
	//if("FAIL" == o_http.responseText){
	//	alert("投票失败，请先登录再投票");
	//}
	//else{
		//var arr = o_http.responseText.split(",");
	var msg = o_http.responseText;
	var arr = msg.split(":");
	var sigl = parseInt(arr[1],10);
	switch(sigl){
		case 0:
			return alert("投票成功");
		case -1:
			return alert("投票失败，已经投过票");
		case -2:
			return alert("投票失败，小说无效");
		case -3:
			return alert("投票失败，请先登录再投票");
		default:
			return alert("投票失败，请先登录再投票");
	}
		//if("" != msg){
		//	msg = ("以下类目提交失败，可能类目无效或已经在类目中:\n"+msg);
		//}
		//alert(msg);
	//}
}
function recommend_link(id)
{
	//推荐类目
	//输入:要推荐的类目ID
	//输出:无
	var str = "77_"+id;
	//return alert(ls);
	//----------提交---------
	str = ("fun=link_class&info="+str);
	//return alert(str);
	var o_http = submit_str2(str,"/site838/view/cmd.php");
	if(false === o_http)
		return alert("提交失败");
	//return;
	//回复
	if(4 != o_http.readyState)
		return alert("提交没有收到回复");
	if(o_http.status != 200)
		return alert("回复状态异常");
	if("" == o_http.responseText || null == o_http.responseText || ("undifined" == typeof(o_http.responseText)))
		return alert("回复为空");
	//return alert(o_http.responseText);
	if("OK" == o_http.responseText){
		alert("提交成功");
	}
	else if("FAIL" == o_http.responseText){
		alert("提交失败，无权限");
	}
	else{
		//var arr = o_http.responseText.split(",");
		//var msg = o_http.responseText;
		var msg = "";
		//if("" != msg){
			msg = ("以下类目提交失败，可能类目无效或已经在类目中:\n");
		//}
		alert(msg);
	}
	//m_arr_ed = Array(); //清空提交集合		
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
	//批量链接类目
	//输入:无
	//输出:无
	//return alert("aaa");
	//var id = 2;
	var unid = classid_un_ed(0);
	var edid = classid_un_ed(1);
	if("" == edid)
		return alert("类目ID无效,请选择一个选中区类目"); //类目ID无效
	var o = document.all["class_list_un"];
	if("" == o.src)
		return alert("加入链接失败，没有选中类目");
	var o2 = document.all["class_list_ed"];
	if("" == o2.src)
		return alert("加入链接失败，没有选中类目");
	//----------
	var str_list = class_list_un.get_idlist_selected();
	if("" == str_list)
		return alert("加入链接失败，请选择类目");
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