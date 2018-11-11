//------------------------------
//create time:2007-8-7
//creater:zll
//purpose:邮寄文章
//------------------------------
function email_page()
{
	//邮寄页面
	//输入:无
	//输出:无
	//return alert("aa");
	var tmp = get_cookie("email_page");
	if(null == tmp)
		tmp = "";
	var name = window.prompt("请输入要发送到哪个邮箱，按确定，稍等片刻系统会返回成功或失败的发送结果",tmp);
	//if(false == name)
	//	return;
	if("" == name)
		return alert("邮箱地址不能为空");
	if(!check_email(name))
		return alert("怀疑你输入的邮箱无效，请换个邮箱试试");
	document.all["hd_email"].value = name;
	SetCookie("email_page",name); //以备下次使用
	form_mailpage.submit();
}
function check_email(email)
{
	//mail地址有效性检测，有效返回true，无效返回false
	//输入:email邮箱字符串
	//输出:true,false
	if("undefined" == typeof(email) || "" == email)
		return false;
	var re=/^[\w.-]+@([0-9a-z][\w-]+\.)+[a-z]{2,3}$/i;
	if(re.test(email))
		return true;
	return false;
}