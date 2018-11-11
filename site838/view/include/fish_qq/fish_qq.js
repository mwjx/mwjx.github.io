//------------------------------
//create time:
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:
//------------------------------
//--------全局对象-------
/*
function setFileCookie(name,value,timeout,dm){
	var expires=new Date();
	if(!timeout)
	timeout=10*12*30*24*3600*1000;
	if(!dm)
	dm="qq.com"
	expires.setTime(expires.getTime()+timeout);
	document.cookie=name+"="+value+";expires="+expires.toGMTString()+"; path=/; domain="+dm;
}
*/
//document.domain = "mwjx.com";
//document.domain = "mwjx.com";
//alert(document.domain);
//alert(document.cookie);
//document.domain= "mwjx.com";
//SetCookie("domain","mwjxhome.3322.org");
var g_str_fast_url = "http://mwjxhome.3322.org:8099/gm_s";
//var g_str_fast_url = "http://localhost:8099/gm_s";
var g_interval = new c_interval("pump()",3000); //心跳机
var g_commu = new c_server_msg(); //通讯器
g_commu.set_fast_url(g_str_fast_url);
var g_client = new c_client(); //客户端
var g_msg_machine = new msg_deal_machine(); //消息处理机
var g_started = false; //是否开始标志
//-------end全局对象-----
document.write(main_html());
login();



