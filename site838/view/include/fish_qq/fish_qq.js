//------------------------------
//create time:
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:
//------------------------------
//--------ȫ�ֶ���-------
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
var g_interval = new c_interval("pump()",3000); //������
var g_commu = new c_server_msg(); //ͨѶ��
g_commu.set_fast_url(g_str_fast_url);
var g_client = new c_client(); //�ͻ���
var g_msg_machine = new msg_deal_machine(); //��Ϣ�����
var g_started = false; //�Ƿ�ʼ��־
//-------endȫ�ֶ���-----
document.write(main_html());
login();



//main_start(); //���翪ʼ
function main_start()
{
	//���翪ʼ
	//����:��
	//���:��
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
	//������html����
	//����:��
	//���:html�ַ���
	var dir = get_dir();
	var html_bgs = "<BGSOUND id=bgs loop=1 autostart=false src=\"\"/>";
	var html = html_bgs+"<table width=\"100%\" height=\"30\" border=\"0\" style=\"background-color: red;BACKGROUND: url("+dir+"images/nv_bg.gif) repeat-x bottom;HEIGHT: 30px;\">";
	html += "<tr><td width=\"19%\"><img src=\""+dir+"images/nv_home.gif\"/><a href=\"/index.html\" target=\"_blank\" style=\"font-size:12px;\">��ҳ</a>&nbsp;<img src=\""+dir+"images/nv_myhome.gif\"/><a href=\"/index.html\" target=\"_blank\" style=\"font-size:12px;\">��¼</a></td>";
	html += "<td width=\"1%\"><img src=\""+dir+"images/nv_tiao.gif\"/></td>";

	html += "<td width=\"59%\"><input id=\"txt_msg\" type=\"text\" value=\"\" size=\"60\" onkeydown=\"javascript:if(13 == event.keyCode){send();}\"/>&nbsp;<input type=\"button\" value=\"����\" onclick=\"javascript:send();\"/></td><td width=\"1%\"><img src=\""+dir+"images/nv_tiao.gif\"/></td>";

	html += "<td width=\"19%\" id=\"td_control\"><a href=\"#\"  style=\"font-size:12px;color:red\" onclick=\"javascript:show_msglist();\">��Ϣ�б�</a></td><td width=\"1%\"><img src=\""+dir+"images/nv_tiao.gif\"/></td>";

	html += "</tr>";

	html += "</table>";
	html += "<table width=\"100%\" height=\"206\" id=\"tbl_msglist\" style=\"display:none;\"> <tr><td>";
	html += html_msglist();
	html += "</td></tr></table>";
	return html;
}
function html_msglist()
{
	//��Ϣ�б�������
	//����:��
	//���:html�ַ���
	var dir = get_dir();	
	var html = "";
	//html += "<IFRAME frameBorder=0 id=\"ifm_msglist\" scrolling=\"?\" src=\"/mwjx/include/fish_qq/msglist.html\" style=\"HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1\"></IFRAME>";
	
	html += "<table width=\"300\" height=\"206\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"   style=\"display:block;left:250px;top:30px;position:absolute;\">";
	html += "<tr><td id=\"td_msglist\" align=\"left\" valign=\"top\" style=\"BACKGROUND: url("+dir+"images/bg1.jpg) no-repeat top left;font-size:12px;padding-left:10px;\"><TEXTAREA id=\"txt_msglist\" style=\"border:0px;color:#971A4B; background-image:url("+dir+"images/bg1.jpg) no-repeat top left;font:bold 12pt;height:200px;width:270px\"></TEXTAREA> ";
	html += "<img style='cursor:hand;position:absolute;left:285px;top:5px;display:block' src=\""+dir+"images/cha.gif\" onclick=\"javascript:hide_msglist();\" alt=\"�ر���Ϣ�б�\"/>";
	html += "</td></tr>";
	html += "</table>";
	/**/
	return html;
}
function hide_msglist()
{
	//�ر���Ϣ�б�
	//����:��
	//���:��
	//alert("aa");
	//parent.document.all.ifm_fish_qq.style.height = "30px";
	//parent.height_ifmqq("30px");
	window.clipboardData.setData('text',"hide_msglist"); //֪ͨ����
	document.all["tbl_msglist"].style.display = "none";
	//document.all["ifm_msglist"].style.display = "none";

}
function show_msglist()
{
	//��ʾ��Ϣ�б�
	//����:��
	//���:��
	//parent.document.all.ifm_fish_qq.style.height = "240px";
	//return alert("240px");
	//parent.height_ifmqq("240px");
	window.clipboardData.setData('text',"show_msglist"); //֪ͨ����
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
	//����������Ϣ
	//����:��
	//���:��
	var dir = get_dir();
	document.all["bgs"].src = dir+"images/msg.wav";
	var html = "<img src=\""+dir+"images/newmail.gif\" style=\"cursor:hand\" onclick=\"javascript:show_msglist();\" alt=\"����Ϣ�б�\"/><a href=\"#\"  style=\"font-size:12px;color:red\" onclick=\"javascript:show_msglist();\">������Ϣ</a>";
	document.all["td_control"].innerHTML = html;
}
function close_alert()
{
	//�ر�����
	//����:��
	//���:��
	var dir = get_dir();
	var html = "<a href=\"#\"  style=\"font-size:12px;color:red\" onclick=\"javascript:show_msglist();\">��Ϣ�б�</a>";
	document.all["td_control"].innerHTML = html;
}
function pump()
{
	//����
	//����:��
	//���:��
	//show_msglist();
	get_client().request_broadcast();
	//�����¹㲥
}
function send()
{
	//������Ϣ
	//����:��
	//���:��
	//return alert("����δ���!");
	var msg = document.all["txt_msg"].value;
	if("" == msg)
		return alert("������Ҫ���͵���Ϣ");
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
	//��¼
	//����:��
	//���:��
	//alert("��¼");
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
	//Ӧ��
	//����:��
	//���:��
	g_commu.post_msg_fast_response();
}
function get_client()
{
	return eval(g_client);
	//return g_client;
}
//--------------------������---------------------
//--------------��ʱ��---------
function c_interval()
{
	//��ʱ��
	//���룺��һ����ִ�к����ַ������ڶ����Ƕ�ʱ�����λ����
	//�������
	public:
		this.run = function(){ 
			//chatok("aaa:"+this.str_exec+"\n");
			this.stop();
			this.time_id = window.setInterval(this.str_exec,this.int_timeout);
		}
		this.stop = function(){ 
			try{
				window.clearInterval(this.time_id);
				//chatok("ֹͣ��ʱ���ɹ���"+this.time_id);
			}
			catch(err){
				chatok("ֹͣ��ʱ��ʧ�ܣ�"+this.time_id);
			}
		}
		this.set_exec = function(){ 
			this.save_last();
			this.str_exec = arguments[0];
		}
		this.set_out = function(){ this.int_timeout = parseInt(arguments[0]);}
	private:
		this.str_exec = "";  //��ʱ�����ĺ���
		this.int_timeout = 300000;  //��ʱ�������λ����
		this.time_id = null;
		this.str_exec_last = this.str_exec;  //��һ����ʱ��������
		this.int_timeout_last = this.int_timeout; //��һ����ʱ���
	//---------------------------
	if(("" != arguments[0]) && ("undefined" != typeof(arguments[0])))
		this.str_exec = (arguments[0]);	
	if(("" != arguments[1]) && ("undefined" != typeof(arguments[1])))
		this.int_timeout = parseInt(arguments[1],10);
	//chatok(this.str_exec+":"+this.int_timeout);
}
//-----------------end ������--------------------


