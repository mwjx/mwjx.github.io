//------------------------------
//create time:2007-1-31
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��ҳ�ű�
//------------------------------
//�ղر�վƯ��
lastScrollY=0;
write_favorite();

function login_reg_out(flag)
{
	//��¼��ע�ᣬ�˳�
	//����:flag(int)1/2/3(��¼/ע��/�˳�)
	//���:true�ɹ�,falseʧ��
	if(1 != flag && 2 != flag && 3 != flag)
		return false;
	var name = document.all["username"].value;
	var pswd = document.all["password"].value;
	if(1 == flag || 2 == flag){ //����û��������Ƿ�Ϊ��
		if("" == name || "" == pswd){
			var str = "";
			if(1 == flag)
				str = "��¼ʧ�ܣ�������������������û���������";
			else
				str = "ע��ʧ�ܣ������������������Ҫע����û���������";
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
	document.all["action"].value = action;//���ö���ֵ
	//alert(document.all["action"].value);
	return true;
}
function main_init()
{
	//alert("��ʼ����ҳ");
	//document.all["td_logininfo"].style.display = "block";
	//document.all["td_logininfo"].innerHTML = "XXXXXX";
	//alert("��ҳ��ʼ��");
	//return;
	//document.all["td_logininfo"].style.display = "block";

	if((null == get_cookie("username")) || ("" == get_cookie("username"))){  //δ��¼
		//document.all["td_logininfo"].innerHTML = "δ��¼";
	
		return;				
	}
	else{
		//document.all["td_logininfo"].innerHTML = "�Ѿ���¼";

	}
	//return;
	//�Ѿ���¼
	document.all["td_loginbox"].style.display = "none";
	document.all["td_logininfo"].style.display = "block";
	//var obj = document.all["td_loginbox"];
	var html = ""; //(get_cookie("username"))+",";
	html+= "��ӭ�����ľ�ѡ<br/><a href=\"/mwjx/home.php\"><b>�ҵ�����</b></a><br/>";
	html += "<a href=\"#\" onclick=\"javascript:local_logout();\">�˳���¼</a>";
	document.all["td_logininfo"].innerHTML = html;
}
function local_logout()
{
	//�˳���¼
	SetCookie("username","");
	SetCookie("userpass","");
}

//<!--2007-8-4 18:23:34  -- ���JS:Ư�����ղ�-->


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
	var suspendcode="<DIV id=\"web_ad\" style='right:5px;POSITION:absolute;TOP:200px; width:85px;height:85px;border:0px solid #ddd;'><a onclick=\"window.external.addFavorite('http://www.mwjx.com','mwjx.com���ľ�ѡ����Ĭ��Ц���ģ�');\" href='#' target='_self'><img src='/mwjx/images/01.gif' alt='�����ղ�' border=\"0\"/></a></div>"
	document.write(suspendcode);
	window.setInterval("heartBeat()",30);
}