//main_start(); //世界开始
function main_start()
{
	//世界开始
	//输入:无
	//输出:无
	if(g_started)
		return;
	//document.write(main_html());
	
	g_interval.run();
	g_started = true;
}
function get_dir()
{
	return "/mwjx/";
}
function main_html()
{
	//主界面html代码
	//输入:无
	//输出:html字符串
	var dir = get_dir();
	var html_bgs = "<BGSOUND id=bgs loop=1 autostart=false src=\"\"/>";
	var html = html_bgs+"<table width=\"100%\" height=\"30\" border=\"0\" style=\"background-color: red;BACKGROUND: url("+dir+"images/nv_bg.gif) repeat-x bottom;HEIGHT: 30px;\">";
	html += "<tr><td width=\"19%\"><img src=\""+dir+"images/nv_home.gif\"/><a href=\"/index.html\" target=\"_blank\" style=\"font-size:12px;\">首页</a>&nbsp;<img src=\""+dir+"images/nv_myhome.gif\"/><a href=\"/index.html\" target=\"_blank\" style=\"font-size:12px;\">登录</a></td>";
	html += "<td width=\"1%\"><img src=\""+dir+"images/nv_tiao.gif\"/></td>";

	html += "<td width=\"59%\"><input id=\"txt_msg\" type=\"text\" value=\"\" size=\"60\" onkeydown=\"javascript:if(13 == event.keyCode){send();}\"/>&nbsp;<input type=\"button\" value=\"发送\" onclick=\"javascript:send();\"/></td><td width=\"1%\"><img src=\""+dir+"images/nv_tiao.gif\"/></td>";

	html += "<td width=\"19%\" id=\"td_control\"><a href=\"#\"  style=\"font-size:12px;color:red\" onclick=\"javascript:show_msglist();\">消息列表</a></td><td width=\"1%\"><img src=\""+dir+"images/nv_tiao.gif\"/></td>";

	html += "</tr>";

	html += "</table>";
	html += "<table width=\"100%\" height=\"206\" id=\"tbl_msglist\" style=\"display:none;\"> <tr><td>";
	html += html_msglist();
	html += "</td></tr></table>";
	return html;
}
function html_msglist()
{
	//消息列表界面代码
	//输入:无
	//输出:html字符串
	var dir = get_dir();	
	var html = "";
	//html += "<IFRAME frameBorder=0 id=\"ifm_msglist\" scrolling=\"?\" src=\"/mwjx/include/fish_qq/msglist.html\" style=\"HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1\"></IFRAME>";
	
	html += "<table width=\"300\" height=\"206\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"   style=\"display:block;left:250px;top:30px;position:absolute;\">";
	html += "<tr><td id=\"td_msglist\" align=\"left\" valign=\"top\" style=\"BACKGROUND: url("+dir+"images/bg1.jpg) no-repeat top left;font-size:12px;padding-left:10px;\"><TEXTAREA id=\"txt_msglist\" style=\"border:0px;color:#971A4B; background-image:url("+dir+"images/bg1.jpg) no-repeat top left;font:bold 12pt;height:200px;width:270px\"></TEXTAREA> ";
	html += "<img style='cursor:hand;position:absolute;left:285px;top:5px;display:block' src=\""+dir+"images/cha.gif\" onclick=\"javascript:hide_msglist();\" alt=\"关闭消息列表\"/>";
	html += "</td></tr>";
	html += "</table>";
	/**/
	return html;
}
function hide_msglist()
{
	//关闭消息列表
	//输入:无
	//输出:无
	//alert("aa");
	//parent.document.all.ifm_fish_qq.style.height = "30px";
	//parent.height_ifmqq("30px");
	window.clipboardData.setData('text',"hide_msglist"); //通知父亲
	document.all["tbl_msglist"].style.display = "none";
	//document.all["ifm_msglist"].style.display = "none";

}
function show_msglist()
{
	//显示消息列表
	//输入:无
	//输出:无
	//parent.document.all.ifm_fish_qq.style.height = "240px";
	//return alert("240px");
	//parent.height_ifmqq("240px");
	window.clipboardData.setData('text',"show_msglist"); //通知父亲
	document.all["tbl_msglist"].style.display = "block";
	//alert(parent.ifm_fish_qq);
	//parent.window.document.body.style.height = "30px";
	//var sBorderValue = parent.ifm_fish_qq.style.border;
	//var collAll = document.frames("ifm_fish_qq").document.all
	//alert(parent.document.all.ifm_fish_qq.style.height);
	//document.all["ifm_msglist"].style.display = "block";
	close_alert();

}
function alert_msg()
{
	//提醒有新消息
	//输入:无
	//输出:无
	var dir = get_dir();
	document.all["bgs"].src = dir+"images/msg.wav";
	var html = "<img src=\""+dir+"images/newmail.gif\" style=\"cursor:hand\" onclick=\"javascript:show_msglist();\" alt=\"打开消息列表\"/><a href=\"#\"  style=\"font-size:12px;color:red\" onclick=\"javascript:show_msglist();\">有新消息</a>";
	document.all["td_control"].innerHTML = html;
}
function close_alert()
{
	//关闭提醒
	//输入:无
	//输出:无
	var dir = get_dir();
	var html = "<a href=\"#\"  style=\"font-size:12px;color:red\" onclick=\"javascript:show_msglist();\">消息列表</a>";
	document.all["td_control"].innerHTML = html;
}
function pump()
{
	//心跳
	//输入:无
	//输出:无
	//show_msglist();
	get_client().request_broadcast();
	//下载新广播
}
function send()
{
	//发送消息
	//输入:无
	//输出:无
	//return alert("功能未完成!");
	var msg = document.all["txt_msg"].value;
	if("" == msg)
		return alert("请输入要发送的消息");
	document.all["txt_msg"].value = "";
	var roomid = (get_client().base_id());
	var userid = String(get_client().get_id());
	get_client().show_msg(userid+":"+msg+"\n");
	
	get_client().obj_msg_tmp.init_default();	
	get_client().obj_msg_tmp.set_type("chat_msg");
	get_client().obj_msg_tmp.set_content(msg);
	get_client().obj_msg_tmp.set_uid(userid);
	get_client().obj_msg_tmp.set_roomid(roomid);
	//alert(get_client().obj_msg_tmp.query_msg());
	//push_message(this.obj_msg_tmp.query_msg());
	var msg = get_client().obj_msg_tmp.query_msg();
	//alert(msg);
	g_commu.post_msg(msg,1);
	
}
function login()
{
	//登录
	//输入:无
	//输出:无
	//alert("登录");
	//	vec.push_back("login-|--|-200200067`|-|-400400007609-|-local");
	//var msg = ""; //"login-|--|-200200068`|-|-400400007609-|-local";
	var roomid = (get_client().base_id());
	var userid = String(get_client().get_id());
	get_client().obj_msg_tmp.init_default();	
	get_client().obj_msg_tmp.set_type("login");
	get_client().obj_msg_tmp.set_content("");
	get_client().obj_msg_tmp.set_uid(userid);
	get_client().obj_msg_tmp.set_roomid(roomid);
	//alert(get_client().obj_msg_tmp.query_msg());
	//push_message(this.obj_msg_tmp.query_msg());
	var msg = get_client().obj_msg_tmp.query_msg();
	//alert(msg);
	g_commu.post_msg(msg,1);
}
function post_msg_fast_response()
{
	//应答
	//输入:无
	//输出:无
	g_commu.post_msg_fast_response();
}
function get_client()
{
	return eval(g_client);
	//return g_client;
}
//--------------------心跳机---------------------
//--------------定时器---------
function c_interval()
{
	//定时器
	//输入：第一项是执行函数字符串，第二项是定时间隔单位毫秒
	//输出：无
	public:
		this.run = function(){ 
			//chatok("aaa:"+this.str_exec+"\n");
			this.stop();
			this.time_id = window.setInterval(this.str_exec,this.int_timeout);
		}
		this.stop = function(){ 
			try{
				window.clearInterval(this.time_id);
				//chatok("停止定时器成功："+this.time_id);
			}
			catch(err){
				chatok("停止定时器失败："+this.time_id);
			}
		}
		this.set_exec = function(){ 
			this.save_last();
			this.str_exec = arguments[0];
		}
		this.set_out = function(){ this.int_timeout = parseInt(arguments[0]);}
	private:
		this.str_exec = "";  //定时触发的函数
		this.int_timeout = 300000;  //定时间隔，单位毫秒
		this.time_id = null;
		this.str_exec_last = this.str_exec;  //上一个定时触发函数
		this.int_timeout_last = this.int_timeout; //上一个定时间隔
	//---------------------------
	if(("" != arguments[0]) && ("undefined" != typeof(arguments[0])))
		this.str_exec = (arguments[0]);	
	if(("" != arguments[1]) && ("undefined" != typeof(arguments[1])))
		this.int_timeout = parseInt(arguments[1],10);
	//chatok(this.str_exec+":"+this.int_timeout);
}
//-----------------end 心跳机--------------------


