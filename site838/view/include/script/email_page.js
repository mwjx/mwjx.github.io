//------------------------------
//create time:2007-8-7
//creater:zll
//purpose:�ʼ�����
//------------------------------
function email_page()
{
	//�ʼ�ҳ��
	//����:��
	//���:��
	//return alert("aa");
	var tmp = get_cookie("email_page");
	if(null == tmp)
		tmp = "";
	var name = window.prompt("������Ҫ���͵��ĸ����䣬��ȷ�����Ե�Ƭ��ϵͳ�᷵�سɹ���ʧ�ܵķ��ͽ��",tmp);
	//if(false == name)
	//	return;
	if("" == name)
		return alert("�����ַ����Ϊ��");
	if(!check_email(name))
		return alert("�����������������Ч���뻻����������");
	document.all["hd_email"].value = name;
	SetCookie("email_page",name); //�Ա��´�ʹ��
	form_mailpage.submit();
}
function check_email(email)
{
	//mail��ַ��Ч�Լ�⣬��Ч����true����Ч����false
	//����:email�����ַ���
	//���:true,false
	if("undefined" == typeof(email) || "" == email)
		return false;
	var re=/^[\w.-]+@([0-9a-z][\w-]+\.)+[a-z]{2,3}$/i;
	if(re.test(email))
		return true;
	return false;
}