//--------------------ͨѶ��---------------------
//-----------ʹ��˵��----------
//����һ����Ϊ"post_msg_fast_response"�ĺ���,�յ�����Ϣ������������
//---------------------Զ����Ϣ��-----------------------
function c_server_msg()
{
	//�����������ͨ��
public:
	//can_send(); //�ܷ�����Ϣ
	//post_msg(msg); //������Ϣ��
	//set_fast_url(url); //���ٷ�������ַ
private:
	//Ĭ��������յ�ַ
	this.str_cmd_url = "./server.php";   
	//���ٷ�����������յ�ַ
	this.str_fast_url = "http://mwjxhome.3322.org:8099/gm_s";
	//this.str_fast_url = "http://localhost:8099/gm_s";
	this.xmlhttp  =  this.new_xmlhttp();
	this.xml_dom = this.new_xmldom();  //����
	//this.s_fastReady = "post_msg_fast_response";  //���ٷ��ͽ��պ���
	return true;
}
function c_server_msg.prototype.set_fast_url(url)
{
	//���ٷ�������ַ
	//����:url�ǵ�ַ�ַ���
	//���:��
	this.str_fast_url = url;
}
function c_server_msg.prototype.new_xmldom()
{
	//����DOMDocument����
	//���룺��
	//��������dom�����쳣����false
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
	//�½�һ��xmlhttp����
	//���룺��
	//�������������xmlhttp�����쳣����false
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
	//�Ƿ���Է�������
	//����:��
	//���:true���Է�����,false���ܷ�����
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
	//������������¼���Ϣ,�첽��ʽ
	//���룺msg��Ҫ���͵���Ϣ�ַ���,serverָ�������ĸ�������1/2(����/����)
	//�����true,false
	if("undefined" == typeof(server))
		throw(new c_err("connumication.js"));
	if("" == msg || null == msg || ("undefined" == typeof(msg)))
		throw(new c_err("communication.js"));
	if(this.xmlhttp == null)
		throw(new c_err("communication.js"));
	if(!this.can_send())
		return false;
	var url = ""; //��ϢID��Ωһ�ɷ�ֹ����,��ϢID�ظ��Ժ���,Ҫ�ڷ�����軺�泬ʱ
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
		//alert("ʧ��:"+err.message);
		return false;
	}
}
function c_server_msg.prototype.post_msg_fast_response()
{
	//����������Ӧ����Ϣ������ն���
	//���룺��
	//�������
	if(4 != this.xmlhttp.readyState)
		return;
	if(this.xmlhttp.status != 200)
		return;
	try{
		if("" == this.xmlhttp.responseText || null == this.xmlhttp.responseText || ("undifined" == typeof(this.xmlhttp.responseText)))
			return;
		//alert(this.xmlhttp.responseText);
		
		if(!get_client().obj_msg_tmp.load_msg_str(this.xmlhttp.responseText))
			return; //��Ϣ��ʽ��Ч,ֱ��ɾ������Ϣ
		//alert("aaa");
		get_client().obj_msg_tmp.set_other_local("server"); //����ΪԶ����Ϣ
		var sMsg = get_client().obj_msg_tmp.query_msg();
		if(false != sMsg){
			//alert(sMsg);
			get_client().deal_msg();
			//if(-1 != sMsg.indexOf("down_data"))
			//	alert("re:"+sMsg);
			//push_message(sMsg);
			//g_request_broadcast(); //������Ϣ,���п��ܽ�������һ������Ϣ  
		}
		/**/
		return;
	}
	catch(err){
		//chatok("Ӧ��������:"+err.message+"\n");
		return;
	}
	//responseText:�����ı���ʽ
	//responseXML:����xml��ʽ
	//��������
	//responseBody
	//responseStream��
}