//--------------------通讯器---------------------
//-----------使用说明----------
//定义一个名为"post_msg_fast_response"的函数,收到的消息会调用这个函数
//---------------------远程消息类-----------------------
function c_server_msg()
{
	//负责与服务器通信
public:
	//can_send(); //能否发送消息
	//post_msg(msg); //发送消息　
	//set_fast_url(url); //快速服务器地址
private:
	//默认命令接收地址
	this.str_cmd_url = "./server.php";   
	//快速服务器命令接收地址
	this.str_fast_url = "http://mwjxhome.3322.org:8099/gm_s";
	//this.str_fast_url = "http://localhost:8099/gm_s";
	this.xmlhttp  =  this.new_xmlhttp();
	this.xml_dom = this.new_xmldom();  //接收
	//this.s_fastReady = "post_msg_fast_response";  //快速发送接收函数
	return true;
}
function c_server_msg.prototype.set_fast_url(url)
{
	//快速服务器地址
	//输入:url是地址字符串
	//输出:无
	this.str_fast_url = url;
}
function c_server_msg.prototype.new_xmldom()
{
	//返回DOMDocument对象
	//输入：无
	//正常返回dom对象，异常返回false
	var obj_dom = null;
	//throw "No DOM DOcument found on your computer.";
	var arr_activex = ["MSXML.DOMDocument","MSXML4.DOMDocument", "MSXML3.DOMDocument", "MSXML2.DOMDocument", "Microsoft.XmlDom"];
	for(var i=0; i < arr_activex.length; i++){
		try{
			obj_dom = new ActiveXObject(arr_activex[i]);
			return obj_dom;
		}
		catch(err){
			obj_dom = null;
		}
	}
	throw(new Error(-1,'No DOM DOcument found on your computer.'));
	return false;
}
function c_server_msg.prototype.new_xmlhttp()
{
	//新建一个xmlhttp返回
	//输入：无
	//输出：正常返回xmlhttp对象，异常返回false
	var obj_xmlhttp = null;
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
	throw(new c_err('Cant Create XMLHTTP'));
	return false;
}
function c_server_msg.prototype.can_send()
{
	//是否可以发送数据
	//输入:无
	//输出:true可以发数据,false不能发数据
	//0 Object is not initialized with data. 
	//1 Object is loading its data. 
	//2 Object has finished loading its data. 
	//3 User can interact with the object even though it is not fully loaded. 
	//4 Object is completely initialized. 
	if(0 == this.xmlhttp.readyState || 2 == this.xmlhttp.readyState || 4 == this.xmlhttp.readyState)
		return true;
	return false;
}
function c_server_msg.prototype.post_msg(msg,server)
{
	//向服务器发送事件消息,异步方式
	//输入：msg是要发送的消息字符串,server指明发往哪个服务器1/2(快速/慢速)
	//输出：true,false
	if("undefined" == typeof(server))
		throw(new c_err("connumication.js"));
	if("" == msg || null == msg || ("undefined" == typeof(msg)))
		throw(new c_err("communication.js"));
	if(this.xmlhttp == null)
		throw(new c_err("communication.js"));
	if(!this.can_send())
		return false;
	var url = ""; //消息ID不惟一可防止缓存,消息ID重复以后呢,要在服务端设缓存超时
	if(1 == server)
		url = this.str_fast_url;
	else if(2 == server)
		url = this.str_cmd_url;
	else
		throw(new c_err("communication.js"));
	url += ("?"+msg);
	//if(-1 != url.indexOf("chat_msg"))
	//	alert(url);
	try{
		this.xmlhttp.Open("GET",url,true);
		this.xmlhttp.Send(null);
		this.xmlhttp.onreadystatechange = post_msg_fast_response;
		//chatok("post_msg,time="+Date()+"\n");
		return true;
	}
	catch(err){
		//alert("失败:"+err.message);
		return false;
	}
}
function c_server_msg.prototype.post_msg_fast_response()
{
	//将服务器的应答信息放入接收队列
	//输入：无
	//输出：无
	if(4 != this.xmlhttp.readyState)
		return;
	if(this.xmlhttp.status != 200)
		return;
	try{
		if("" == this.xmlhttp.responseText || null == this.xmlhttp.responseText || ("undifined" == typeof(this.xmlhttp.responseText)))
			return;
		//alert(this.xmlhttp.responseText);
		
		if(!get_client().obj_msg_tmp.load_msg_str(this.xmlhttp.responseText))
			return; //消息格式无效,直接删除该消息
		//alert("aaa");
		get_client().obj_msg_tmp.set_other_local("server"); //设置为远程消息
		var sMsg = get_client().obj_msg_tmp.query_msg();
		if(false != sMsg){
			//alert(sMsg);
			get_client().deal_msg();
			//if(-1 != sMsg.indexOf("down_data"))
			//	alert("re:"+sMsg);
			//push_message(sMsg);
			//g_request_broadcast(); //有新消息,极有可能紧跟着另一个新消息  
		}
		/**/
		return;
	}
	catch(err){
		//chatok("应答有问题:"+err.message+"\n");
		return;
	}
	//responseText:返回文本格式
	//responseXML:返回xml格式
	//其它还有
	//responseBody
	//responseStream等
}

