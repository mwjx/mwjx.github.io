//------------------------------
//create time:2007-8-20
//creater:zll
//purpose:��̬����ҳ
//------------------------------
function check_confcode(str)
{
	//�����֤���Ƿ���д
	//����:str(string)��֤���������
	//���:true����,falseδ��д
	if("" == document.all[str].value){
		alert("����д��֤��");
		return false;
	}
	return true;
}
function reply()
{
	//�ظ�
	//����:��
	//���:��
	var content = document.all["message"].value;
	if("" == content)
		return alert("�������ݲ���Ϊ��");
	if(content.length > 10000)
		return alert("���Գ��Ȳ��ܳ���10000");
	//return alert(document.all["aid"].value);
	if("" == document.all["aid"].value)
		return alert("�쳣������IDΪ��");
	if("" == document.all["reply_type"].value)
		return alert("�쳣����������Ϊ��");
	if("" == document.all["fun"].value)
		return alert("�쳣�����ýӿ�Ϊ��");
	if(!check_confcode('conf_reply'))
		return;
	//if("" == document.all["conf_reply"].value)
	//	return alert("����д��֤��");
	//alert("�ظ�����δ���");	
	//alert("�ظ�:"+content);
	//return;
	//return alert("aa="+document.all["r_cid"].value);
	//----------�ύ---------
	//alert(document.all["frmsubmit"]);
	//document.all["hd_clist"].value = list;
	//document.all["frmsubmit"].action = '../cmd.php';
	//document.all["txt_title"].value = list;
	//alert(document.all["frmsubmit"].action);
	document.all["frmsubmit"].submit();

}