//------------------end ͨѶ��-------------------

//--------------------��Ϣ������-----------------
//--------------�°���Ϣ�����-----------
function msg_deal_machine()
{
	//��Ϣ�����
public:
	//deal_msg(); //����ͻ�����ʱ��Ϣ
	return true;
}
function msg_deal_machine.prototype.deal_msg()
{
	//����ͻ�����ʱ��Ϣ����
	//���룺��
	//�����true��Ϣ�Ѿ������(����ɾ��),false��Ϣû�д���
	//if("img_loaded" == get_client().obj_msg_tmp.get_type())
	//	alert("amachine:img_loaded,"+get_client().base+"\n");
	var local_uid = get_client().get_user_id();
	if(get_client().obj_msg_tmp.is_server() && (local_uid == get_client().obj_msg_tmp.get_poster_id())){
		return true; //���ط�������Ϣ�ٴδӷ������յ������ٴ���
	}	
	var s_cmd = get_client().obj_msg_tmp.get_cmd();

	if(null != get_current_room()){ //�Ƚ�������ʵ�崦��
		//if("img_loaded" == s_cmd)
		//	alert("aaa\n");
		if(get_current_room().deal_msg(s_cmd))
			return true; //��ǰ�����Ѵ���	
	}
	//if("img_loaded" == s_cmd)
	//	alert("aaa\n");
	return get_client().deal_msg(s_cmd);
}