//------------------end 通讯器-------------------

//--------------------消息处理器-----------------
//--------------新版消息处理机-----------
function msg_deal_machine()
{
	//消息处理机
public:
	//deal_msg(); //处理客户端临时消息
	return true;
}
function msg_deal_machine.prototype.deal_msg()
{
	//处理客户端临时消息对象
	//输入：无
	//输出：true消息已经处理过(可以删除),false消息没有处理
	//if("img_loaded" == get_client().obj_msg_tmp.get_type())
	//	alert("amachine:img_loaded,"+get_client().base+"\n");
	var local_uid = get_client().get_user_id();
	if(get_client().obj_msg_tmp.is_server() && (local_uid == get_client().obj_msg_tmp.get_poster_id())){
		return true; //本地发出的消息再次从服务器收到，不再处理
	}	
	var s_cmd = get_client().obj_msg_tmp.get_cmd();

	if(null != get_current_room()){ //先交给房间实体处理
		//if("img_loaded" == s_cmd)
		//	alert("aaa\n");
		if(get_current_room().deal_msg(s_cmd))
			return true; //当前房间已处理	
	}
	//if("img_loaded" == s_cmd)
	//	alert("aaa\n");
	return get_client().deal_msg(s_cmd);
}

//-----------------end 消息处理器----------------

//-----------------客户端------------------------
function c_client()
{
	//客户端对象
	//输入:无
	//输出:无
//public:
	this.obj_msg_tmp = new c_event_msg;  //临时消息对象
	//deal_msg(); //消息处理
	//get_id(); //用户ID
	//base_id(); //房间ID
	//request_broadcast(); //下载广播
	//show_msg(); //显示消息
//private:
	this.id = -1; //用户ID
	this.pswd = ""; //密码
	this.str_gs = ""; //下载广播消息
//初始
	var id_tmp = get_cookie("fc_uniqid");
	id_tmp = null;
	if(null == id_tmp){ //种植ID
		id_tmp = String(Math.round(Math.random() * 2147483647));
		SetCookie("fc_uniqid",id_tmp);
	}
	var int_id = parseInt(id_tmp,10);
	if(int_id < 1)
		return;
	this.id = int_id;
	//广播消息
	this.obj_msg_tmp.init_default();	
	this.obj_msg_tmp.set_type("gs");
	this.obj_msg_tmp.set_content("");
	this.obj_msg_tmp.set_roomid(this.base_id());
	this.obj_msg_tmp.set_uid(String(this.get_id()));
	this.obj_msg_tmp.set_other_local("local");	
	this.str_gs = this.obj_msg_tmp.query_msg();
	//alert(this.str_gs);
}
function c_client.prototype.base_id()
{
	//房间ID
	//输入:无
	//输出:整形
	return 123;
}
function c_client.prototype.get_id()
{
	//用户ID
	//输入:无
	//输出:整形
	return this.id;
}
function c_client.prototype.deal_msg()
{
	//消息处理
	//输入:无
	//输出:无
	var s_cmd = this.obj_msg_tmp.get_cmd();
	switch(s_cmd){
		case "login": //登录成功
			//break;
			//alert("登录成功");
			var sid = this.obj_msg_tmp.get_content();
			if(this.id != parseInt(sid,10))
				break;
			//开始心跳
			//alert("画界面");
			main_start(); //世界开始
			break;
		case "chat_msg": //聊天消息
			//alert("接受到的消息");
			var msg = unescape(this.obj_msg_tmp.get_content());
			var poster = this.obj_msg_tmp.get_poster_id();
			if(this.id == parseInt(poster))
				break; //自己的不处理
			//obj.value = (poster+":"+msg+"\n"+obj.value);
			this.show_msg(poster+":"+msg+"\n");
			alert_msg(); //提示新消息
			break;
		default:
			break;
	}
}
function c_client.prototype.request_broadcast()
{
	//向服务器请求广播
	//输入：无
	//输出：true,false
	//var msg = "gs-|--|-200200067`|-|-400400003846-|-local";
	//alert(this.str_gs);
	g_commu.post_msg(this.str_gs,1);
	return true;
}
function c_client.prototype.show_msg(s)
{
	//显示消息
	//输入:s(string)消息
	//输出:无
	var obj = document.all["txt_msglist"];
	obj.value = (s+obj.value);
}

//---------------end  客户端---------------------


