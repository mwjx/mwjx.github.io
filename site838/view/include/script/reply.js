//------------------------------
//create time:2007-1-25
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:跟贴
//------------------------------
function login()
{
	//登录
	//输入:无
	//输出:无
	alert("登录功能未完成");		
}
function f_start() 
{
	//return;	
	/*
	var Widget = new WebTabs_widget(585, 245, 0, 0, "relative");
	Widget.add(new WebTabs_tab("&nbsp;评论列表&nbsp;&nbsp;", "page_1", "../image/comment-ico1.gif"));
	Widget.add(new WebTabs_tab("发表评论&nbsp;&nbsp;", "page_2", "../image/comment-ico2.gif"));
	document.getElementById("WebTabs_container").innerHTML = Widget
	Widget.f_init_tabs();
	//Widget.f_move_to(120, 20);
	Widget.f_move_by(0, 0);
	Widget.f_activate_tab(v);
	*/
	if((null == get_cookie("username")) || (null == get_cookie("userpass"))){
		//document.all["tbl_login_input"].style.display = "block";		
		document.all["message"].value = "没有登录，登录后才可留言";
		document.all["bt_commit"].style.display = "none";
	}
	else{
		document.all["message"].value = "";
		document.all["bt_commit"].style.display = "block";
	}
}