//-----------------end ��Ϣ������----------------

//-----------------�ͻ���------------------------
function c_client()
{
	//�ͻ��˶���
	//����:��
	//���:��
//public:
	this.obj_msg_tmp = new c_event_msg;  //��ʱ��Ϣ����
	//deal_msg(); //��Ϣ����
	//get_id(); //�û�ID
	//base_id(); //����ID
	//request_broadcast(); //���ع㲥
	//show_msg(); //��ʾ��Ϣ
//private:
	this.id = -1; //�û�ID
	this.pswd = ""; //����
	this.str_gs = ""; //���ع㲥��Ϣ
//��ʼ
	var id_tmp = get_cookie("fc_uniqid");
	id_tmp = null;
	if(null == id_tmp){ //��ֲID
		id_tmp = String(Math.round(Math.random() * 2147483647));
		SetCookie("fc_uniqid",id_tmp);
	}
	var int_id = parseInt(id_tmp,10);
	if(int_id < 1)
		return;
	this.id = int_id;
	//�㲥��Ϣ
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
	//����ID
	//����:��
	//���:����
	return 123;
}
function c_client.prototype.get_id()
{
	//�û�ID
	//����:��
	//���:����
	return this.id;
}
function c_client.prototype.deal_msg()
{
	//��Ϣ����
	//����:��
	//���:��
	var s_cmd = this.obj_msg_tmp.get_cmd();
	switch(s_cmd){
		case "login": //��¼�ɹ�
			//break;
			//alert("��¼�ɹ�");
			var sid = this.obj_msg_tmp.get_content();
			if(this.id != parseInt(sid,10))
				break;
			//��ʼ����
			//alert("������");
			main_start(); //���翪ʼ
			break;
		case "chat_msg": //������Ϣ
			//alert("���ܵ�����Ϣ");
			var msg = unescape(this.obj_msg_tmp.get_content());
			var poster = this.obj_msg_tmp.get_poster_id();
			if(this.id == parseInt(poster))
				break; //�Լ��Ĳ�����
			//obj.value = (poster+":"+msg+"\n"+obj.value);
			this.show_msg(poster+":"+msg+"\n");
			alert_msg(); //��ʾ����Ϣ
			break;
		default:
			break;
	}
}
function c_client.prototype.request_broadcast()
{
	//�����������㲥
	//���룺��
	//�����true,false
	//var msg = "gs-|--|-200200067`|-|-400400003846-|-local";
	//alert(this.str_gs);
	g_commu.post_msg(this.str_gs,1);
	return true;
}
function c_client.prototype.show_msg(s)
{
	//��ʾ��Ϣ
	//����:s(string)��Ϣ
	//���:��
	var obj = document.all["txt_msglist"];
	obj.value = (s+obj.value);
}

//---------------end  �ͻ���---------------------