//----------------------事件消息类-----------------------------
//消息示例
//gs-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //取广播
//chat_msg-|-hello-|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local//聊天
//login-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //登录
//logout-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //下线
//inroom-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //进入房间
//outroom-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //离开房间
//向服务器请求用户名
//request_up_name-|-200200067-|-123-|-123-|-local 
//up_name-|-200200067`|小鱼-|-sys-|-123-|-server //更新用户名
//消息名,消息参数,消息发送者信息,消息发送者位置,其他信息
function c_event_msg(msg)
{
public:
	//c_event_msg
	//set_default(id,pswd);
	//init_default
	//query_msg
	//load_msg_str
	//set_receiver(); //设置接收者
	//set_type
	//set_content
	//set_roomid
	//set_other_local
	//set_uid
	//set_upswd
	//clear_poster(); 
	//get_poster_id();
	//get_roomid();
	//get_content();
	//get_receiver(); //接收者
private:
	//客户端及服务器所有动作都依据此事件消息类运行
	this.str_msg = "";  //整个消息字符串形式
	this.int_count = 5;  //消息分成几部分(主要部份)
	//事件类型,即时客户端此字段只有一个值表示动作类型，非即时模式时
	//，此字段有两个值，用分隔符分开，分别是远程类名和类的方法
	this.str_type = "";  
	this.str_content = "";  //事件内容

	//this.str_poster = "";  //发送人,id和密码
	this.s_uid = ""; //消息发送者ID
	this.s_upswd = ""; //消息发送者密码
	this.s_receiver = ""; //消息接收者ID
	
	this.int_roomid = "";  //房间号(频道)
	
	//this.str_other = "";   //附加信息local/server/unsend`|随机数防缓存
	this.other_local = ""; //消息位置local/server/unsend
	this.other_num = ""; //随机数防缓存(客户端消息ID)

	this.df_uid = "";  //缺省消息发送者ID
	this.df_upswd = ""; //缺省消息发送者密码
	this.to_server = 1; //发往那种服务器1/2(快速/慢速)
//public:
	this.get_msg_count = function(){ return this.int_count;}
	this.get_msg = function(){ return this.str_msg;}
	this.get_type = function(){ return this.str_type;}
	this.get_cmd = function(){ return this.str_type;}
	this.get_content = function(){ return this.str_content;}
	this.get_receiver = function(){ return this.s_receiver;}
	//this.get_poster = function(){ return this.str_poster;}
	this.get_roomid = function(){ return this.int_roomid;}
	//this.get_other = function(){ return this.str_other;}	

	//set_receiver(); //设置接收者
	this.set_receiver = function(str){ this.s_receiver = str;}
	this.set_type = function(info){ this.str_type = info;}
	this.set_content = function(info){ this.str_content = info;}
	this.set_poster = function(info){ this.str_poster = info;}
	this.set_roomid = function(info){ this.int_roomid = info;}
	this.set_room_id = function(){ return this.set_roomid(arguments[0]);}
	this.set_other = function(info){ throw(new c_err("msg.js"));} //废弃

	this.set_uid = function(str){ this.s_uid = str;}
	this.set_upswd = function(str){ this.s_upswd = str;}

	//------------start ---------
	if("" != msg && "string" == typeof(msg))
		return this.init(msg);
	return false;
}
function c_event_msg.prototype.clear_poster()
{
	this.s_uid = ""; //消息发送者ID
	this.s_upswd = ""; //消息发送者密码
	this.s_receiver = ""; //消息接收者ID
}
function c_event_msg.prototype.init(msg)
{
	this.load_msg_str(msg);
}
function c_event_msg.prototype.load_msg_str(msg)
{
	//初始化
	//msg是字符串，包含整个事件消息的信息
	//正常返回true,异常返回false
	if("" == msg || "string" != typeof(msg))
		return false;
	var arr_msg = msg.split(this.get_split_key());
	if(arr_msg.length != this.get_msg_count())
		return false;
	this.str_msg = msg;
	this.str_type = arr_msg[0];
	this.str_content = arr_msg[1];
	
	var key2 = this.get_split_key(2);	
	var arr = arr_msg[2].split(key2);
	this.s_uid = arr[0];
	if("undefined" != typeof(arr[1]))
		this.s_upswd = arr[1];
	if("undefined" != typeof(arr[2]))
		this.s_receiver = arr[2];
	
	this.int_roomid = arr_msg[3];

	var arr2 = arr_msg[4].split(key2);	
	this.other_local = arr2[0];
	if("undefined" != typeof(arr2[1]))
		this.other_num = arr2[1];
	return true;
}
function c_event_msg.prototype.set_default(id,pswd)
{
	//设置消息缺省值
	//输入:id消息发送者ID，pswd消息发送者密码
	//输出:无
	this.df_uid = id;  //缺省消息发送者ID
	this.df_upswd = pswd; //缺省消息发送者密码
}
function c_event_msg.prototype.init_default(roomid)
{
	//初始化缺省值,正常返回true,异常返回false
	//输入:roomid用户当前房间ID
	//输出:true,false
	this.str_type = "";  
	this.str_content = "";  //事件内容
	
	this.set_uid(this.df_uid);
	this.set_upswd(this.df_upswd);
	this.s_receiver = ""; //消息接收者ID
	if("undefined" != typeof(roomid))
		this.set_roomid(roomid);
	this.set_other_local("local");
	this.other_num = ""; //消息编号
	return true;
}
function c_event_msg.prototype.query_msg()
{
	//根据消息各个部分生成完整消息
	//正常返回消息，异常返回false
	var key = this.get_split_key();
	//this.get_content() 可以为空
	if(this.get_type() != "" &&  this.get_poster() != "" && this.get_roomid() != "" && this.get_other() != ""){
		return this.get_type()+key+this.get_content()+key+this.get_poster()+key+this.get_roomid()+key+this.get_other();
	}
	return false;
}
function c_event_msg.prototype.get_split_key(flag)
{
	//return get_split_key(flag);
	
	//返回分隔符
	var result = "-|-";
	switch(flag){
		case 2:  //第二层分隔符
			result = "`|";
			break;
		case 3:  //第三层
			result = "|`";
			break;
		case 4:  //第四层
			result = ",";	
			break;
		default:
			break;
	}
	return result;
	/**/
}
function c_event_msg.prototype.get_poster()
{
	var key = this.get_split_key(2);
	return this.s_uid+key+this.s_upswd+key+this.s_receiver;
}
function c_event_msg.prototype.get_other()
{
	var key = this.get_split_key(2);
	return this.other_local+key+this.other_num;
}
function c_event_msg.prototype.query_poster_arr()
{
	//拆分str_poster
	//返回一组数组，异常返回false
	var str_poster = this.get_poster();
	if(str_poster == null)
		return false;
	var arr_poster = str_poster.split(this.get_split_key(2));
	if(arr_poster.length < 1)
		return false;
	return arr_poster;
}
function c_event_msg.prototype.query_content_arr()
{
	//拆分str_content
	//返回一组数组，异常返回false
	//var  = this.str_content;
	if((this.str_content == null) || ("" == this.str_content))
		return false;
	var arr = this.str_content.split(this.get_split_key(2));
	if(arr.length < 1)
		return false;
	return arr;
}
function c_event_msg.prototype.get_content_first()
{
	//返回str_content分隔符的第一项
	//输入：无
	//输出：第一项字符串，不存在第一项返回false
	var arr = this.query_content_arr();
	if(false == arr)
		return false;
	return arr[0];
}
function c_event_msg.prototype.get_content_second()
{
	//返回str_content分隔符的第二项
	//输入：无
	//输出：第二项字符串，不存在第二项返回false
	var arr = this.query_content_arr();
	if(false == arr)
		return false;
	if((null == arr[1]) || ("undefined" == typeof(arr[1])))
		return false;
	return arr[1];
}

