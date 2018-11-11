//------------------------------
//create time:2007-1-31
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:首页脚本
//------------------------------
//收藏本站漂浮
lastScrollY=0;
write_favorite();

function login_reg_out(flag)
{
	//登录，注册，退出
	//输入:flag(int)1/2/3(登录/注册/退出)
	//输出:true成功,false失败
	if(1 != flag && 2 != flag && 3 != flag)
		return false;
	var name = document.all["username"].value;
	var pswd = document.all["password"].value;
	if(1 == flag || 2 == flag){ //检查用户名密码是否为空
		if("" == name || "" == pswd){
			var str = "";
			if(1 == flag)
				str = "登录失败，请在上面输入框填入用户名和密码";
			else
				str = "注册失败，请在上面输入框填入要注册的用户名和密码";
			alert(str);
			return false;
		}
	}
	var action = "";
	switch(flag){
		case 1:
			action = "login";
			break;
		case 2:
			action = "reg";
			break;
		case 3:
			action = "out";
			break;
		default:
			alert("error:");
			return false;
	}
	document.all["action"].value = action;//设置动作值
	//alert(document.all["action"].value);
	return true;
}
function main_init()
{
	//alert("初始化首页");
	//document.all["td_logininfo"].style.display = "block";
	//document.all["td_logininfo"].innerHTML = "XXXXXX";
	//alert("首页初始化");
	//return;
	//document.all["td_logininfo"].style.display = "block";

	if((null == get_cookie("username")) || ("" == get_cookie("username"))){  //未登录
		//document.all["td_logininfo"].innerHTML = "未登录";
	
		return;				
	}
	else{
		//document.all["td_logininfo"].innerHTML = "已经登录";

	}
	//return;
	//已经登录
	document.all["td_loginbox"].style.display = "none";
	document.all["td_logininfo"].style.display = "block";
	//var obj = document.all["td_loginbox"];
	var html = ""; //(get_cookie("username"))+",";
	html+= "欢迎来妙文精选<br/><a href=\"/mwjx/home.php\"><b>我的妙文</b></a><br/>";
	html += "<a href=\"#\" onclick=\"javascript:local_logout();\">退出登录</a>";
	document.all["td_logininfo"].innerHTML = html;
}
function local_logout()
{
	//退出登录
	SetCookie("username","");
	SetCookie("userpass","");
}

//<!--2007-8-4 18:23:34  -- 广告JS:漂浮右收藏-->


function heartBeat()
{ 
	var diffY;
	if (document.documentElement && document.documentElement.scrollTop){
	  diffY = document.documentElement.scrollTop;
	}
	else if (document.body){
	  diffY = document.body.scrollTop
	}
	else{/*Netscape stuff*/}
	  
	//alert(diffY);
	percent=.1*(diffY-lastScrollY); 
	if(percent>0)
		percent=Math.ceil(percent); 
	else 
		percent=Math.floor(percent); 
	document.getElementById("web_ad").style.top=parseInt(document.getElementById 
	("web_ad").style.top)+percent+"px";
	lastScrollY=lastScrollY+percent; 
	//alert(lastScrollY);
}
function write_favorite()
{
	var suspendcode="<DIV id=\"web_ad\" style='right:5px;POSITION:absolute;TOP:200px; width:85px;height:85px;border:0px solid #ddd;'><a onclick=\"window.external.addFavorite('http://www.mwjx.com','mwjx.com妙文精选，幽默搞笑网文！');\" href='#' target='_self'><img src='/mwjx/images/01.gif' alt='加入收藏' border=\"0\"/></a></div>"
	document.write(suspendcode);
	window.setInterval("heartBeat()",30);
}