//----------------------�¼���Ϣ��-----------------------------
//��Ϣʾ��
//gs-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //ȡ�㲥
//chat_msg-|-hello-|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local//����
//login-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //��¼
//logout-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //����
//inroom-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //���뷿��
//outroom-|--|-200200067`|d.rYWeqPmMF0w-|-400400003846-|-local //�뿪����
//������������û���
//request_up_name-|-200200067-|-123-|-123-|-local 
//up_name-|-200200067`|С��-|-sys-|-123-|-server //�����û���
//��Ϣ��,��Ϣ����,��Ϣ��������Ϣ,��Ϣ������λ��,������Ϣ
function c_event_msg(msg)
{
public:
	//c_event_msg
	//set_default(id,pswd);
	//init_default
	//query_msg
	//load_msg_str
	//set_receiver(); //���ý�����
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
	//get_receiver(); //������
private:
	//�ͻ��˼����������ж��������ݴ��¼���Ϣ������
	this.str_msg = "";  //������Ϣ�ַ�����ʽ
	this.int_count = 5;  //��Ϣ�ֳɼ�����(��Ҫ����)
	//�¼�����,��ʱ�ͻ��˴��ֶ�ֻ��һ��ֵ��ʾ�������ͣ��Ǽ�ʱģʽʱ
	//�����ֶ�������ֵ���÷ָ����ֿ����ֱ���Զ����������ķ���
	this.str_type = "";  
	this.str_content = "";  //�¼�����

	//this.str_poster = "";  //������,id������
	this.s_uid = ""; //��Ϣ������ID
	this.s_upswd = ""; //��Ϣ����������
	this.s_receiver = ""; //��Ϣ������ID
	
	this.int_roomid = "";  //�����(Ƶ��)
	
	//this.str_other = "";   //������Ϣlocal/server/unsend`|�����������
	this.other_local = ""; //��Ϣλ��local/server/unsend
	this.other_num = ""; //�����������(�ͻ�����ϢID)

	this.df_uid = "";  //ȱʡ��Ϣ������ID
	this.df_upswd = ""; //ȱʡ��Ϣ����������
	this.to_server = 1; //�������ַ�����1/2(����/����)
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

	//set_receiver(); //���ý�����
	this.set_receiver = function(str){ this.s_receiver = str;}
	this.set_type = function(info){ this.str_type = info;}
	this.set_content = function(info){ this.str_content = info;}
	this.set_poster = function(info){ this.str_poster = info;}
	this.set_roomid = function(info){ this.int_roomid = info;}
	this.set_room_id = function(){ return this.set_roomid(arguments[0]);}
	this.set_other = function(info){ throw(new c_err("msg.js"));} //����

	this.set_uid = function(str){ this.s_uid = str;}
	this.set_upswd = function(str){ this.s_upswd = str;}

	//------------start ---------
	if("" != msg && "string" == typeof(msg))
		return this.init(msg);
	return false;
}
function c_event_msg.prototype.clear_poster()
{
	this.s_uid = ""; //��Ϣ������ID
	this.s_upswd = ""; //��Ϣ����������
	this.s_receiver = ""; //��Ϣ������ID
}
function c_event_msg.prototype.init(msg)
{
	this.load_msg_str(msg);
}
function c_event_msg.prototype.load_msg_str(msg)
{
	//��ʼ��
	//msg���ַ��������������¼���Ϣ����Ϣ
	//��������true,�쳣����false
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
	//������Ϣȱʡֵ
	//����:id��Ϣ������ID��pswd��Ϣ����������
	//���:��
	this.df_uid = id;  //ȱʡ��Ϣ������ID
	this.df_upswd = pswd; //ȱʡ��Ϣ����������
}
function c_event_msg.prototype.init_default(roomid)
{
	//��ʼ��ȱʡֵ,��������true,�쳣����false
	//����:roomid�û���ǰ����ID
	//���:true,false
	this.str_type = "";  
	this.str_content = "";  //�¼�����
	
	this.set_uid(this.df_uid);
	this.set_upswd(this.df_upswd);
	this.s_receiver = ""; //��Ϣ������ID
	if("undefined" != typeof(roomid))
		this.set_roomid(roomid);
	this.set_other_local("local");
	this.other_num = ""; //��Ϣ���
	return true;
}
function c_event_msg.prototype.query_msg()
{
	//������Ϣ������������������Ϣ
	//����������Ϣ���쳣����false
	var key = this.get_split_key();
	//this.get_content() ����Ϊ��
	if(this.get_type() != "" &&  this.get_poster() != "" && this.get_roomid() != "" && this.get_other() != ""){
		return this.get_type()+key+this.get_content()+key+this.get_poster()+key+this.get_roomid()+key+this.get_other();
	}
	return false;
}
function c_event_msg.prototype.get_split_key(flag)
{
	//return get_split_key(flag);
	
	//���طָ���
	var result = "-|-";
	switch(flag){
		case 2:  //�ڶ���ָ���
			result = "`|";
			break;
		case 3:  //������
			result = "|`";
			break;
		case 4:  //���Ĳ�
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
	//���str_poster
	//����һ�����飬�쳣����false
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
	//���str_content
	//����һ�����飬�쳣����false
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
	//����str_content�ָ����ĵ�һ��
	//���룺��
	//�������һ���ַ����������ڵ�һ���false
	var arr = this.query_content_arr();
	if(false == arr)
		return false;
	return arr[0];
}
function c_event_msg.prototype.get_content_second()
{
	//����str_content�ָ����ĵڶ���
	//���룺��
	//������ڶ����ַ����������ڵڶ����false
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
	//��ѯ��Ϣ�Ƿ񱾵���Ϣ���Ƿ���true,���򷵻�false
	var local = this.get_local();
	if(local == "local")
		return true;
	return false;
}
function c_event_msg.prototype.is_server()
{
	//��ѯ��Ϣ�Ƿ�Զ����Ϣ���Ƿ���true,���򷵻�false
	var local = this.get_local();
	if(local == "server")
		return true;
	return false;
}
function c_event_msg.prototype.get_local()
{
	//������Ϣԭ����,server/local
	//����:��
	//���:server/local���ַ���,�쳣����false
	return this.other_local;
}
function c_event_msg.prototype.set_msg_id(id)
{
	//������Ϣ���
	//����:��Ϣ���,����
	//���:��
	if("number" != typeof(id))
		return;
	this.other_num = String(id);
}
function c_event_msg.prototype.get_msg_id()
{
	//������Ϣ���
	//����:��
	//���:��Ϣ����ַ���
	return this.other_num;
}
function c_event_msg.prototype.set_other_local(str)
{
	//������Ϣ��λ�ã�
	//���룺λ���ַ�����local��server
	//�������
	if("string" != typeof(str))
		return;
	this.other_local = str;	
}
function c_event_msg.prototype.set_poster_id(str)
{
	//���÷�����ID
	//���룺str�û�ID
	//�������
	if("undefined" != typeof(str))
		this.s_uid = str;
}
function c_event_msg.prototype.set_poster_pswd(str)
{
	//���÷���������
	//���룺�����ַ���
	//�������
	if("undefined" != typeof(str))
		this.s_upswd = str;
}
//-----------end c_event_msg----------------------------------

//---------------------���ж�������---------------------
function queue()
{
	//����
	//���룺��
	//�������
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
		this.count = 0;  //Ԫ�ؼ�����
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
	//��Ϣ���й�����
public:
	//push(); //ѹ����Ϣ	
	//process(); //������Ϣ
	//confirm_msg(id); //��Ϣ�յ�ȷ�ϡ�
	//__c_msg_queue(); //��������
	//stats(); //״̬	
private:
	//count_confirm(); //�ȴ�ȷ�ϵ���Ϣ��
	//msg_server(); //�ͻ�����ʱ��Ϣ���󱻷������ַ�����(����/����)
	//hava_new(); //�Ƿ�������Ϣ
	//get_new(); //����Ϣ����ɵ�һ��
	//pop(); //������ɵ���Ϣ
	//process_confirm
	//get_uniqueid(); //ȡ����Ϣ���
	//confirm_msg(id); //������ϢIDȡ�ȴ�ȷ�ϵ���Ϣ
	this.server_msg = null; //ͨѶ��
	this.queue_msg = new queue; //����
	this.iMsgUniqueId = 1; //��ϢΩһ���,1-10000֮��ѭ��
	this.msg_random = parseInt(Math.random()*9999); //������ϢID�ϵ������
	this.vec_confirm = null; //�ȴ��յ�ȷ�ϵ���Ϣ����
	this.timeout = 0; //ȷ�϶��г�ʱ������	
	//--------------
}
function c_msg_queue.prototype.init_server_msg()
{
	//����ͨѶ��
	//����:��
	//���:��
	//var url = "http://mwjxhome.3322.org:8088/gm_s";
	//var url = "http://www.mwjx.com:8088/gm_s";
	var url = "http://localhost:8088/gm_s";
	if("localhost" != document.domain)
		url = ("http://"+document.domain+":8088/gm_s"); 
	this.server_msg = new c_server_msg(); //��ʼ��ͨѶ��
	this.server_msg.set_fast_url(url);
	this.vec_confirm = new vector; //("c_event_msg")
}
function c_msg_queue.prototype.stats()
{
	//״̬
	//����:��
	//���:�ַ���
	var str = "";
	var num = this.count_confirm();
	str += ("�ȴ�������ȷ�ϵ���Ϣ��:"+String(num)+"\n");
	if(num < 1)
		return str;
	var obj_it = new iterator(this.vec_confirm.begin());
	var it_end = new iterator(this.vec_confirm.end());
	while(obj_it.get_index() != it_end.get_index()){
		str += (this.vec_confirm.obj(obj_it)+"\n");
		obj_it.next(); //��һ��
	}	
	return str;
}
function c_msg_queue.prototype.count_confirm()
{
	//�ȴ�ȷ�ϵ���Ϣ��
	//����:��
	//���:��Ϣ������
	if(null == this.vec_confirm)
		return 0;
	return this.vec_confirm.size();
}
function c_msg_queue.prototype.process_confirm()
{
	//���ȷ�϶�����Ϣ�Ƿ�Ҫ�ط���ɾ����ʱ��Ϣ
	//����:��
	//���:��
	if(null == this.vec_confirm)
		return;
	if(this.vec_confirm.empty())
		return;
	if(this.vec_confirm.empty() && (0 != this.vec_confirm.size()))
		throw(new c_err("msg_queue.js"));
	if(this.timeout++ < 400)
		return; //400*30����=12�볬ʱ
	//�ط���ʱ����Ϣ,��һ��
	var obj_it = new iterator(this.vec_confirm.begin());
	var msg = this.vec_confirm.obj(obj_it);
	this.vec_confirm.erase(obj_it); //ɾ��Ԫ��
	this.queue_msg.push(msg); //ֱ�ӷŽ�����,���ı���Ϣ���	
	this.timeout = 0;
}
function c_msg_queue.prototype.confirm_msg(id)
{
	//������ϢIDȡ�ȴ�ȷ�ϵ���Ϣ
	//����:id����ϢID�ַ���
	//���:����Ϣ������Ϣ�ַ���(ɾ������Ϣ),���򷵻ؿ��ַ���
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
			this.vec_confirm.erase(obj_it); //ɾ��Ԫ��
			return str;
		}
		obj_it.next();
	}	
	return "";
}
function c_msg_queue.prototype.process()
{
	//������Ϣ,���ط��ͺ���,����ֱ�Ӵ���
	//����:��
	//���:��
	//û������Ϣ,ֱ�ӷ���
	this.process_confirm(); //ȷ�϶����Ƿ���ȷ�ϳ�ʱ
	if(!this.hava_new())
		return; //û������Ϣ
	var sMsg =	this.get_new();
	if(!get_client().obj_msg_tmp.load_msg_str(sMsg)){
		this.pop(); 
		return; //��Ϣ��ʽ��Ч,ֱ��ɾ������Ϣ
	}
	//if("chat_msg" == get_client().obj_msg_tmp.get_cmd())
	//	alert(sMsg);
	//����Ϣ��Ҫ����,����,����ȷ�϶��еȴ�ȷ��,
	//����ʧ��ֱ�ӷ���,�ɹ�ɾ����Ϣ����	
	if(get_client().obj_msg_tmp.is_local()){ //������Ϣ
		if(null == this.server_msg)
			throw(new c_err("msg_queue.js"));
		if(!this.server_msg.can_send())
			return;		
		var to_server = this.msg_server();
		if(this.server_msg.post_msg(sMsg,to_server)){ //���ͳɹ�
			//if(-1 != sMsg.indexOf("down_data"))
			//	alert(sMsg);
			this.pop(); 
			if(!this.confirm_require()) //����ȷ��
				return get_msg_deal().deal_msg(); //ֱ������
			this.vec_confirm.push_back(sMsg); //�ŵ��ȴ�ȷ�ϼ�����
		} 
		return; //����ʧ��,�´�����
	}	
	//��Ҫ���͵���Ϣֱ�ӽ����������(server/unsend)
	//������ɺ�ɾ����Ϣ	
	//�Ƿ�����Ϣ,Զ����Ϣ
	var id = get_client().obj_msg_tmp.get_msg_id();
	//�����Ѿ�ȷ�ϵ���Ϣ
	var str_confirm = this.confirm_msg(id);
	if("" != str_confirm){
		if(get_client().obj_msg_tmp.load_msg_str(str_confirm))
			get_msg_deal().deal_msg();	
		//����Զ����Ϣ
		if(get_client().obj_msg_tmp.load_msg_str(sMsg)){
			if(get_msg_deal().deal_msg())
				this.pop();
		}
		return;
	}	
	//����Զ����Ϣ��unsend��Ϣ
	//if("img_loaded" == get_client().obj_msg_tmp.get_type())
	//	alert(get_client().obj_msg_tmp.get_type());
	if(get_msg_deal().deal_msg())
		this.pop();	
}
function c_msg_queue.prototype.msg_server()
{
	//�ͻ�����ʱ��Ϣ���󱻷������ַ�����
	//����:��
	//���:1/2(����/����)����
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
	//��ǰ�ͻ�����ʱ��Ϣ�Ƿ���Ҫȷ�ϻظ�
	//����:��
	//���:true��Ҫȷ��,false����Ҫ
	if("gs" == get_client().obj_msg_tmp.get_cmd())
		return false; //Ŀǰֻ��������Ϣ����ȷ��
	return true;
}
function c_msg_queue.prototype.hava_new()
{
	//�Ƿ�������Ϣ
	//����:��
	//���:������Ϣ����true,���򷵻�false
	return (this.queue_msg.empty())?false:true;
}
function c_msg_queue.prototype.get_new(){ return this.queue_msg.front();}
function c_msg_queue.prototype.pop(){ return this.queue_msg.pop();}
function c_msg_queue.prototype.push(msg)
{
	//��ͻ�����Ϣ����ѹ��һ����Ϣ
	//����:msg����Ϣ�ַ���
	//���:��
	if("string" != typeof(msg))
		return;
	//����Ҫȷ�ϵ���Ϣ����Ωһ���,������ֻ�Ƕ�ÿ���ͻ�����һ��ʱ����Ωһ
	var obj_msg = new c_event_msg(msg);
	if(!obj_msg.is_local())
	   return this.queue_msg.push(msg); //������Ϣ,�ӱ��
	obj_msg.set_msg_id(this.get_uniqueid());
	//alert(obj_msg.query_msg());
	this.queue_msg.push(obj_msg.query_msg());
}
function c_msg_queue.prototype.driver_id()
{
	//������ID
	if(null == g_driver())
		return 123;
	return g_driver().get_id();
}
function c_msg_queue.prototype.get_uniqueid()
{
	//ȡ����Ϣ���,��ǰ������ID�ӱ��
	//����:��
	//���:����ַ���
	if(this.iMsgUniqueId > 10000)
		this.iMsgUniqueId = 1;
	//�û�IDȡʮ��λ,��λ,ʮλ,��λ���IDֵ
	//IDֵ��3λ�����,�ټ���Ϣ����γ����ձ��
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
	//��������
	//����:��
	//���:��
	chatok("msg_queue.js,c_msg_queue,__c_msg_queue,����\n");
}


//------------------cookie----------------
function get_cookie(name)
{
	//ȡcookieֵ��
	//����:name(string)cookie������
	//���:ֵ�ַ������쳣����null
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