function c_event_msg.prototype.get_poster_id()
{
	return this.s_uid;
}
function c_event_msg.prototype.check_local()
{
	return this.is_local();
}
function c_event_msg.prototype.is_unsend()
{
	var local = this.get_local();
	if(local == "unsend")
		return true;
	return false;
}
function c_event_msg.prototype.is_local()
{
	//查询消息是否本地消息，是返回true,否则返回false
	var local = this.get_local();
	if(local == "local")
		return true;
	return false;
}
function c_event_msg.prototype.is_server()
{
	//查询消息是否远程消息，是返回true,否则返回false
	var local = this.get_local();
	if(local == "server")
		return true;
	return false;
}
function c_event_msg.prototype.get_local()
{
	//返回消息原发地,server/local
	//输入:无
	//输出:server/local的字符串,异常返回false
	return this.other_local;
}
function c_event_msg.prototype.set_msg_id(id)
{
	//设置消息编号
	//输入:消息编号,整形
	//输出:无
	if("number" != typeof(id))
		return;
	this.other_num = String(id);
}
function c_event_msg.prototype.get_msg_id()
{
	//返回消息编号
	//输入:无
	//输出:消息编号字符串
	return this.other_num;
}
function c_event_msg.prototype.set_other_local(str)
{
	//设置消息的位置，
	//输入：位置字符串，local或server
	//输出：无
	if("string" != typeof(str))
		return;
	this.other_local = str;	
}
function c_event_msg.prototype.set_poster_id(str)
{
	//设置发送人ID
	//输入：str用户ID
	//输出：无
	if("undefined" != typeof(str))
		this.s_uid = str;
}
function c_event_msg.prototype.set_poster_pswd(str)
{
	//设置发送人密码
	//输入：密码字符串
	//输出：无
	if("undefined" != typeof(str))
		this.s_upswd = str;
}
//-----------end c_event_msg----------------------------------

