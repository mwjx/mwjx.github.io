//------------------------------
//create time:2007-8-20
//creater:zll
//purpose:静态文章页
//------------------------------
function check_confcode(str)
{
	//检查验证码是否填写
	//输入:str(string)验证码输入框名
	//输出:true已填,false未填写
	if("" == document.all[str].value){
		alert("请填写验证码");
		return false;
	}
	return true;
}
function reply()
{
	//回复
	//输入:无
	//输出:无
	var content = document.all["message"].value;
	if("" == content)
		return alert("留言内容不能为空");
	if(content.length > 10000)
		return alert("留言长度不能超过10000");
	//return alert(document.all["aid"].value);
	if("" == document.all["aid"].value)
		return alert("异常，文章ID为空");
	if("" == document.all["reply_type"].value)
		return alert("异常，跟贴类型为空");
	if("" == document.all["fun"].value)
		return alert("异常，调用接口为空");
	if(!check_confcode('conf_reply'))
		return;
	//if("" == document.all["conf_reply"].value)
	//	return alert("请填写验证码");
	//alert("回复功能未完成");	
	//alert("回复:"+content);
	//return;
	//return alert("aa="+document.all["r_cid"].value);
	//----------提交---------
	//alert(document.all["frmsubmit"]);
	//document.all["hd_clist"].value = list;
	//document.all["frmsubmit"].action = '../cmd.php';
	//document.all["txt_title"].value = list;
	//alert(document.all["frmsubmit"].action);
	document.all["frmsubmit"].submit();

}