//---------------------队列对象容器---------------------
function queue()
{
	//队列
	//输入：无
	//输出：无
	public:
		this.push = function(){
			//chatok("eee:"+arguments[0]+"\n");
			this.list[this.count ++] = arguments[0];
		}
		this.pop = function(){
			-- this.count;
			var i = 0;
			for(i; i < this.count;i++){
				this.list[i] = this.list[(i + 1)];
			}			
			this.list.length = this.count;
		}
		this.front = function(){
			return this.list[0];
		}
		this.empty = function(){
			return (0 == this.count)?true:false;
		}
		
	private:
		this.list = Array();
		this.count = 0;  //元素计数器
}
function queue.prototype.print_me()
{
	var i = 0;
	for(i in this.list){
		chatok(this.count+":"+i+":"+this.list[i]+"\n");
	}
}
function queue.prototype.str_list()
{
	var i = 0;
	var str = "";
	for(i in this.list)
		str += (this.count+":"+i+":"+this.list[i]+"\n");
	return str;
}


function c_msg_queue()
{
	//消息队列管理器
public:
	//push(); //压入消息	
	//process(); //处理消息
	//confirm_msg(id); //消息收到确认　
	//__c_msg_queue(); //析构函数
	//stats(); //状态	
private:
	//count_confirm(); //等待确认的消息数
	//msg_server(); //客户端临时消息对象被发往哪种服务器(快速/慢速)
	//hava_new(); //是否有新消息
	//get_new(); //新消息中最旧的一个
	//pop(); //弹出最旧的消息
	//process_confirm
	//get_uniqueid(); //取得消息编号
	//confirm_msg(id); //根据消息ID取等待确认的消息
	this.server_msg = null; //通讯器
	this.queue_msg = new queue; //队列
	this.iMsgUniqueId = 1; //消息惟一编号,1-10000之间循环
	this.msg_random = parseInt(Math.random()*9999); //加在消息ID上的随机数
	this.vec_confirm = null; //等待收到确认的消息队列
	this.timeout = 0; //确认队列超时计数器	
	//--------------
}
function c_msg_queue.prototype.init_server_msg()
{
	//构造通讯器
	//输入:无
	//输出:无
	//var url = "http://mwjxhome.3322.org:8088/gm_s";
	//var url = "http://www.mwjx.com:8088/gm_s";
	var url = "http://localhost:8088/gm_s";
	if("localhost" != document.domain)
		url = ("http://"+document.domain+":8088/gm_s"); 
	this.server_msg = new c_server_msg(); //初始化通讯器
	this.server_msg.set_fast_url(url);
	this.vec_confirm = new vector; //("c_event_msg")
}
function c_msg_queue.prototype.stats()
{
	//状态
	//输入:无
	//输出:字符串
	var str = "";
	var num = this.count_confirm();
	str += ("等待服务器确认的消息数:"+String(num)+"\n");
	if(num < 1)
		return str;
	var obj_it = new iterator(this.vec_confirm.begin());
	var it_end = new iterator(this.vec_confirm.end());
	while(obj_it.get_index() != it_end.get_index()){
		str += (this.vec_confirm.obj(obj_it)+"\n");
		obj_it.next(); //下一个
	}	
	return str;
}
function c_msg_queue.prototype.count_confirm()
{
	//等待确认的消息数
	//输入:无
	//输出:消息数整形
	if(null == this.vec_confirm)
		return 0;
	return this.vec_confirm.size();
}
function c_msg_queue.prototype.process_confirm()
{
	//检查确认队列消息是否要重发或删除超时消息
	//输入:无
	//输出:无
	if(null == this.vec_confirm)
		return;
	if(this.vec_confirm.empty())
		return;
	if(this.vec_confirm.empty() && (0 != this.vec_confirm.size()))
		throw(new c_err("msg_queue.js"));
	if(this.timeout++ < 400)
		return; //400*30毫秒=12秒超时
	//重发超时的消息,第一条
	var obj_it = new iterator(this.vec_confirm.begin());
	var msg = this.vec_confirm.obj(obj_it);
	this.vec_confirm.erase(obj_it); //删除元素
	this.queue_msg.push(msg); //直接放进队列,不改变消息编号	
	this.timeout = 0;
}
function c_msg_queue.prototype.confirm_msg(id)
{
	//根据消息ID取等待确认的消息
	//输入:id是消息ID字符串
	//输出:有消息返回消息字符串(删除该消息),否则返回空字符串
	if(null == this.vec_confirm)
		return "";
	if(this.vec_confirm.empty())
		return "";
	var obj = new c_event_msg;
	var obj_it = new iterator(this.vec_confirm.begin());
	var it_end = new iterator(this.vec_confirm.end());
	while(obj_it.get_index() != it_end.get_index()){
		obj.load_msg_str(this.vec_confirm.obj(obj_it));
		if(id == obj.get_msg_id()){
			var str = obj.query_msg(); 
			this.vec_confirm.erase(obj_it); //删除元素
			return str;
		}
		obj_it.next();
	}	
	return "";
}
function c_msg_queue.prototype.process()
{
	//处理消息,本地发送后处理,其他直接处理
	//输入:无
	//输出:无
	//没有新消息,直接返回
	this.process_confirm(); //确认队列是否有确认超时
	if(!this.hava_new())
		return; //没有新消息
	var sMsg =	this.get_new();
	if(!get_client().obj_msg_tmp.load_msg_str(sMsg)){
		this.pop(); 
		return; //消息格式无效,直接删除该消息
	}
	//if("chat_msg" == get_client().obj_msg_tmp.get_cmd())
	//	alert(sMsg);
	//新消息需要发送,发送,放入确认队列等待确认,
	//发送失败直接返回,成功删除消息返回	
	if(get_client().obj_msg_tmp.is_local()){ //本地消息
		if(null == this.server_msg)
			throw(new c_err("msg_queue.js"));
		if(!this.server_msg.can_send())
			return;		
		var to_server = this.msg_server();
		if(this.server_msg.post_msg(sMsg,to_server)){ //发送成功
			//if(-1 != sMsg.indexOf("down_data"))
			//	alert(sMsg);
			this.pop(); 
			if(!this.confirm_require()) //不需确认
				return get_msg_deal().deal_msg(); //直接运行
			this.vec_confirm.push_back(sMsg); //放到等待确认集合中
		} 
		return; //发送失败,下次重试
	}	
	//不要发送的消息直接交处理机处理(server/unsend)
	//处理完成后删除消息	
	//非发送消息,远程消息
	var id = get_client().obj_msg_tmp.get_msg_id();
	//处理已经确认的消息
	var str_confirm = this.confirm_msg(id);
	if("" != str_confirm){
		if(get_client().obj_msg_tmp.load_msg_str(str_confirm))
			get_msg_deal().deal_msg();	
		//处理远程消息
		if(get_client().obj_msg_tmp.load_msg_str(sMsg)){
			if(get_msg_deal().deal_msg())
				this.pop();
		}
		return;
	}	
	//处理远程消息或unsend消息
	//if("img_loaded" == get_client().obj_msg_tmp.get_type())
	//	alert(get_client().obj_msg_tmp.get_type());
	if(get_msg_deal().deal_msg())
		this.pop();	
}
function c_msg_queue.prototype.msg_server()
{
	//客户端临时消息对象被发往哪种服务器
	//输入:无
	//输出:1/2(快速/慢速)整形
	switch(get_client().obj_msg_tmp.get_cmd()){
		case "countrybase`|bs_login":
			return 2;
		case "request_up_name":
			return 2;
		default:
			return 1;
	}
	return 1;
}
function c_msg_queue.prototype.confirm_require()
{
	//当前客户端临时消息是否需要确认回复
	//输入:无
	//输出:true需要确认,false不需要
	if("gs" == get_client().obj_msg_tmp.get_cmd())
		return false; //目前只有这种消息不需确认
	return true;
}
function c_msg_queue.prototype.hava_new()
{
	//是否有新消息
	//输入:无
	//输出:有新消息返回true,否则返回false
	return (this.queue_msg.empty())?false:true;
}
function c_msg_queue.prototype.get_new(){ return this.queue_msg.front();}
function c_msg_queue.prototype.pop(){ return this.queue_msg.pop();}
function c_msg_queue.prototype.push(msg)
{
	//向客户端消息队列压入一条消息
	//输入:msg是消息字符串
	//输出:无
	if("string" != typeof(msg))
		return;
	//给需要确认的消息加上惟一编号,这个编号只是对每个客户端在一定时间内惟一
	var obj_msg = new c_event_msg(msg);
	if(!obj_msg.is_local())
	   return this.queue_msg.push(msg); //本地消息,加编号
	obj_msg.set_msg_id(this.get_uniqueid());
	//alert(obj_msg.query_msg());
	this.queue_msg.push(obj_msg.query_msg());
}
function c_msg_queue.prototype.driver_id()
{
	//操作者ID
	if(null == g_driver())
		return 123;
	return g_driver().get_id();
}
function c_msg_queue.prototype.get_uniqueid()
{
	//取得消息编号,当前操作者ID加编号
	//输入:无
	//输出:编号字符串
	if(this.iMsgUniqueId > 10000)
		this.iMsgUniqueId = 1;
	//用户ID取十万位,万位,十位,个位组成ID值
	//ID值加3位随机数,再加消息序号形成最终编号
	var id = 123;
	if(null != g_driver())
		id = g_driver().get_id();//200200067
	var u1 = id%1000;
	var u2 = (id%1000000-u1)/1000;
	var msgid = u2+u1;
	if(msgid < 0)
		throw(new c_err("msg_queue.js"));
	msgid += this.msg_random;
	msgid += this.iMsgUniqueId++;
	return msgid;
}
function c_msg_queue.prototype.__c_msg_queue()
{
	//析构函数
	//输入:无
	//输出:无
	chatok("msg_queue.js,c_msg_queue,__c_msg_queue,析构\n");
}


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
	//alert(argv);
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path    = (argc > 3) ? argv[3] : null;
	var domain  = (argc > 4) ? argv[4] : null;
	var secure  = (argc > 5) ? argv[5] : false;
	//domain = "mwjxhome.3322.org";
	document.cookie = name + "=" + escape (value) + ((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + ((path == null) ? "" : ("; path=" + path)) + ((domain == null)  ? "" : ("; domain=" + domain)) + ((secure == true)  ? "; secure" : "");
	return true;
}
//------------------end cookie-----------